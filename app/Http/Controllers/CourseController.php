<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
  public function rules() {
    return [
      'name' => 'required',
      'learning_path' => 'required',
    ];
  }

  public function index() {
    $courses = Course::where('status', 'A')->get();

    return response()->json([
      'code' => 200,
      'data' => $courses
    ], 200);
  }

  public function store(Request $request) {
    try {
      $validator = Validator::make($request->all(), $this->rules(), $this->messages);
      if ($validator->fails()) {
        return response()->json([
          'code' => 400,
          'message' => $validator->errors(),
        ], 400);
      } else {
        $course = Course::create($request->all());

        return response()->json([
          'code' => 201,
          'data' => $course,
          'message'=> 'Course added successfully!',
        ], 201);
      }
    } catch (\Throwable $e) {
      return response([
          'code' => 500,
          'message' => 'An error occurred in the system!'
      ], 500);
    }
  }

  public function update(Request $request, $id) {
    try {
      $course = Course::findOrFail($id);

      $validator = Validator::make($request->all(), $this->rules(), $this->messages);
      if ($validator->fails()) {
        return response()->json([
          'code' => 400,
          'message' => $validator->errors(),
        ], 400);
      } else {
        $course->update($request->all());

        return response()->json([
          'code' => 200,
          'data' => $course,
          'message'=> 'Course updated successfully!',
        ], 201);
      }
    } catch (\Throwable $e) {
      return response([
        'code' => 500,
        'message' => 'An error occurred in the system!'
      ], 500);
    }
  }

  public function destroy($id) {
    try {
      $course = Course::findOrFail($id);
      $course->status = 'I';
      $course->update();

      return response()->json([
        'code' => 200,
        'data' => $course,
        'message'=> 'Course deleted successfully!',
      ], 200);
    } catch (\Throwable $e) {
      return response([
        'code' => 500,
        'message' => 'An error occurred in the system!'
      ], 500);
    }
  }
}
