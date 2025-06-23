<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransportController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\AcademicSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    
    // Register Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.submit');
    
    Route::middleware(['auth'])->group(function () {
        // role and permission management routes
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        // User Management Route
        Route::resource('users', UserController::class);
        // Logout Route
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        // Dashboard Route
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('get-sections/{class_id}', [DashboardController::class, 'getSections'])->name('get.sections');
        // Student Management Route
        Route::get('students/promote', [StudentController::class, 'studentPromote'])->name('students.promote');
        Route::post('students/promote-submit', [StudentController::class, 'promoteSubmit'])->name('students.promoteSubmit');
        Route::get('/get-students/{classId}/{sectionId?}', [StudentController::class, 'getStudents'])->name('get.students');
        Route::get('/students/tc', [StudentController::class, 'TC'])->name('students.tc');
        Route::patch('/student-enrollments/generate-tc/{id}', [StudentController::class, 'markTcGenerated'])->name('students.markTcGenerated');

        Route::resource('students', StudentController::class);
        // Transport Management Route
        Route::resource('transports', TransportController::class);
        // session settings route
        Route::resource('academic-sessions', AcademicSessionController::class);
        // Attendance Management Route
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');

        //class, subject and teacher management routes
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('class-subjects', ClassSubjectController::class);
        // Teacher Management Routes
        Route::get('teacher-class-subjects-list', [TeacherController::class, 'teacherClassSubjectList'])->name('teacher.class.subjects.list');
        Route::get('teacher-class-subjects-create', [TeacherController::class, 'teacherClassSubjectCreate'])->name('teacher.class.subjects.create');
        Route::post('teacher-class-subjects-store', [TeacherController::class, 'teacherClassSubjectStore'])->name('teacher.class.subjects.store');
        Route::delete('teacher-class-subjects/{id}', [TeacherController::class, 'teacherClassSubjectDelete'])->name('teacher.class.subjects.delete');
        Route::get('teacher-class-subjects/{id}/edit', [TeacherController::class, 'teacherClassSubjectEdit'])->name('teacher.class.subjects.edit');
        Route::get('get-teacher-assignments/{teacherId}', [TeacherController::class, 'getTeacherAssignments']);
        Route::get('get-sections-subjects/{classId}', [TeacherController::class, 'getSectionsAndSubjects']);
        Route::get('get-assignment-row/{index}', [TeacherController::class, 'getAssignmentRow']);
        Route::resource('teachers', TeacherController::class);

        // setting
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings/store', [SettingController::class, 'store'])->name('settings.store');

        Route::get('fee', [FeeController::class, 'fee'])->name('fee');
        Route::get('get-student-fee/{sessionId}/{classId}/{sectionId?}', [FeeController::class, 'getStudents'])->name('get.student.fee');
        Route::get('students/fee/generate-bulk', [FeeController::class, 'generateBulk'])->name('student.fee.generate.bulk');
        Route::post('students/fee/store', [FeeController::class, 'feeStore'])->name('student.fee.store');
        Route::post('students/other-charges', [FeeController::class, 'storeOtherCharges'])->name('student.other.charges.store');

        
    });
});
