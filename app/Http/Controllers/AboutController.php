<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUpdateRequest;
use App\Models\About;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
  public function index()
  {
    $about = About::first();

    return view('about', [
      'about' => $about,
    ]);
  }

  public function update(AboutUpdateRequest $request): JsonResponse
  {
    $request->validated();

    try {
      About::where('id', 1)->update(['content' => $request->content]);
      return response()->json(null, 200);
    } catch (\Exception $e) {
      return response()->json([
        'messages' => $e->getMessage(),
      ], 400);
    }
  }
}