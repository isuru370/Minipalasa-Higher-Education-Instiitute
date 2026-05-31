<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentIdCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Throwable;
use ZipArchive;

class StudentIDCardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = trim((string) $request->input('search', ''));

            $students = StudentIdCard::query()
                ->with([
                    'student:id,initial_name,custom_id,address1,address2,address3,img_url',
                ])
                ->select([
                    'id',
                    'student_id',
                    'card_no',
                    'status',
                    'registration_status',
                    'created_at',
                ])
                ->where('status', 'pending')
                ->where('registration_status', 'completed')
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($mainQuery) use ($search) {
                        $mainQuery->where('card_no', 'like', "%{$search}%")
                            ->orWhereHas('student', function ($studentQuery) use ($search) {
                                $studentQuery->where('initial_name', 'like', "%{$search}%")
                                    ->orWhere('custom_id', 'like', "%{$search}%")
                                    ->orWhere('address1', 'like', "%{$search}%")
                                    ->orWhere('address2', 'like', "%{$search}%")
                                    ->orWhere('address3', 'like', "%{$search}%");
                            });
                    });
                })
                ->latest('created_at')
                ->paginate(10)
                ->appends($request->query());

            return view('admin.student-id-cards.index', compact('students'));
        } catch (Throwable $e) {
            Log::error('Pending Student ID Card Fetch Error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Something went wrong.');
        }
    }

    public function print(StudentIdCard $studentIdCard)
    {
        $studentIdCard->load('student');

        return view('admin.student-id-cards.print', compact('studentIdCard'));
    }

    public function downloadSingle(StudentIdCard $studentIdCard)
    {
        try {
            $studentIdCard->load('student');

            $student = $studentIdCard->student;
            $studentKey = $student?->custom_id ?? $studentIdCard->card_no ?? $studentIdCard->id;

            $tempDir = storage_path('app/idcard-temp');
            File::ensureDirectoryExists($tempDir);

            $fileName = 'ID_' . $studentKey . '.png';
            $filePath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

            Browsershot::url(route('admin.student-id-cards.print', $studentIdCard->id))
                ->windowSize(1000, 700)
                ->deviceScaleFactor(2)
                ->waitUntilNetworkIdle()
                ->timeout(120)
                ->save($filePath);

            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
        } catch (Throwable $e) {
            Log::error('Single ID card download failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Single download failed.');
        }
    }

    public function downloadBulk(Request $request)
    {
        try {
            $data = $request->validate([
                'student_ids' => ['required', 'array', 'min:1'],
                'student_ids.*' => ['integer', 'exists:student_id_cards,id'],
            ]);

            $cards = StudentIdCard::with('student')
                ->whereIn('id', $data['student_ids'])
                ->get();

            $tempDir = storage_path('app/idcard-temp');
            File::ensureDirectoryExists($tempDir);

            $zipName = 'ID_Cards_' . now()->format('Y-m-d_His') . '.zip';
            $zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Unable to create ZIP file.');
            }

            $createdFiles = [];

            foreach ($cards as $card) {
                $card->loadMissing('student');

                $student = $card->student;
                $studentKey = $student?->custom_id ?? $card->card_no ?? $card->id;

                $pngName = 'ID_' . $studentKey . '.png';
                $pngPath = $tempDir . DIRECTORY_SEPARATOR . $pngName;

                Browsershot::url(route('admin.student-id-cards.print', $card->id))
                    ->windowSize(1000, 700)
                    ->deviceScaleFactor(2)
                    ->waitUntilNetworkIdle()
                    ->timeout(120)
                    ->save($pngPath);

                $zip->addFile($pngPath, $pngName);
                $createdFiles[] = $pngPath;
            }

            $zip->close();

            foreach ($createdFiles as $path) {
                if (is_file($path)) {
                    @unlink($path);
                }
            }

            return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
        } catch (Throwable $e) {
            Log::error('Bulk ID card download failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()->with('error', 'Bulk download failed.');
        }
    }
}