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
    Route::get('/teacher/courses', 'API\Course\CourseController@getCoursesByLoggedTeacher')->name('course.getByLoggedTeacher');
});

Route::get('/course/all', 'API\Course\CourseController@getAllCourses')->name('course.getAll');
Route::get('/course/{id}', 'API\Course\CourseController@getCourse')->name('course.get');
Route::get('/department/{id}/courses', 'API\Course\CourseController@getCoursesByDepartment')->name('course.getByDep');
Route::get('/teacher/{id}/courses', 'API\Course\CourseController@getCoursesByTeacher')->name('course.getByTeacher');

/*
|--------------------------------------------------------------------------
| chapter Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:teacher']], function () {

    Route::post('/chapter', 'API\Course\ChapterController@create')->name('chapter.post');
    Route::put('/chapter/{id}/update', 'API\Course\ChapterController@update')->name('chapter.update');
    Route::delete('/chapter/{id}/delete', 'API\Course\ChapterController@delete')->name('chapter.delete');
});

Route::get('/course/{id}/chapters', 'API\Course\ChapterController@getAllChapters')->name('chapter.getAll');
Route::get('/chapter/{id}', 'API\Course\ChapterController@getChapter')->name('chapter.get');



/*
|--------------------------------------------------------------------------
| Lesson Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:teacher']], function () {

    Route::post('/lesson', 'API\Course\LessonController@create')->name('lesson.post');
    Route::put('/lesson/{id}/update', 'API\Course\LessonController@update')->name('lesson.update');
    Route::delete('/lesson/{id}/delete', 'API\Course\LessonController@delete')->name('lesson.delete');
});

Route::group(['middleware' => ['auth:api', 'roles:teacher|admin|student']], function () {
    Route::get('/chapter/{id}/lessons', 'API\Course\LessonController@getLessonsByChapter')->name('lesson.getAll');
    Route::get('/lesson/{id}', 'API\Course\LessonController@getLesson')->name('lesson.get');
});


/*
|--------------------------------------------------------------------------
| File Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:teacher']], function () {

    Route::post('/file', 'API\File\FileController@add')->name('file.post');
    Route::put('/file/{id}/update', 'API\File\FileController@update')->name('file.update');
    Route::delete('/file/{id}/delete', 'API\File\FileController@delete')->name('file.delete');
});

Route::group(['middleware' => ['auth:api', 'roles:teacher|admin|student']], function () {
    Route::get('/course/{id}/files', 'API\File\FileController@getFilesByCourse')->name('file.getAll');
    Route::get('/file/{id}', 'API\File\FileController@getFile')->name('file.get');
});


/*
|--------------------------------------------------------------------------
| File Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:teacher|admin|student']], function () {
    Route::get('/profile', 'API\Profile\ProfileController@profile')->name('profile.get');
    Route::put('/profile', 'API\Profile\ProfileController@update')->name('profile.update');
});



/*
|--------------------------------------------------------------------------
| Subscription Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth:api', 'roles:|student']], function () {
    Route::post('/subscribe', 'API\Subscription\SubscriptionController@subscribe')->name('subscribe.post');
    Route::post('/unsubscribe', 'API\Subscription\SubscriptionController@unSubscribe')->name('unsubscribe.post');
    Route::post('/submitReceipt', 'API\Subscription\SubscriptionController@submitReceipt')->name('receipt.submit');
});

Route::group(['middleware' => ['auth:api', 'roles:|admin']], function () {
    Route::post('/subscription/confirm', 'API\Subscription\SubscriptionController@confirmSubscription')->name('subscription.confirm');
    Route::post('/subscription/unconfirm', 'API\Subscription\SubscriptionController@unConfirmSubscription')->name('subscription.unconfirm');
    Route::post('/subscription/remove', 'API\Subscription\SubscriptionController@removeSubscription')->name('subscription.remove');
});
