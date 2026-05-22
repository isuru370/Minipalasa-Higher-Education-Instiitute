<?php

use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AdmissionPaymentController;
use App\Http\Controllers\Admin\OrganizerPaymentController;
use App\Http\Controllers\Admin\SystemUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentClassController;
use App\Http\Controllers\Admin\StudentClassEnrollmentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\OrganizerController;
use App\Http\Controllers\Admin\ClassCategoryController;
use App\Http\Controllers\Admin\ClassCategoryFeeController;
use App\Http\Controllers\Admin\ClassHallController;
use App\Http\Controllers\Admin\ClassScheduleController;
use App\Http\Controllers\Admin\ExtraIncomeController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\InstituteIncomeController;
use App\Http\Controllers\Admin\TeacherSalaryController;
use App\Http\Controllers\Admin\TemporaryIDCardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
})->name('welcome');


Route::get('/contact_administrator', function () {

    return view('contact_administrator');
})->name('contact_administrator');


/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

// Route::prefix('forgot-password')
//     ->group(function () {

//         Route::get(
//             '/',
//             [ForgotPasswordController::class, 'showForgotForm']
//         )->name('forgotten_password');

//         Route::post(
//             '/send-otp',
//             [ForgotPasswordController::class, 'sendOtp']
//         )->name('forgot_password.send_otp');

//         Route::post(
//             '/verify-otp',
//             [ForgotPasswordController::class, 'verifyOtp']
//         )->name('forgot_password.verify_otp');

//         Route::post(
//             '/resend-otp',
//             [ForgotPasswordController::class, 'resendOtp']
//         )->name('forgot_password.resend_otp');

//         Route::post(
//             '/reset',
//             [ForgotPasswordController::class, 'resetPassword']
//         )->name('forgot_password.reset');
//     });


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

// Login
Route::get(
    '/login',
    [LoginController::class, 'showLoginForm']
)->name('login');

Route::post(
    '/login',
    [LoginController::class, 'login']
)->name('login.post');

// Logout
Route::post(
    '/logout',
    [LoginController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
|
| Only authenticated active users
|
*/

Route::middleware([
    'auth',
    'user.active',
    'permission'
])

    ->prefix('admin')

    ->name('admin.')

    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::resource(
            'system-users',
            SystemUserController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Student Management
        |--------------------------------------------------------------------------
        */

        // Search
        Route::get(
            'students/search',
            [StudentController::class, 'search']
        )->name('students.search');

        // Resource
        Route::resource(
            'students',
            StudentController::class
        );

        // Toggle Active
        Route::patch(
            'students/{student}/toggle-active',
            [StudentController::class, 'toggleActive']
        )->name('students.toggleActive');

        // Export
        Route::get(
            'students-export/excel',
            [StudentController::class, 'exportExcel']
        )->name('students.exportExcel');

        Route::get(
            'students-export/pdf',
            [StudentController::class, 'exportPdf']
        )->name('students.exportPdf');


        /*
        |--------------------------------------------------------------------------
        | Student Image Upload
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/upload/student-image',
            [ImageUploadController::class, 'uploadStudentImage']
        )->name('upload.student.image');

        Route::post(
            '/upload/quick-photo',
            [ImageUploadController::class, 'uploadQuickPhoto']
        )->name('upload.quick.photo');

        Route::delete(
            '/upload/delete',
            [ImageUploadController::class, 'delete']
        )->name('upload.delete');


        /*
        |--------------------------------------------------------------------------
        | Teacher Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'teachers',
            TeacherController::class
        );

        Route::patch(
            'teachers/{teacher}/toggle-active',
            [TeacherController::class, 'toggleActive']
        )->name('teachers.toggleActive');

        Route::get(
            'teachers-export/excel',
            [TeacherController::class, 'exportExcel']
        )->name('teachers.exportExcel');

        Route::get(
            'teachers-export/pdf',
            [TeacherController::class, 'exportPdf']
        )->name('teachers.exportPdf');


        /*
        |--------------------------------------------------------------------------
        | Organizer Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'organizers',
            OrganizerController::class
        );

        Route::patch(
            'organizers/{organizer}/toggle-active',
            [OrganizerController::class, 'toggleActive']
        )->name('organizers.toggleActive');


        /*
        |--------------------------------------------------------------------------
        | Student Classes
        |--------------------------------------------------------------------------
        */

        Route::get(
            'student-classes/search',
            [StudentClassController::class, 'search']
        )->name('student-classes.search');

        Route::resource(
            'student-classes',
            StudentClassController::class
        );

        Route::patch(
            'student-classes/{studentClass}/toggle-active',
            [StudentClassController::class, 'toggleActive']
        )->name('student-classes.toggleActive');

        Route::patch(
            'student-classes/{studentClass}/toggle-ongoing',
            [StudentClassController::class, 'toggleOngoing']
        )->name('student-classes.toggleOngoing');

        Route::get(
            'student-classes/export/excel',
            [StudentClassController::class, 'exportExcel']
        )->name('student-classes.exportExcel');

        Route::get(
            'student-classes/export/pdf',
            [StudentClassController::class, 'exportPdf']
        )->name('student-classes.exportPdf');


        /*
        |--------------------------------------------------------------------------
        | Class Categories
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'class-categories',
            ClassCategoryController::class
        );

        Route::patch(
            'class-categories/{classCategory}/toggle-active',
            [ClassCategoryController::class, 'toggleActive']
        )->name('class-categories.toggleActive');


        /*
        |--------------------------------------------------------------------------
        | Class Category Fees
        |--------------------------------------------------------------------------
        */

        Route::get(
            'class-category-fees/by-class/{studentClass}',
            [ClassCategoryFeeController::class, 'byClass']
        )->name('class-category-fees.byClass');

        Route::resource(
            'class-category-fees',
            ClassCategoryFeeController::class
        );

        Route::patch(
            'class-category-fees/{classCategoryFee}/toggle-active',
            [ClassCategoryFeeController::class, 'toggleActive']
        )->name('class-category-fees.toggleActive');


        /*
        |--------------------------------------------------------------------------
        | Class Halls
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'class-halls',
            ClassHallController::class
        );

        Route::patch(
            'class-halls/{classHall}/toggle-active',
            [ClassHallController::class, 'toggleActive']
        )->name('class-halls.toggleActive');


        /*
        |--------------------------------------------------------------------------
        | Class Schedules
        |--------------------------------------------------------------------------
        */
        Route::get('class-schedules/category-view', [ClassScheduleController::class, 'categorySchedules'])
            ->name('class-schedules.categorySchedules');

        Route::resource(
            'class-schedules',
            ClassScheduleController::class
        );

        Route::patch(
            'class-schedules/{classSchedule}/toggle-active',
            [ClassScheduleController::class, 'toggleActive']
        )->name('class-schedules.toggleActive');

        Route::patch(
            'class-schedules/{classSchedule}/cancel',
            [ClassScheduleController::class, 'cancel']
        )->name('class-schedules.cancel');

        Route::patch(
            'class-schedules/{classSchedule}/status-update',
            [ClassScheduleController::class, 'statusUpdate']
        )->name('class-schedules.statusUpdate');

        Route::get(
            'today-classes',
            [ClassScheduleController::class, 'todayClasses']
        )->name('class-schedules.todayClasses');




        /*
        |--------------------------------------------------------------------------
        | Student Class Enrollments
        |--------------------------------------------------------------------------
        */

        // Category Students
        Route::get(
            'student-class-enrollments/class/{studentClass}/category/{classCategory}/students',
            [StudentClassEnrollmentController::class, 'categoryStudents']
        )->name('student-class-enrollments.categoryStudents');

        // Export PDF
        Route::get(
            'student-class-enrollments/class/{studentClass}/category/{classCategory}/students/pdf',
            [StudentClassEnrollmentController::class, 'categoryStudentsPdf']
        )->name('student-class-enrollments.categoryStudentsPdf');

        // Export Excel
        Route::get(
            'student-class-enrollments/class/{studentClass}/category/{classCategory}/students/excel',
            [StudentClassEnrollmentController::class, 'categoryStudentsExcel']
        )->name('student-class-enrollments.categoryStudentsExcel');

        Route::get(
            'student-class-enrollments/class/{class}/category-fee/{classCategoryFee}/students/{year}/{month}',
            [StudentClassEnrollmentController::class, 'classCategoryWisePaymentStudent']
        )->name('student-class-enrollments.category-wise-payment');

        // Resource
        Route::resource(
            'student-class-enrollments',
            StudentClassEnrollmentController::class
        );

        // Toggle Active
        Route::patch(
            'student-class-enrollments/{studentClassEnrollment}/toggle-active',
            [StudentClassEnrollmentController::class, 'toggleActive']
        )->name('student-class-enrollments.toggleActive');

        // Leave Enrollment
        Route::patch(
            'student-class-enrollments/{studentClassEnrollment}/leave',
            [StudentClassEnrollmentController::class, 'leave']
        )->name('student-class-enrollments.leave');

        // Restore Enrollment
        Route::patch(
            'student-class-enrollments/{id}/restore',
            [StudentClassEnrollmentController::class, 'restore']
        )->name('student-class-enrollments.restore');


        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        Route::get('/payments', function () {
            return view('admin.payment.index');
        })->name('payments.index');

        Route::get('/payments/today-receipt', function () {
            return view('admin.payment.today-receipt');
        })->name('payments.today-receipt');



        Route::resource(
            'admissions',
            AdmissionController::class
        );

        Route::resource(
            'admission-payments',
            AdmissionPaymentController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Attendance
        |--------------------------------------------------------------------------
        */

        Route::get('/attendance', function () {
            return view('Admin.attendance.index');
        })->name('attendance.index');

        /*
        |--------------------------------------------------------------------------
        | Organizer Payments
        |--------------------------------------------------------------------------
        */

        Route::get('/organizer-payments', [
            OrganizerPaymentController::class,
            'index'
        ])->name('organizer-payments.index');

        Route::get('/organizer-payments/{organizer}/pay', [
            OrganizerPaymentController::class,
            'pay'
        ])->name('organizer-payments.pay');

        Route::post('/organizer-payments/{organizer}/store', [
            OrganizerPaymentController::class,
            'store'
        ])->name('organizer-payments.store');

        Route::delete('/organizer-payments/{organizerPayment}', [
            OrganizerPaymentController::class,
            'destroy'
        ])->name('organizer-payments.destroy');

        Route::get('/organizer-payments/{organizer}/salary-slip', [
            OrganizerPaymentController::class,
            'salarySlip'
        ])->name('organizer-payments.salary-slip');

        Route::post('/organizer-payments/{organizer}/adjustment', [
            OrganizerPaymentController::class,
            'storeAdjustment'
        ])->name('organizer-payments.adjustment-store');


        /*
        |--------------------------------------------------------------------------
        | Teacher Salary Management
        |--------------------------------------------------------------------------
        */

        Route::get('/teacher-salaries', [
            TeacherSalaryController::class,
            'index'
        ])->name('teacher-salaries.index');

        Route::get('/teacher-salaries/{teacher}/{year}/{month}', [
            TeacherSalaryController::class,
            'show'
        ])->name('teacher-salaries.show');

        Route::post('/teacher-salaries/{teacher}/pay', [
            TeacherSalaryController::class,
            'teacherSalaryPaid'
        ])->name('teacher-salaries.pay');

        Route::get('/teacher-salaries/{teacher}/{year}/{month}/slip', [
            TeacherSalaryController::class,
            'printSalarySlip'
        ])->name('teacher-salaries.slip');


        Route::post(
            '/teacher-salaries/{teacher}/payment',
            [TeacherSalaryController::class, 'teacherPaymentStore']
        )->name('teacher-salaries.payment.store');

        Route::get('/teacher-salaries/{teacher}/{year}/{month}/details', [
            TeacherSalaryController::class,
            'paymentDetailsView'
        ])->name('teacher-salaries.payment-details');

        Route::delete('/teacher-salaries/{paymentId}', [
            TeacherSalaryController::class,
            'paymentDelete'
        ])->name('teacher-salaries.payment-delete');

        Route::get('/teacher-salaries/{teacher}/{year}/{month}/summary', [
            TeacherSalaryController::class,
            'teacherPaymentAndClassSummery'
        ])->name('teacher-salaries.payment-summary');

        /* 
        |--------------------------------------------------------------------------
        | Institute Income Report 
        |-------------------------------------------------------------------------- 
        */
        Route::get('institute-income/monthly-report', [
            InstituteIncomeController::class,
            'monthlyIncomeReport'
        ])->name('institute-income.monthly-report');

        /*
        |--------------------------------------------------------------------------
        | Extra Incomes
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'extra-incomes',
            ExtraIncomeController::class
        );

        Route::resource(
            'temporary-id-cards',
            TemporaryIDCardController::class
        )->only([
            'index',
            'create',
            'store'
        ]);;

        Route::get(
            'temporary-id-cards/preview',
            [TemporaryIDCardController::class, 'preview']
        )->name('temporary-id-cards.preview');

        Route::post(
            'temporary-id-cards/preview-generate',
            [TemporaryIDCardController::class, 'generatePreview']
        )->name('temporary-id-cards.preview-generate');

        Route::get(
            'temporary-id-cards/status',
            [TemporaryIDCardController::class, 'updateStatusPage']
        )->name('temporary-id-cards.update-status');

        Route::post(
            'temporary-id-cards/change-status',
            [TemporaryIDCardController::class, 'changeStatus']
        )->name('temporary-id-cards.change-status');

        Route::post(
            'temporary-id-cards/download-pdf',
            [TemporaryIDCardController::class, 'downloadPdf']
        )->name('temporary-id-cards.download-pdf');
    });
