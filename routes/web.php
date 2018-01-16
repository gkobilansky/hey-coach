<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');
Route::group(['middleware' => ['auth']], function () {
    
    /**
     * Main
     */
        Route::get('/', 'PagesController@dashboard');
        Route::get('dashboard', 'PagesController@dashboard')->name('dashboard');
        
    /**
     * Users
     */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/data', 'UsersController@anyData')->name('users.data');
        Route::get('/taskdata/{id}', 'UsersController@taskData')->name('users.taskdata');
        Route::get('/recruitdata/{id}', 'UsersController@recruitData')->name('users.recruitdata');
        Route::get('/athletedata/{id}', 'UsersController@athleteData')->name('users.athletedata');
        Route::get('/users', 'UsersController@users')->name('users.users');
    });
        Route::resource('users', 'UsersController');

	 /**
     * Roles
     */
        Route::resource('roles', 'RolesController');
    /**
     * Athletes
     */
    Route::group(['prefix' => 'athletes'], function () {
        Route::get('/data', 'AthletesController@anyData')->name('athletes.data');
        Route::post('/create/cvrapi', 'AthletesController@cvrapiStart');
        Route::post('/upload/{id}', 'DocumentsController@upload');
        Route::patch('/updateassign/{id}', 'AthletesController@updateAssign');
    });
        Route::resource('athletes', 'AthletesController');
	    Route::resource('documents', 'DocumentsController');
	
      
    /**
     * Tasks
     */
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/data', 'TasksController@anyData')->name('tasks.data');
        Route::patch('/updatestatus/{id}', 'TasksController@updateStatus');
        Route::patch('/updateassign/{id}', 'TasksController@updateAssign');
        Route::post('/updatetime/{id}', 'TasksController@updateTime');
    });
        Route::resource('tasks', 'TasksController');

    /**
     * Recruits
     */
    Route::group(['prefix' => 'recruits'], function () {
        Route::get('/data', 'RecruitsController@anyData')->name('recruits.data');
        Route::patch('/updateassign/{id}', 'RecruitsController@updateAssign');
        Route::get('/updatestatus/{id}', 'RecruitsController@updateStatus');
        Route::patch('/updatefollowup/{id}', 'RecruitsController@updateFollowup')->name('recruits.followup');
    });
        Route::resource('recruits', 'RecruitsController');
        Route::post('/comments/{type}/{id}', 'CommentController@store');
    /**
     * Settings
     */
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::patch('/permissionsUpdate', 'SettingsController@permissionsUpdate');
        Route::patch('/overall', 'SettingsController@updateOverall');
    });

    /**
     * Departments
     */
        Route::resource('departments', 'DepartmentsController'); 

    /**
     * Integrations
     */
    Route::group(['prefix' => 'integrations'], function () {
        Route::get('Integration/slack', 'IntegrationsController@slack');
    });
        Route::resource('integrations', 'IntegrationsController');

    /**
     * Notifications
     */
    Route::group(['prefix' => 'notifications'], function () {
        Route::post('/markread', 'NotificationsController@markRead')->name('notification.read');
        Route::get('/markall', 'NotificationsController@markAll');
        Route::get('/{id}', 'NotificationsController@markRead');
    });

    /**
     * Invoices
     */
    Route::group(['prefix' => 'invoices'], function () {
        Route::post('/updatepayment/{id}', 'InvoicesController@updatePayment')->name('invoice.payment.date');
        Route::post('/reopenpayment/{id}', 'InvoicesController@reopenPayment')->name('invoice.payment.reopen');
        Route::post('/sentinvoice/{id}', 'InvoicesController@updateSentStatus')->name('invoice.sent');
        Route::post('/newitem/{id}', 'InvoicesController@newItem')->name('invoice.new.item');
    });
        Route::resource('invoices', 'InvoicesController');
});
