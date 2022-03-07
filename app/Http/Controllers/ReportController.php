<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculator;
use App\Models\Review;
use App\Models\Submission;
use Carbon\Carbon;

class ReportController extends Controller
{
  public function dashboard() {
    $thisMonth = Carbon::now()->month;

    $calculator = Calculator::where('status', 'A')->first();

    $month_points = Review::where('status', 'A')
    ->whereMonth('created_at', $thisMonth)
    ->sum('point');

    $total_points = Review::where('status', 'A')
    ->sum('point');

    $gross_profit_month = intVal($month_points) * $calculator->earnings_per_point;
    $net_profit_month = $gross_profit_month - ($gross_profit_month * $calculator->tax);

    $gross_profit = intVal($total_points) * $calculator->earnings_per_point;
    $net_profit = $gross_profit - ($gross_profit * $calculator->tax);

    return response()->json([
      'code' => 200,
      'data' => [
        'total_point_month' => $month_points,
        'net_profit_month' => $net_profit_month,
        'total_point' => $total_points,
        'net_profit' => $net_profit
      ],
    ]);
  }

  public function reports(Request $request) {
    $monthParam = $request->month;
    $month = !$monthParam ? Carbon::now()->month : $monthParam;

    $calculator = Calculator::where('status', 'A')->first();

    $summary = Review::where('status', 'A')
    ->whereMonth('created_at', $month)
    ->selectRaw("DATE_FORMAT(DATE(created_at), '%d-%m-%Y') as day")
    ->selectRaw("COUNT(*) as total_review")
    ->selectRaw("SUM(point) as points")
    ->selectRaw("CAST(SUM(point) AS INTEGER) * ".$calculator->earnings_per_point."
    - (CAST(SUM(point) AS INTEGER) * ".$calculator->earnings_per_point." * ".$calculator->tax.") as earnings")
    ->groupBy('day')
    ->get();

    $submissions = Submission::where('status', 'A')->get();

    $newSummary = [];

    foreach ($summary as $sum) {
      $object = $sum;
      $review_submission = [];
      foreach ($submissions as $submission) {
        $countSubmission = Review::where('status', 'A')
        ->where('submission_id', $submission->id)
        ->whereDate('created_at', $sum->day)
        ->count();

        $submission = [
          'name' => $submission->name,
          'count' => $countSubmission
        ];

        array_push($review_submission, $submission);
      }

      $object['reviews'] = $review_submission;
      array_push($newSummary, $object);
    }

    return response()->json([
      'code' => 200,
      'data' => [
        ...$newSummary,
      ],
    ]);
  }
}
