<?php

use App\Http\Controllers\AnnouncementController;
use App\Models\Extras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsertypeController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\BatchScheduleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TablecolumnController;
use App\Http\Controllers\YearlevelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::match(['get', 'post'], '/login', [LoginController::class, 'index'])->name('login');

Route::match(['get', 'post'], '/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Batch Schedule
Route::post('/batchschedule/table', [BatchScheduleController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/batchschedule/getModal', [BatchScheduleController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/batchschedule/add', [BatchScheduleController::class, 'store']);
Route::post('/batchschedule/delete', [BatchScheduleController::class, 'delete']);

// Schedule
Route::post('/schedule/table', [ScheduleController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/schedule/getModal', [ScheduleController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/schedule/add', [ScheduleController::class, 'store']);
Route::post('/schedule/delete', [ScheduleController::class, 'delete']);

// Announcement
Route::post('/announcement/table', [AnnouncementController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/announcement/getModal', [AnnouncementController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/announcement/view', [AnnouncementController::class, 'viewAnnouncement'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/announcement/add', [AnnouncementController::class, 'store']);
Route::post('/announcement/delete', [AnnouncementController::class, 'delete']);


// Office
Route::post('/office/table', [OfficeController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/office/getModal', [OfficeController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/office/add', [OfficeController::class, 'store']);
Route::post('/office/delete', [OfficeController::class, 'delete']);

// Department
Route::post('/department/table', [DepartmentController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/department/getModal', [DepartmentController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/department/add', [DepartmentController::class, 'store']);
Route::post('/department/delete', [DepartmentController::class, 'delete']);


// USER
Route::post('/user/table', [UserController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/user/getModal', [UserController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/user/add', [UserController::class, 'store']);
Route::post('/user/delete', [UserController::class, 'delete']);

// USER TYPE
Route::post('/usertype/table', [UsertypeController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/usertype/getModal', [UsertypeController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/usertype/add', [UsertypeController::class, 'store']);
Route::post('/usertype/delete', [UsertypeController::class, 'delete']);

// table column
Route::post('/tablecolumn/table', [TablecolumnController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/tablecolumn/getModal', [TablecolumnController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/tablecolumn/add', [TablecolumnController::class, 'store']);

// Reports
Route::post('/report/getModalFilter', [ReportsController::class, 'getModalFilter'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/report/generateReport', [ReportsController::class, 'generateReport'])->middleware('auth');

// Logout User
Route::post('/logout', [UserController::class, 'logout']);

// Loging user
Route::post('/login/validate', [UserController::class, 'validateLogin']);
Route::post('/login/register', [UserController::class, 'register']);

// DASHBAORD
Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth');
Route::get('/dashboard/getDashboard', [HomeController::class, 'dashboard'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');
Route::get('/dashboard/getDepartureMontly', [HomeController::class, 'departureMontlyBarChart'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');
Route::get('/dashboard/getPerformanceMontly', [HomeController::class, 'performanceMontlyBarChart'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');
Route::get('/dashboard/getPerformanceCampusMontly', [HomeController::class, 'campusMontlyBarChart'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');
Route::get('/dashboard/getCampusPie', [HomeController::class, 'campusPieStudent'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');
Route::get('/dashboard/getUserPie', [HomeController::class, 'getUserPieCount'])->withoutMiddleware([VerifyCsrfToken::class])->middleware('auth');

// Employee
Route::post('/employee/list', [EmployeeController::class, 'getTable'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/employee/getModal', [EmployeeController::class, 'getModal'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/employee/getEmployeeProfileTab', [EmployeeController::class, 'profileTab'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/employee/add', [EmployeeController::class, 'store']);
Route::post('/employee/store', [EmployeeController::class, 'updateEmployeeData']);
Route::post('/employee/profile', [EmployeeController::class, 'profile'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/employee/saveApplicant', [EmployeeController::class, 'saveApplicant'])->withoutMiddleware([VerifyCsrfToken::class]);

// Test Email Function
Route::get('/applicant/testEmail', [ApplicantController::class, 'testEmail'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/subject/syncDataSubject', [SubjectController::class, 'syncSubjectData'])->withoutMiddleware([VerifyCsrfToken::class]);

// DropDown
Route::post('/getDropdown/dropdown', [HomeController::class, 'getDropdownData'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::post('/getDropdown/dropdownInit', [HomeController::class, 'getDropdownDataInit'])->withoutMiddleware([VerifyCsrfToken::class]);




