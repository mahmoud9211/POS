@extends('master')

@section('title')
@lang('main.products')
@endsection

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('main.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> @lang('main.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('main.products')</a></li>
                <li class="active">@lang('main.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('main.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                   

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

                        @csrf

                        <div class="form-group">
                            <label>@lang('main.categories')</label>
                            <select name="category_id" class="form-control">
                                <option value="">@lang('main.choose')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('category_id')
                            <span class="text-danger"> {{$message}} </span>
                             @enderror
                        </div>
                       

                        @foreach (config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('main.' . $locale . '.name')</label>
                            <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale . '.name') }}">
                            @error($locale. '.name')
                           <span class="text-danger"> {{$message}} </span>
                            @enderror
                        </div>
                             <div class="form-group">
                        <label>@lang('main.' . $locale . '.description')</label>
                        <textarea name="{{ $locale }}[description]" class="form-control ckeditor">{{ old($locale . '.description') }}</textarea>                      
                        @error($locale. '.description')
                       <span class="text-danger"> {{$message}} </span>
                        @enderror
                    </div>



                       
                    @endforeach


                  


                <div class="form-group">
                    <label>@lang('main.photo')</label>
                    <input type="file" onChange="viewImage(this)" name="image" class="form-control">

                    @error('image')
                    <span class="text-danger"> {{$message}} </span>
                        @enderror
                </div>

                <div class="form-group">
                   
                    <img src="{{asset('uploads/user_images/noimg.jpg')}}" style="width: 100px;" class="img-thumbnail image_preview" > 
                   
                </div>
                       

                        <div class="form-group">
                            <label>@lang('main.purchase_price')</label>
                            <input type="text" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}">

                            
                            @error('purchase_price')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>

                       

                        

                        <div class="form-group">
                            <label>@lang('main.selling_price')</label>
                            <input type="text" name="selling_price" class="form-control" value="{{ old('selling_price') }}">

                            
                            @error('selling_price')
                        <span class="text-danger"> {{$message}} </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label>@lang('main.stock')</label>
                            <input type="number" name="stock" class="form-control" value="{{old('stock')}}">
                           
                            @error('stock')
                            <span class="text-danger"> {{$message}} </span>
                                @enderror
                            
                          
                        </div>

                      



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('main.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


    

   


@endsection
