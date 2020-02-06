<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('lists', 'CourseController@Courses');
    Route::get('list', 'CourseController@listCourses');
    Route::post('add', 'CourseController@addCourse');
    Route::get('seed', 'CourseController@seedCourses');
    Route::get('export', 'CourseController@export');
});
