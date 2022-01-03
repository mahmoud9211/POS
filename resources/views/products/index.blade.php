@extends('master')

@section('title')
@lang('main.products')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.products')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li class="active">@lang('main.products')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('main.products') <small>{{ $products->count() }}</small></h3>

                    <form action="{{route('dashboard.products.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="" value="{{request()->search}}">
                            </div>

                            <div class="col-md-4">
                                <select name="category_id" class="form-control">
                                    <option value="">@lang('main.choose')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('main.search')</button>

                                @if(auth()->user()->hasPermission('products_create'))
                               
                                    <a href="{{route('dashboard.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('main.add')</a>
                               @endif
                            </div>

                            

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($products->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('main.description')</th>
                                <th>@lang('main.photo')</th>
                                <th>@lang('main.purchase_price') ($)</th>
                                <th>@lang('main.selling_price') ($)</th>
                                <th>@lang('main.stock')</th>
                                <th>@lang('main.profit') (%)</th>
                                <th>@lang('main.action')</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                @php 
                              $i = 1;
                                @endphp
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{!! $product->description !!}</td>

                                   <td> <img src="{{ !empty($product->image) ? asset('uploads/product_images/'.$product->image) : asset('uploads/user_images/'.'noimg.jpg')  }}" style="width: 100px;" class="img-thumbnail" alt=""></td>                               
                                        
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{$product->profit_percentage}}</td>
                                    <td>
                                    @if(auth()->user()->hasPermission('products_update'))

                                            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('main.edit')</a>
                                            
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('products_delete'))

                                            <a id="del" href="{{route('dashboard.products.delete',$product->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('main.delete')</a>
                                            @endif

                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{$products->appends(request()->query())->links()}}

                       
                        
                    @else
                        
                        <h2>@lang('main.no_data_found')</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
