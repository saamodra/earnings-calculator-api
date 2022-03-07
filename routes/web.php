<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->post('login', 'AuthController@login');
  $router->post('register', 'AuthController@register');

  // auth
  // $router->group(['middleware' => 'auth'], function() use ($router) {
    // courses
    $router->get('dashboard', 'ReportController@dashboard');

    // courses
    $router->get('courses', 'CourseController@index');
    $router->get('courses/{id}', 'CourseController@get');
    $router->post('courses', 'CourseController@store');
    $router->put('courses/{id}', 'CourseController@update');
    $router->delete('courses/{id}', 'CourseController@destroy');

    // submissions
    $router->get('submissions', 'SubmissionController@index');
    $router->get('submissions/{id}', 'SubmissionController@get');
    $router->post('submissions', 'SubmissionController@store');
    $router->put('submissions/{id}', 'SubmissionController@update');
    $router->delete('submissions/{id}', 'SubmissionController@destroy');

    // reviews
    $router->get('reviews', 'ReviewController@index');
    $router->get('reviews/{id}', 'ReviewController@get');
    $router->post('reviews', 'ReviewController@store');
    $router->put('reviews/{id}', 'ReviewController@update');
    $router->delete('reviews/{id}', 'ReviewController@destroy');

    // calculators
    $router->get('calculators', 'CalculatorController@index');
    $router->post('calculators', 'CalculatorController@store');
    $router->put('calculators/{id}', 'CalculatorController@update');

    // report
    $router->get('reports', 'ReportController@reports');
  // });
});
