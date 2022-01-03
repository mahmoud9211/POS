@extends('master')

@section('title')
@lang('main.users')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.Users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('main.Users')</a></li>
                <li class="active">@lang('main.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('main.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                   

                    <form action="{{ route('dashboard.users.update',$user->id) }}" method="post" enctype="multipart/form-data">
                 
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                       

                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">

                            @error('name')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror
                        </div>

                       

                        <div class="form-group">
                            <label>@lang('main.email')</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">

                            
                            @error('email')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label>@lang('main.photo')</label>
                            <input type="file" onChange="viewImage(this)" name="photo" class="form-control">

                        </div>

                        <div class="form-group">
                           
                            <img src="{{ !empty($user->photo) ? asset('uploads/profile_images/'.$user->photo) : asset('uploads/profile_images/'.'noimg.png')}}" style="width: 100px;" class="img-thumbnail image_preview" > 
                           
                        </div>

                       

                        

                      

                        <div class="form-group">
                            <label>@lang('main.permissions')</label>
                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index=>$model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $model }}" data-toggle="tab">@lang('main.' . $model)</a></li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">

                                    @foreach ($models as $index=>$model)

                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">

                                            @foreach ($maps as $map)
                                                <label><input type="checkbox" name="permissions[]" value="{{$model  . '_' . $map  }}" {{$user->hasPermission($model  . '_' . $map) ? 'checked' : ''}}> @lang('main.' . $map)</label>
                                            @endforeach

                                        </div>

                                    @endforeach

                                </div><!-- end of tab content -->
                                
                            </div><!-- end of nav tabs -->
                            
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('main.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

   


@endsection
