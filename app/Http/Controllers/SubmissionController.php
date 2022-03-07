<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Submission;

class SubmissionController extends Controller
{
  public function rules() {
    return [
      'name' => 'required',
      'point' => 'required|integer',
      'course_id' => 'required|integer',
    ];
  }

  public function index() {
    $submissions = Submission::where('status', 'A')->get();

    return response()->json([
      'code' => 200,
      'data' => $submissions
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
        $submission = Submission::create($request->all());

        return response()->json([
          'code' => 201,
          'data' => $submission,
          'message'=> 'Submission added successfully!',
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
      $submission = Submission::findOrFail($id);

      $validator = Validator::make($request->all(), $this->rules(), $this->messages);
      if ($validator->fails()) {
        return response()->json([
          'code' => 400,
          'message' => $validator->errors(),
        ], 400);
      } else {
        $submission->update($request->all());

        return response()->json([
          'code' => 200,
          'data' => $submission,
          'message'=> 'Submission updated successfully!',
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
      $submission = Submission::findOrFail($id);
      $submission->status = 'I';
      $submission->update();

      return response()->json([
        'code' => 200,
        'data' => $submission,
        'message'=> 'Submission deleted successfully!',
      ], 200);
    } catch (\Throwable $e) {
      return response([
        'code' => 500,
        'message' => 'An error occurred in the system!'
      ], 500);
    }
  }
}
