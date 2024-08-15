<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Transaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Vite;
use Scheb\YahooFinanceApi\ApiClientFactory;

class DashboardController extends Controller
{
  public function index()
  {
    $transactions = Transaction::where('userId', Auth::id())
      ->orderByDesc('datetime')
      ->limit(20)
      ->get();

    //Group transactions by ticker and action
    $groupedTransactions = Transaction::select(
      'ticker',
      'action',
      DB::raw('SUM(price * quantity + fee) as amount'),
      DB::raw('SUM(quantity) as quantity')
    )
      ->where('userId', Auth::id())
      ->groupBy('ticker', 'action')
      ->get();

    $holdings = [];

    foreach ($groupedTransactions as $transaction) {
      $ticker = $transaction->ticker;
      $quantity = $transaction->quantity;
      $amount = $transaction->amount;
      $action = $transaction->action;
      $sign = ($action === 'Bought') ? 1 : -1;
      if (!isset($holdings[$ticker])) {
        $holdings[$ticker] = ['quantity' => 0, 'cost' => 0];
      }
      $holdings[$ticker]['quantity'] += $sign * $quantity;
      $holdings[$ticker]['cost'] += $sign * $amount;
    }

    $client = ApiClientFactory::createApiClient();
    foreach ($holdings as $ticker => &$holding) {
      if ($holding['quantity'] <= 0) {
        unset($holdings[$ticker]);
        continue;
      }

      try {
        $quote = $client->getQuote($ticker);
        $price = $quote->getAsk();
        $marketChange = $quote->getRegularMarketChange();
        $holding['ticker'] = $ticker;
        $holding['price'] = $price;
        $holding['change'] = $marketChange;
        $holding['changePercent'] = $quote->getRegularMarketChangePercent();
        $holding['dailypl'] = $marketChange * floatval($holding['quantity']);
        $holding['unrealizedpl'] = $price * floatval($holding['quantity']) - $holding['cost'];
        $holding['logo'] = Vite::asset('/resources/images/brand.svg');
        $holding['description'] = 'Too Many Requests, the free plan only allows 5 requests per minute.';

        $response = Http::get('https://api.polygon.io/v3/reference/tickers/' . $ticker, [
          'apiKey' => env('API_KEY')
        ]);
        if ($response->successful()) {
          $data = $response->json();
          if ($data['status'] === 'OK' && isset($data['results'])) {
            $holding['logo'] = $data['results']['branding']['logo_url'] ?? $holding['logo'];
            $holding['description'] = $data['results']['description'] ?? $holding['description'];
          }
        }
      } catch (\Exception $e) {
        echo 'Error: Too many request, ' . $e->getMessage();
        exit();
      }
    }

    return view('dashboard/home', [
      'transactions' => $transactions,
      'holdings' => $holdings,
      'tops' => collect($holdings)->sortByDesc('unrealizedpl')->values()->all(),
    ]);
  }

  public function transactions(Request $request)
  {
    $transactions = Transaction::where('userId', Auth::id())
      //https://stackoverflow.com/questions/54651664/how-to-make-a-wherein-query-builder-in-laravel-eloquent-with-empty-parameter
      ->when(!empty($request->start), function ($query) use ($request) {
        $date = (new DateTime($request->start))->setTime(0, 0, 0);
        $query->where('datetime', '>=', $date->format('Y-m-d H:i:s'));
      })
      ->when(!empty($request->end), function ($query) use ($request) {
        $date = (new DateTime($request->end))->setTime(23, 59, 59);
        $query->where('datetime', '<=', $date->format('Y-m-d H:i:s'));
      })
      ->when(!empty($request->ticker), function ($query) use ($request) {
        $query->where('ticker', $request->ticker);
      })
      ->orderByDesc('datetime')
      ->get();

    return view('dashboard/transaction', [
      'transactions' => $transactions
    ]);
  }

  public function about()
  {
    $about = About::first();

    return view('dashboard/about', [
      'about' => $about,
    ]);
  }

  public function profile()
  {
    return view('dashboard/profile');
  }
}
