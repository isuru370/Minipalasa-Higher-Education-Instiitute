<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['name' => 'Dashboard', 'route_name' => 'dashboard', 'module' => 'dashboard'],
            ['name' => 'Home', 'route_name' => 'home', 'module' => 'dashboard'],
            ['name' => 'Classes', 'route_name' => 'classes', 'module' => 'class'],

            ['name' => 'System Users - List', 'route_name' => 'system-users.index', 'module' => 'system_users'],
            ['name' => 'System Users - Create', 'route_name' => 'system-users.create', 'module' => 'system_users'],
            ['name' => 'System Users - View', 'route_name' => 'system-users.showPage', 'module' => 'system_users'],
            ['name' => 'System Users - Edit', 'route_name' => 'system-users.edit', 'module' => 'system_users'],

            ['name' => 'User Types - List', 'route_name' => 'user-types.index', 'module' => 'user_types'],
            ['name' => 'User Types - Create', 'route_name' => 'user-types.create', 'module' => 'user_types'],
            ['name' => 'User Types - View', 'route_name' => 'user-types.show', 'module' => 'user_types'],

            ['name' => 'Students - List', 'route_name' => 'students.index', 'module' => 'students'],
            ['name' => 'Students - Create', 'route_name' => 'students.create', 'module' => 'students'],
            ['name' => 'Students - Edit', 'route_name' => 'students.edit', 'module' => 'students'],
            ['name' => 'Students - View', 'route_name' => 'students.show', 'module' => 'students'],

            ['name' => 'Class Rooms - List', 'route_name' => 'class_rooms.index', 'module' => 'class_rooms'],
            ['name' => 'Class Rooms - Create', 'route_name' => 'class_rooms.create', 'module' => 'class_rooms'],
            ['name' => 'Class Rooms - Schedule', 'route_name' => 'class_rooms.schedule', 'module' => 'class_rooms'],

            ['name' => 'Teachers - List', 'route_name' => 'teachers.index', 'module' => 'teachers'],
            ['name' => 'Teachers - Create', 'route_name' => 'teachers.create', 'module' => 'teachers'],
            ['name' => 'Teachers - Edit', 'route_name' => 'teachers.edit', 'module' => 'teachers'],
            ['name' => 'Teachers - View', 'route_name' => 'teachers.show', 'module' => 'teachers'],

            ['name' => 'Admissions - List', 'route_name' => 'admissions.index', 'module' => 'admissions'],

            ['name' => 'Student Payment - Index', 'route_name' => 'student-payment.index', 'module' => 'payments'],
            ['name' => 'Student Payment - Create', 'route_name' => 'student-payment.create', 'module' => 'payments'],
            ['name' => 'Student Payment - Details', 'route_name' => 'student-payment.details', 'module' => 'payments'],

            ['name' => 'Student Attendance - Index', 'route_name' => 'student_attendance.index', 'module' => 'attendance'],
            ['name' => 'Student Attendance - Daily', 'route_name' => 'student_attendance.daily', 'module' => 'attendance'],
            ['name' => 'Student Attendance - Details', 'route_name' => 'student_attendance.details', 'module' => 'attendance'],

            ['name' => 'Payment Reason - Index', 'route_name' => 'payment_reason.index', 'module' => 'settings'],

            ['name' => 'Reports - Index', 'route_name' => 'reports.index', 'module' => 'reports'],
            ['name' => 'Reports - Daily PDF', 'route_name' => 'reports.daily.pdf', 'module' => 'reports'],

            ['name' => 'Settings - Index', 'route_name' => 'settings.index', 'module' => 'settings'],

            ['name' => 'Teacher Payment - Index', 'route_name' => 'teacher_payment.index', 'module' => 'teacher_payments'],
            ['name' => 'Teacher Payment - Expenses', 'route_name' => 'teacher_payment.expenses', 'module' => 'teacher_payments'],
            ['name' => 'Teacher Payment - Salary', 'route_name' => 'teacher_payment.salary', 'module' => 'teacher_payments'],
            ['name' => 'Teacher Payment - History', 'route_name' => 'teacher_payment.history', 'module' => 'teacher_payments'],
            ['name' => 'Teacher Payment - View', 'route_name' => 'teacher_payment.view', 'module' => 'teacher_payments'],
            ['name' => 'Teacher Payment - Salary Slip', 'route_name' => 'teacher_payment.salary-slip-exact', 'module' => 'teacher_payments'],

            ['name' => 'Institute Payment - Index', 'route_name' => 'institute_payment.index', 'module' => 'institute_payments'],
            ['name' => 'Institute Payment - Extra Income', 'route_name' => 'institute_payment.extra', 'module' => 'institute_payments'],
            ['name' => 'Institute Payment - Expenses', 'route_name' => 'institute_payment.expenses', 'module' => 'institute_payments'],
            ['name' => 'Institute Payment - Ledger', 'route_name' => 'institute_payment.ledger', 'module' => 'institute_payments'],

            ['name' => 'Receipt - View', 'route_name' => 'receipt.view', 'module' => 'receipt'],
            ['name' => 'Receipt - Download', 'route_name' => 'receipt.download', 'module' => 'receipt'],
            ['name' => 'Receipt - Thermal Print', 'route_name' => 'receipt.thermal-print', 'module' => 'receipt'],

            ['name' => 'Permission - View', 'route_name' => 'permission.index', 'module' => 'permissions'],

            ['name' => 'Exam - View', 'route_name' => 'student_exam.index', 'module' => 'exams'],
            ['name' => 'Exam - Create', 'route_name' => 'student_exam.create', 'module' => 'exams'],
            ['name' => 'Exam - Enter Marks', 'route_name' => 'student_exam.enter-marks', 'module' => 'exams'],
        ];

        foreach ($pages as $page) {
            DB::table('pages')->updateOrInsert(
                ['route_name' => $page['route_name']],
                [
                    'name' => $page['name'],
                    'module' => $page['module'],
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Pages seeded successfully!');
    }
}