@extends('master')

@section('title')
@lang('main.Edit_Profile')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.Edit_Profile')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
         
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('main.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                   

                    <form action="{{route('dashboard.profile.update',$details->id)}}" method="post" enctype="multipart/form-data">
                        @csrf




                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input type="text" name="name" class="form-control" value="{{ $details->name }}">

                            
                            @error('name')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label>@lang('main.email')</label>
                            <input type="text" name="email" class="form-control" value="{{ $details->email }}">

                            
                            @error('email')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>


                <div class="form-group">
                    <label>@lang('main.photo')</label>
                    <input type="file" onChange="viewImage(this)" name="photo" class="form-control">

                    @error('photo')
                    <span class="text-danger"> {{$message}} </span>
                        @enderror
                </div>

                <div class="form-group">
                   
                    <img src="{{ !empty($details->photo) ? asset('uploads/profile_images/'.$details->photo) : asset('uploads/profile_images/'.'noimg.png')}}" style="width: 100px;" class="img-thumbnail image_preview" > 
                   
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
