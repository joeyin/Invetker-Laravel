<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\TransactionCreateRequest;
use App\Http\Requests\TransactionDeleteRequest;
use App\Http\Requests\TransactionUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
  public function index(int $id): JsonResponse
  {
    $transaction = Transaction::where('id', $id)
      ->where('userId', Auth::id())
      ->first();

    if ($transaction) {
      return response()->json([
        'data' => $transaction
      ], 200);
    } else {
      return response()->json([], 404);
    }
  }

  public function delete(TransactionDeleteRequest $request): JsonResponse
  {
    $request->validated();

    $transaction = Transaction::where('id', $request->id)
      ->where('userId', Auth::id())
      ->delete();

    if ($transaction) {
      return response()->json([], 200);
    } else {
      return response()->json([], 404);
    }
  }

  public function create(TransactionCreateRequest $request): JsonResponse
  {
    $request->validated();

    try {
      Transaction::create([
        'userId' => Auth::id(),
        'ticker' => $request->ticker,
        'datetime' => $request->datetime,
        'quantity' => $request->quantity,
        'action' => $request->action,
        'price' => $request->price,
        'fee' => $request->fee,
      ]);
      return response()->json(null, 200);
    } catch (\Exception $e) {
      return response()->json([
        'messages' => $e->getMessage(),
      ], 400);
    }
  }

  public function update(TransactionUpdateRequest $request): JsonResponse
  {
    $request->validated();

    try {
      Transaction::where('id', $request->id)
        ->where('userId', Auth::id())
        ->update([
          'datetime' => $request->datetime,
          'quantity' => $request->quantity,
          'action' => $request->action,
          'price' => $request->price,
          'fee' => $request->fee,
        ]);
      return response()->json(null, 200);
    } catch (\Exception $e) {
      return response()->json([
        'messages' => $e->getMessage(),
      ], 400);
    }
  }
}
