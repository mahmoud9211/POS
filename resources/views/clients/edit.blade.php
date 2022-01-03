@extends('master')

@section('title')
@lang('main.clients')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.clients')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li><a href="{{ route('dashboard.clients.index') }}"> @lang('main.clients')</a></li>
                <li class="active">@lang('main.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('main.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                   

                    <form action="{{ route('dashboard.clients.update',$client->id) }}" method="post" >
              {{method_field('patch')}}
                        @csrf
                       

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label>@lang('main.' . $locale . '.name')</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $client->translate($locale)->name }}">
                                @error($locale. '.name')
                               <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>@lang('main.' . $locale . '.address')</label>
                                <textarea type="text" name="{{ $locale }}[address]" class="form-control"> {{ $client->translate($locale)->address }} </textarea>
                                @error($locale. '.address')
                               <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                        @endforeach

                      
                        <div class="form-group">
                            <label>@lang('main.phone')</label>
                            <input type="text" name="phone" class="form-control" value="{{$client->phone}}">
                            @error('phone')
                           <span class="text-danger"> {{$message}} </span>
                            @enderror
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
