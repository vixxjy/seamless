<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Courses\CourseContract;

class CourseController extends Controller
{
    protected $repo;

    public function __construct(CourseContract $CourseContract)
    {
        $this->repo = $CourseContract;
        $this->middleware('auth:api', ['except' => ['export']]);
    }

    public function seedCourses() {
        \Artisan::call('course:seed');
        return response()->json([
            'message' => '50 courses seeded successfully'
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    protected function sendResult($message, $data, $errors = [], $status = true)
    {
        $errorCode = $status ? 200 : 422;

        $result = [
            "message" => $message,
            "status" => $status,
            "data" => $data,
            "errors" => $errors,
            "statusCode" => $errorCode
        ];

        return response()->json($result, $errorCode);
    }

    public function registerCourse(Request $request) {

        $user_id = $this->guard()->user()->id;
        $course = $this->repo->addCourse($request, $user_id);

        if (!empty($course)) {
            $status = true;
            $errors = [];
            $message = "Course registered successfully";
            $data = $course;
        }else {
            $status = false;
            $errors = [
             "Course" => "Course was not registered successfully",
            ];
            $message = "Course registration failed";
            $data = 'none';
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function Courses() {
        $courses = $this->repo->getAllCourses();

        if (!empty($courses)) {
            $status = true;
            $errors = [];
            $message = "Courses list was successful";
            $data = $courses;
        }else {
            $status = false;
            $errors = [
                "Course" => "Courses list was not successful",
            ];
            $message = "Courses list failed";
            $data = 'none';
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function export() {
        return Excel::download(new CourseExport, 'course.xlsx');
    }
}
