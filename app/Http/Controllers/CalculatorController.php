<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Calculator;

class CalculatorController extends Controller
{
  public function rules() {
    return [
      'version' => 'required',
      'earnings_per_point' => 'required',
      'tax' => 'required',
    ];
  }

  public function index() {
    $calculators = Calculator::get();

    return response()->json([
      'code' => 200,
      'data' => $calculators
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
        $calculator = Calculator::create($request->all());

        return response()->json([
          'code' => 201,
          'data' => $calculator,
          'message'=> 'Calculator added successfully!',
        ], 201);
      }
    } catch (\Throwable $e) {
      return response([
          'code' => 500,
          'message' => 'An error occurred in the system!'
      ], 500);
    }
  }

  public function update(Request $request) {
    try {
      $validator = Validator::make($request->all(), $this->rules(), $this->messages);
      if ($validator->fails()) {
        return response()->json([
          'code' => 400,
          'message' => $validator->errors(),
        ], 400);
      } else {
        $calculator = Calculator::create($request->all());

        return response()->json([
          'code' => 201,
          'data' => $calculator,
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
}
