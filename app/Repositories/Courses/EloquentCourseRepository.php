<?php

namespace App\Repositories\Courses;
use App\Repositories\Courses\CourseContract;
use App\Course;
use App\Register;

class EloquentCourseRepository implements CourseContract {
  public function addCourse($request, $userID) {
    $data = $request->all();
    $data['user_id'] = $userID;
    $course = Register::create($data);

    return $course;
  }

  public function getAllCourses() {
    $courses = Course::all();
    return $courses;
  }
}