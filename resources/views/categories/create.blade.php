@extends('master')

@section('title')
@lang('main.categories')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.Users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li><a href="{{ route('dashboard.categories.index') }}"> @lang('main.categories')</a></li>
                <li class="active">@lang('main.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('main.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                   

                    <form action="{{ route('dashboard.categories.store') }}" method="post" >

                        @csrf
                       

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label>@lang('main.' . $locale . '.name')</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}">
                                @error($locale. '.name')
                               <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                        @endforeach


                        


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('main.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


    

   


@endsection
