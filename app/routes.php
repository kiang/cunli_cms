<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('county', 'County');
Route::model('town', 'Town');
Route::model('candidate', 'Candidate');
Route::model('cunli', 'Cunli');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('county', '[0-9]+');
Route::pattern('town', '[0-9]+');
Route::pattern('cunli', '.+');
Route::pattern('candidate', '.+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    # Counties Management
    Route::get('counties/{county}/show', 'AdminCountiesController@getShow');
    Route::get('counties/{county}/edit', 'AdminCountiesController@getEdit');
    Route::post('counties/{county}/edit', 'AdminCountiesController@postEdit');
    Route::get('counties/{county}/delete', 'AdminCountiesController@getDelete');
    Route::post('counties/{county}/delete', 'AdminCountiesController@postDelete');
    Route::controller('counties', 'AdminCountiesController');

    # Towns Management
    Route::get('towns/{town}/show', 'AdminTownsController@getShow');
    Route::get('towns/{town}/edit', 'AdminTownsController@getEdit');
    Route::post('towns/{town}/edit', 'AdminTownsController@postEdit');
    Route::get('towns/{town}/delete', 'AdminTownsController@getDelete');
    Route::post('towns/{town}/delete', 'AdminTownsController@postDelete');
    Route::controller('towns', 'AdminTownsController');

    # Cunlis Management
    Route::get('cunlis/{cunli}/show', 'AdminCunlisController@getShow');
    Route::get('cunlis/{cunli}/edit', 'AdminCunlisController@getEdit');
    Route::post('cunlis/{cunli}/edit', 'AdminCunlisController@postEdit');
    Route::get('cunlis/{cunli}/delete', 'AdminCunlisController@getDelete');
    Route::post('cunlis/{cunli}/delete', 'AdminCunlisController@postDelete');
    Route::controller('cunlis', 'AdminCunlisController');

    # Candidates Management
    Route::get('candidates/{candidate}/show', 'AdminCandidatesController@getShow');
    Route::get('candidates/{candidate}/edit', 'AdminCandidatesController@getEdit');
    Route::post('candidates/{candidate}/edit', 'AdminCandidatesController@postEdit');
    Route::get('candidates/{candidate}/delete', 'AdminCandidatesController@getDelete');
    Route::post('candidates/{candidate}/delete', 'AdminCandidatesController@postDelete');
    Route::controller('candidates', 'AdminCandidatesController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

# Posts - Second to last set, match slug
Route::get('{postSlug}', 'BlogController@getView');
Route::post('{postSlug}', 'BlogController@postView');

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
