@extends('master')

@section('title')
@lang('main.Change_Password')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.Change_Password')</h1>

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

                   

                    <form action="{{route('dashboard.profile.change.password.process')}}" method="post" >
                        @csrf


                        <div class="form-group">
                            <label>@lang('main.current_password')</label>
                            <input type="password" name="old_password" class="form-control">

                            
                            @error('old_password')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label>@lang('main.password')</label>
                            <input type="password" name="password" class="form-control" >


                            @error('new_password')
                            <span class="text-danger"> {{$message}} </span>
                                @enderror

                        </div>

                        <div class="form-group">
                            <label>@lang('main.password_confirmation')</label>
                            <input type="password" name="password_confirmation" class="form-control" >

                            
                        

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
