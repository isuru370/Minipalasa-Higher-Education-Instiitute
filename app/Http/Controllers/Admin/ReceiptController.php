<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AdmissionPayment;
use App\Models\ExtraIncome;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        // Student Payments
        $payments = Payment::query()
            ->select([
                'id',
                'receipt_number',
                'amount',
                'created_at',
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'receipt_number' => $item->receipt_number,
                    'type' => 'Student Payment',
                    'amount' => $item->amount,
                    'date' => $item->created_at,
                    'url' => route(
                        'admin.payments.index',
                        $item->id
                    ),
                ];
            });

        // Admission Payments
        $admissions = AdmissionPayment::query()
            ->select([
                'id',
                'receipt_number',
                'amount',
                'created_at',
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'receipt_number' => $item->receipt_number,
                    'type' => 'Admission Payment',
                    'amount' => $item->amount,
                    'date' => $item->created_at,
                    'url' => route(
                        'admin.admission-payments.show',
                        $item->id
                    ),
                ];
            });

        // Extra Incomes
        $extraIncomes = ExtraIncome::query()
            ->select([
                'id',
                'receipt_number',
                'amount',
                'created_at',
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'receipt_number' => $item->receipt_number,
                    'type' => 'Extra Income',
                    'amount' => $item->amount,
                    'date' => $item->created_at,
                    'url' => route(
                        'admin.extra-incomes.show',
                        $item->id
                    ),
                ];
            });

        $receipts = $payments
            ->merge($admissions)
            ->merge($extraIncomes);

        // Receipt Number Filter
        if ($request->filled('receipt_number')) {

            $receipts = $receipts->filter(function ($item) use ($request) {

                return str_contains(
                    strtolower($item['receipt_number'] ?? ''),
                    strtolower($request->receipt_number)
                );
            });
        }

        // Type Filter
        if ($request->filled('type')) {

            $receipts = $receipts->where(
                'type',
                $request->type
            );
        }

        // Date From Filter
        if ($request->filled('from_date')) {

            $receipts = $receipts->filter(function ($item) use ($request) {

                return $item['date']->format('Y-m-d')
                    >= $request->from_date;
            });
        }

        // Date To Filter
        if ($request->filled('to_date')) {

            $receipts = $receipts->filter(function ($item) use ($request) {

                return $item['date']->format('Y-m-d')
                    <= $request->to_date;
            });
        }

        $receipts = $receipts
            ->sortByDesc('date')
            ->values();

        $totalAmount = $receipts->sum('amount');
        $totalReceipts = $receipts->count();

        return view(
            'admin.receipts.index',
            compact(
                'receipts',
                'totalAmount',
                'totalReceipts'
            )
        );
    }
}
