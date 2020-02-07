<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::group(['prefix' => 'course'], function () {
    Route::get('lists', 'CourseController@Courses');
    Route::post('register', 'CourseController@registerCourse');
    Route::get('seed', 'CourseController@seedCourses');
    Route::get('export', 'CourseController@export');
});
