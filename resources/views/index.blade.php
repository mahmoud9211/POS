@extends('master')

@section('title')
@lang('main.dashboard')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.dashboard')</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</li>
            </ol>
        </section>

        <section class="content">

            @php 
$categories = DB::table('categories')->count();
$products = DB::table('products')->count();
$clients = DB::table('clients')->count();
$users = App\Models\User::whereRoleIs('admin')->count();

$sales_data = DB::table('orders')->select(

DB::raw('year(created_at) as year'),
DB::raw('month(created_at) as month'),
DB::raw('sum(total_price) as sum'),

)->groupBy('month')->get();

            @endphp

            <div class="row">

                {{-- categories--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">

                      
                      
                            <h3>{{$categories}}</h3>

                            <p>@lang('main.categories')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('dashboard.categories.index')}}" class="small-box-footer">@lang('main.show') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--products--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$products}}</h3>

                            <p>@lang('main.products')</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('dashboard.products.index')}}" class="small-box-footer">@lang('main.show') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--clients--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$clients}}</h3>

                            <p>@lang('main.clients')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="{{route('dashboard.clients.index')}}" class="small-box-footer"> @lang('main.show')<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                {{--users--}}
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$users}}</h3>

                            <p>@lang('main.users')</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{route('dashboard.users.index')}}" class="small-box-footer">@lang('main.show') <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div><!-- end of row -->

            <div class="box box-solid">

                <div class="box-header">
                    <h3 class="box-title">Sales Graph</h3>
                </div>
                <div class="box-body border-radius-none">
                    <div class="chart" id="line-chart" style="height: 250px;"></div>
                </div>
                <!-- /.box-body -->
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


   


@endsection

@push('scripts')

<script>

    //line chart
    var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: [
            @foreach ($sales_data as $data)
            {
                ym: "{{ $data->year }}-{{ $data->month }}", sum: "{{ $data->sum }}"
            },
            @endforeach
        ],
        xkey: 'ym',
        ykeys: ['sum'],
        labels: ['@lang('main.total')'],
        lineWidth: 2,
        hideHover: 'auto',
        gridStrokeWidth: 0.4,
        pointSize: 4,
        gridTextFamily: 'Open Sans',
        gridTextSize: 10
    });
</script>




@endpush

