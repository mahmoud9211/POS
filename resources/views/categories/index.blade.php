@extends('master')

@section('title')
@lang('main.categories')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.categories')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li class="active">@lang('main.categories')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('main.categories') <small>{{ $categories->count() }}</small></h3>

                    <form action="{{route('dashboard.categories.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="" value="{{request()->search}}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('main.search')</button>

                                @if(auth()->user()->hasPermission('categories_create'))
                               
                                    <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('main.add')</a>
                               @endif
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($categories->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('main.product_num')</th>
                                @if(auth()->user()->hasPermission('products_read'))

                                <th>@lang('main.related_product')</th>

                                @endif
                                <th>@lang('main.action')</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                @php 
                              $i = 1;
                                @endphp
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->product->count()}}</td>
                                    @if(auth()->user()->hasPermission('products_read'))
                                    <td><a href="{{route('dashboard.products.index',['category_id' => $category->id])}}" class="btn btn-sm btn-info"> @lang('main.related_product')  </a></td>
                                    @endif
    
                                    @if(auth()->user()->hasPermission('categories_update'))
                                            
                                       <td>     <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('main.edit')</a>
                                            
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('categories_delete'))
                                            <a id="del" href="{{route('dashboard.categories.delete',$category->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('main.delete')</a>

                                            @endif
                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->

                        {{$categories->appends(request()->query())->links()}}

                       
                        
                    @else
                        
                        <h2>@lang('main.no_data_found')</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
