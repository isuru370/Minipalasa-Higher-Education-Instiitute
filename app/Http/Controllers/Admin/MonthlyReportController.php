<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Teacher\TeacherSalaryReportExport;
use App\Http\Controllers\Controller;
use App\Models\PaymentSplitSnapshot;
use App\Models\Teacher;
use App\Models\TeacherPayment;
use App\Models\TeacherSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::select(
            'id',
            'custom_id',
            'initials'
        )->get();

        return view('admin.monthly-report.index', compact('teachers'));
    }

    private function teacherSalaryReportData(int $year, int $month)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate   = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $teachers = Teacher::get();

        return $teachers->map(function ($teacher) use ($year, $month, $startDate, $endDate) {

            $grossIncome = PaymentSplitSnapshot::where('teacher_id', $teacher->id)
                ->whereBetween('payment_date', [$startDate, $endDate])
                ->sum('teacher_amount');

            $advanceDeduction = TeacherPayment::where('teacher_id', $teacher->id)
                ->whereBetween('payment_date', [$startDate, $endDate])
                ->sum('amount');

            $salary = TeacherSalary::where('teacher_id', $teacher->id)
                ->where('salary_year', $year)
                ->where('salary_month', $month)
                ->first();

            return [
                'teacher_id'        => $teacher->id,
                'custom_id'         => $teacher->custom_id,
                'initials'          => $teacher->initials,
                'gross_income'      => (float) $grossIncome,
                'advance_deduction' => (float) $advanceDeduction,
                'salary_paid_status' => $salary?->status ?? 'unpaid',
                'salary'            => $salary,
            ];
        })->toArray();
    }

    public function TeacherSalaryReportExcel(Request $request)
    {
        try {
            $year  = (int) $request->get('year', now()->year);
            $month = (int) $request->get('month', now()->month);

            $report = $this->teacherSalaryReportData($year, $month);

            return Excel::download(
                new TeacherSalaryReportExport($report, $year, $month),
                "teacher-salary-report-{$year}-{$month}.xlsx"
            );
        } catch (\Throwable $e) {
            Log::error('Teacher Salary Excel generation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate teacher salary excel.',
            ], 500);
        }
    }

    public function TeacherSalaryReportPdf(Request $request)
    {
        try {
            $year  = (int) $request->get('year', now()->year);
            $month = (int) $request->get('month', now()->month);

            $report = $this->teacherSalaryReportData($year, $month);

            $pdf = Pdf::loadView('admin.pdf.teacher.teacher_salary_report', [
                'report' => $report,
                'year'   => $year,
                'month'  => $month,
            ])->setPaper('a4', 'landscape');

            return $pdf->download("teacher-salary-report-{$year}-{$month}.pdf");
        } catch (\Throwable $e) {
            Log::error('Teacher Salary PDF generation failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
