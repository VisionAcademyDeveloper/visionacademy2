<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api', 'roles:admin|teacher')->get('/user', function (Request $request) {
    return $request->user();
});
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', 'API\Auth\RegisterController@register');
Route::post('/login', 'API\Auth\LoginController@login');



/*
|--------------------------------------------------------------------------
| University Routes
|--------------------------------------------------------------------------
*/

Route::get('/university/all', 'API\University\UniversityController@getAllUniversities');
Route::get('/university/{id}', 'API\University\UniversityController@getUniversity');

/*
|--------------------------------------------------------------------------
| Department Routes
|--------------------------------------------------------------------------
*/
Route::get('/department/all', 'API\Department\DepartmentController@getAllDepartments');
Route::get('/department/{id}', 'API\Department\DepartmentController@getDepartment');




/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:teacher']], function () {

    Route::post('/course', 'API\Course\CourseController@create')->name('course.post');
    Route::put('/course/{id}/update', 'API\Course\CourseController@update')->name('course.update');
    Route::delete('/course/{id}/delete', 'API\Course\CourseController@delete')->name('course.delete');
});

Route::get('/course/all', 'API\Course\CourseController@getAllCourses')->name('course.getAll');
Route::get('/course/{id}', 'API\Course\CourseController@getCourse')->name('course.get');
Route::get('/department/{id}/courses', 'API\Course\CourseController@getCoursesByDepartment')->name('course.getByDep');
