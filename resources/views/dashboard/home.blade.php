<x-dashboard-layout>
  @section('scripts')
    @vite(['resources/js/dashboard.js'])
  @endsection

  <div class="d-inline-flex breadcrumb-wrapper align-items-center justify-content-between mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item active" aria-current="page">Home</li>
      </ol>
    </nav>
  </div>

  <div class="container-fluid d-flex flex-grow-1 flex-column gap-4">
    <!-- Holdings -->
    <div id="holdings" class="card d-flex flex-column">
      <div class="title">Your Holdings</div>
      <div class="content table-thead-fixed flex-grow-1">
        <table class="table table-striped table-hover table-borderless table-thead-uppercase">
          <thead>
            <tr>
              <th scope="col">Ticker</th>
              <th scope="col">Position</th>
              <th scope="col">Price</th>
              <th scope="col">Change %</th>
              <th scope="col">Cost Basis</th>
              <th scope="col">MKTVAL</th>
              <th scope="col">AVG Price</th>
              <th scope="col">Daily P&L</th>
              <th scope="col">Unrealized P&L</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($holdings as $holding)
              <tr>
                <td>{{ $holding['ticker'] }}</td>
                <td>{{ number_format($holding['quantity'], 2, '.', ',') }}</td>
                <td>{{ number_format($holding['price'], 2, '.', ',') }}</td>
                <td>
                  <span class="{{ $holding['changePercent'] >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $holding['changePercent'] >= 0 ? '+' : '' }}
                    {{ number_format($holding['changePercent'], 2, '.', ',') }}%
                  </span>
                </td>
                <td>{{ number_format($holding['cost'], 2, '.', ',') }}</td>
                <td>{{ number_format($holding['price'] * $holding['quantity'], 2, '.', ',') }}</td>
                <td>{{ number_format($holding['cost'] / $holding['quantity'], 2, '.', ',') }}</td>
                <td>
                  <span class="{{ $holding['dailypl'] >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $holding['dailypl'] >= 0 ? '+' : '' }}
                    {{ number_format($holding['dailypl'], 2, '.', ',') }}
                  </span>
                </td>
                <td>
                  <span class="{{ $holding['unrealizedpl'] >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $holding['unrealizedpl'] >= 0 ? '+' : '' }}
                    {{ number_format($holding['unrealizedpl'], 2, '.', ',') }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- End Holdings -->

    <!-- Transactions -->
    <div id="transactions" class="card d-flex flex-column">
      <div class="title">Recent Transactions</div>
      <div class="content table-thead-fixed flex-grow-1">
        <table class="table table-striped table-hover table-borderless table-thead-uppercase">
          <thead>
            <tr>
              <th scope="col">Ticker</th>
              <th scope="col">Action</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Fee</th>
              <th scope="col">Amount</th>
              <th scope="col">Date Time</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transactions as $t)
              <tr class="align-middle">
                <td>{{ $t->ticker }}</td>
                <td>{{ $t->action }}</td>
                <td>{{ number_format($t->quantity, 2, '.', ',') }}</td>
                <td>{{ number_format($t->price, 2, '.', ',') }}</td>
                <td>{{ number_format($t->fee, 2, '.', ',') }}</td>
                <td>{{ number_format($t->price * $t->quantity + $t->fee, 2) }}</td>
                <td>{{ $t->datetime }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- End Transactions -->

    <!-- Top Portfolio -->
    <div id="top-portfolio" class="card d-flex flex-column">
      <div class="title">Top Portfolio Positions</div>
      <div class="content flex-grow-1 d-flex overflow-auto">
        <?php $i = 1; ?>
        @foreach ($tops as $t)
          @if($t['unrealizedpl'] > 0)
          <div class="ranking d-flex align-items-end">
            <div class="no d-flex flex-column align-self-baseline">
              Top <span>{{ $i }}</span>
            </div>
            <img class="company-logo" alt="TLSA" aria-label="TSLA"
              src="{{ $t['logo'] . '?apiKey=' . env('API_KEY') }}">
            <div class="company-detail d-flex flex-column">
              <span class="name">{{ $t['ticker'] }}</span>
              <span class="description">{{ $t['description'] }}</span>
              <span>POSITION: {{ number_format($t['quantity'], 2, '.', ',') }}</span>
              <span>PRICE: {{ number_format($t['price'], 2, '.', ',') }}</span>
              <span>
                DAILY P&L:
                <span class="{{ $t['dailypl'] >= 0 ? 'text-success' : 'text-danger' }}">
                  {{ $t['dailypl'] >= 0 ? '+' : '' }}
                  {{ number_format($t['dailypl'], 2, '.', ',') }}
                </span>
              </span>
              <span>
                UNREALIZED P&L:
                <span class="{{ $t['unrealizedpl'] >= 0 ? 'text-success' : 'text-danger' }}">
                  {{ $t['unrealizedpl'] >= 0 ? '+' : '' }}
                  {{ number_format($t['unrealizedpl'], 2, '.', ',') }}
                </span>
              </span>
            </div>
          </div>
          @endif
          <?php $i++; ?>
        @endforeach
      </div>
    </div>
    <!-- End Top Portfolio -->
  </div>
</x-dashboard-layout>