@extends('master')

@section('title')
@lang('main.users')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.Users')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li class="active">@lang('main.Users')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('main.Users') <small>{{ $users->count() }}</small></h3>

                    <form action="{{route('dashboard.users.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="" value="{{request()->search}}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('main.search')</button>

                                @if(auth()->user()->hasPermission('users_create'))
                               
                                    <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('main.add')</a>
                               @endif
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($users->count() > 0)

                        <table class="table table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('main.email')</th>
                                <th>@lang('main.photo')</th>
                                <th>@lang('main.action')</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                @php 
                              $i = 1;
                                @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $i++}}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                   <td> <img src="{{ !empty($user->photo) ? asset('uploads/profile_images/'.$user->photo) : asset('uploads/profile_images/'.'noimg.png')  }}" style="width: 100px;" class="img-thumbnail" alt=""></td>                                    <td>
                                        @if(auth()->user()->hasPermission('users_update'))

                                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('main.edit')</a>
                                            
                                            @endif
                                            
                                            @if(auth()->user()->hasPermission('users_delete'))

                                            <a id="del" href="{{route('dashboard.users.delete',$user->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('main.delete')</a>
                                          @endif

                                    </td>
                                </tr>
                            
                            @endforeach
                            </tbody>

                        </table><!-- end of table -->
                       
                        {{$users->appends(request()->query())->links()}}
                        
                    @else
                        
                        <h2>@lang('main.no_data_found')</h2>
                        
                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
