@extends('master')

@section('title')
@lang('main.orders')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.orders')
                <small> @lang('main.orders')</small>
            </h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li class="active">@lang('main.orders')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">

                <div class="col-md-8">

                    <div class="box box-primary">

                        <div class="box-header">

                            <h3 class="box-title" style="margin-bottom: 10px">@lang('main.orders')</h3>

                            <form action="{{ route('dashboard.orders.index') }}" method="get">

                                <div class="row">

                                    <div class="col-md-8">
                                        <input type="text" name="search" class="form-control" placeholder="@lang('main.search')" value="{{ request()->search }}">
                                    </div>

                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('main.search')</button>
                                    </div>

                                </div><!-- end of row -->

                            </form><!-- end of form -->

                        </div><!-- end of box header -->

                        @if ($orders->count() > 0)

                            <div class="box-body table-responsive">

                                <table class="table table-hover">
                                    <tr>
                                        <th>@lang('main.client_name')</th>
                                        <th>@lang('main.price')</th>
                                        <th>@lang('main.created_at')</th>
                                        <th>@lang('main.action')</th>
                                    </tr>

                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->client->name }}</td>
                                            <td>{{ number_format($order->total_price, 2) }}</td>
                                            
                                            <td>{{ $order->created_at->toFormattedDateString() }}</td>

                                            <td>
                                                @if (auth()->user()->hasPermission('orders_read'))

                                                <a class="btn btn-primary btn-sm order-products"
                                                        href="{{url('dashboard/orders/products',$order->id)}}"
                                                        data-id="{{$order->id}}"
                                                > 
                                                    <i class="fa fa-list"></i>
                                                    @lang('main.show')
                                                </a>
                                                @endif

                                                @if (auth()->user()->hasPermission('orders_update'))
                                                    <a href="{{route('dashboard.clients.orders.edit',['order' =>$order->id, 'client' => $order->client->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> @lang('main.edit')</a>
                                                
                                                @endif

                                                @if (auth()->user()->hasPermission('orders_delete'))
                                                    
                                                        <a href="{{route('dashboard.clients.orders.delete',$order->id)}}" id="del" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('main.delete')</a>

                                                
                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </table><!-- end of table -->


                            </div>

                        @else

                            <div class="box-body">
                                <h3>@lang('main.no_data_found')</h3>
                            </div>

                        @endif

                    </div><!-- end of box -->

                </div><!-- end of col -->

                <div class="col-md-4">

                    <div class="box box-primary">

                        <div class="box-header">
                            <h3 class="box-title" style="margin-bottom: 10px">@lang('main.show_products')</h3>
                        </div><!-- end of box header -->

                        <div class="box-body">

                            <div style="display: none; flex-direction: column; align-items: center;" id="loading">
                                <div class="loader"></div>
                                <p style="margin-top: 10px">@lang('main.loading')</p>
                            </div>

                            <div id="order-product-list">

                            </div><!-- end of order product list -->

                        </div><!-- end of box body -->

                    </div><!-- end of box -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </section><!-- end of content section -->

    </div><!-- end of content wrapper -->

@endsection
