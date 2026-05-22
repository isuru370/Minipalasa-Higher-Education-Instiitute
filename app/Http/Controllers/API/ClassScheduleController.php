<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function todayClasses(Request $request)
    {
        $today = Carbon::today();
        $search = trim($request->input('search', ''));

        $classes = StudentClass::query()
            ->with([
                'grade',
                'subject',
                'teacher',
                'categoryFees' => function ($query) {
                    $query->with('category')
                        ->where('is_active', true);
                },
                'schedules' => function ($query) use ($today) {
                    $query->whereDate('class_date', $today)
                        ->whereNotIn('status', ['cancelled', 'completed'])
                        ->with('hall')
                        ->orderBy('start_time');
                },
            ])
            ->where('is_active', true)
            ->where('is_ongoing', true)
            ->whereHas('schedules', function ($query) use ($today) {
                $query->whereDate('class_date', $today)
                    ->whereNotIn('status', ['cancelled', 'completed']);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('class_name', 'like', "%{$search}%")
                        ->orWhere('class_type', 'like', "%{$search}%")
                        ->orWhere('medium', 'like', "%{$search}%")
                        ->orWhereHas('grade', function ($grade) use ($search) {
                            $grade->where('grade_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('subject', function ($subject) use ($search) {
                            $subject->where('subject_name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('teacher', function ($teacher) use ($search) {
                            $teacher->where('initials', 'like', "%{$search}%");
                        })
                        ->orWhereHas('categoryFees.category', function ($category) use ($search) {
                            $category->where('category_name', 'like', "%{$search}%");
                        });
                });
            })
            ->get()
            ->sortBy(function ($class) {
                return optional($class->schedules->first())->start_time;
            })
            ->values();

        return response()->json([
            'success' => true,
            'date' => $today->toDateString(),
            'count' => $classes->count(),
            'data' => $classes
        ]);
    }
}
