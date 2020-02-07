<?php

namespace App\Http\Controllers;
use App\Course;
use App\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function __construct()
    {
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
        $data = $request->all();

        $user_id = $this->guard()->user()->id;
        $data['user_id'] = $user_id;
        $course = Register::create($data);

        if ($course) {
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
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function Courses() {
        $courses = Course::all();

        if (!empty($courses)) {
            $status = true;
            $errors = [];
            $message = "List of Registered Courses was successful";
            $data = $courses;
        }else {
            $status = false;
            $errors = [
                "Course" => "Registered Courses was not listed successfully",
            ];
            $message = "Courses list failed";
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function listCourses() {
        $user_id = $this->guard()->user()->id;
        $courses = Course::where('user_id', '=', $user_id)->get();

        if (!empty($courses)) {
            $status = true;
            $errors = [];
            $message = "List of Registered Courses by user was successful";
            $data = $courses;
        }else {
            $status = false;
            $errors = [
                "Course" => "Registered Courses was not listed successfully",
            ];
            $message = "Courses list failed";
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function export() {
        return Excel::download(new CourseExport, 'course.xlsx');
    }
}
