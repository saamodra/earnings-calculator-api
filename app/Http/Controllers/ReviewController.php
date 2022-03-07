<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
  public function rules() {
    return [
      'point' => 'required|integer',
      'submission_id' => 'required|integer',
      'user_id' => 'required|integer',
    ];
  }

  public function index() {
    $reviews = Review::where('status', 'A')->get();

    return response()->json([
      'code' => 200,
      'data' => $reviews
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
        $review = Review::create($request->all());

        return response()->json([
          'code' => 201,
          'data' => $review,
          'message'=> 'Review added successfully!',
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
      $review = Review::findOrFail($id);

      $validator = Validator::make($request->all(), $this->rules(), $this->messages);
      if ($validator->fails()) {
        return response()->json([
          'code' => 400,
          'message' => $validator->errors(),
        ], 400);
      } else {
        $review->update($request->all());

        return response()->json([
          'code' => 200,
          'data' => $review,
          'message'=> 'Review updated successfully!',
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
      $review = Review::findOrFail($id);
      $review->status = 'I';
      $review->update();

      return response()->json([
        'code' => 200,
        'data' => $review,
        'message'=> 'Review deleted successfully!',
      ], 200);
    } catch (\Throwable $e) {
      return response([
        'code' => 500,
        'message' => 'An error occurred in the system!'
      ], 500);
    }
  }
}
