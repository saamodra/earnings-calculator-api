<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
  protected $messages = [
    'required' => 'Kolom :attribute tidak boleh kosong.',
    'integer' => 'Kolom :attribute wajib berisi angka.',
  ];
}
