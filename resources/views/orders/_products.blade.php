<div id="print-area">
    <table class="table table-hover table-bordered">

        <thead>
        <tr>
            <th>@lang('main.name')</th>
            <th>@lang('main.quantity')</th>
            <th>@lang('main.price')</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->selling_price, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h3>@lang('main.total') <span>{{ number_format($order->total_price, 2) }}</span></h3>

</div>

<button class="btn btn-block btn-primary print-btn"><i class="fa fa-print"></i> @lang('main.print')</button>
