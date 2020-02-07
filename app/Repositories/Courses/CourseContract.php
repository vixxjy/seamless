<?php

namespace App\Repositories\Courses;

interface CourseContract {
   public function addCourse($request, $userID);
   public function getAllCourses();
}