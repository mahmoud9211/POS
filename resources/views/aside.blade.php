<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ !empty(optional(Auth::user())->photo) ? asset('uploads/profile_images/'.optional(Auth::user())->photo) : asset('uploads/profile_images/'.'noimg.png')}}" class="img-circle" alt="User Image"> 

            </div>
            <div class="pull-left info">
                <p>{{str_replace('_','  ',optional(Auth::user())->name)}}</p>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">


            <li><a href="{{url('/')}}"><i class="fa fa-th"></i><span>@lang('main.dashboard')</span></a></li>


            @if(auth()->user()->hasPermission('categories_read'))
            <li><a href="{{route('dashboard.categories.index')}}"><i class="fa fa-th"></i><span>@lang('main.categories')</span></a></li>
         @endif



            @if(auth()->user()->hasPermission('products_read'))
            <li><a href="{{route('dashboard.products.index')}}"><i class="fa fa-th"></i><span>@lang('main.products')</span></a></li>
         @endif

         @if(auth()->user()->hasPermission('clients_read'))
         <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-th"></i><span>@lang('main.clients')</span></a></li>
      @endif

      @if(auth()->user()->hasPermission('orders_read'))
      <li><a href="{{route('dashboard.orders.index')}}"><i class="fa fa-th"></i><span>@lang('main.orders')</span></a></li>
   @endif

         
         @if(auth()->user()->hasPermission('users_read'))
         <li><a href="{{route('dashboard.users.index')}}"><i class="fa fa-th"></i><span>@lang('main.Users')</span></a></li>
      @endif

             
        

          
        </ul>

    </section>

</aside>

