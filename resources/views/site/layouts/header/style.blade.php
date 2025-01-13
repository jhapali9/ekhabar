 <header class="sg-header">
     <div class="sg-topbar topbar-style-2">
         <div class="container-fluid">
             <div class="d-flex justify-content-between align-items-center">
                 <div class="left-contennt">
                     <div class="logo-text-wrap">
                         <h1><a class="" href="{{ route('home') }}"><img src="{{ static_asset(settingHelper('logo')) }}" alt="Logo" class="img-fluid"></a></h1>
                     </div>
                 </div><!-- /.left-contennt -->
                 <div class="middle-content">
                     <div class="d-flex  justify-content-between">
                         <div class="weather-content d-flex align-self-center">
                             <div class="date">
                                 <span><i class="fa fa-calendar mr-2" aria-hidden="true"></i>{{ Carbon\Carbon::parse(date('l, d F Y'))->translatedFormat('l, d F Y') }}</span>
                             </div>
                         </div>
                         <div class="sg-search">
                             <div class="search-form">
                                 <form action="{{ route('article.search') }}" id="search" method="GET">
                                     <label class="d-none"> Search </label>
                                     <input class="form-control" name="search" type="text" placeholder="{{ __('search') }}">
                                     <button type="submit" name="search"><i class="fa fa-search"></i></button>
                                 </form>
                             </div>
                         </div>
                         <div class="sg-user ml-4 mt-2">
                             @if(Cartalyst\Sentinel\Laravel\Facades\Sentinel::check())
                                 <div class="dropdown">
                                     <a class="nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                         @if(Sentinel::getUser()->profile_image != null)
                                             <img src="{{static_asset('default-image/user.jpg') }}" data-original="{{static_asset(Sentinel::getUser()->profile_image)}}"  class="profile">
                                         @else
                                             <i class="fa fa-user-circle mr-2"></i>
                                         @endif
                                             {{ Sentinel::getUser()->first_name}}<i class="fa fa-angle-down  ml-2" aria-hidden="true"></i>
                                     </a>

                                     <div class="dropdown-menu dropdown-menu-right nav-user-dropdown site-setting-area" aria-labelledby="navbarDropdownMenuLink2">
                                         @if(Sentinel::getUser()->roles[0]->id != 4 && Sentinel::getUser()->roles[0]->id != 5)
                                             <a class="" href="{{ route('dashboard') }} " target="_blank"><i class="fa fa-tachometer mr-2" aria-hidden="true"></i>{{__('dashboard')}}</a>
                                         @endif
                                         <a class=""  href="{{ route('site.profile') }}"><i class="fa fa-user mr-2"></i>{{__('profile')}}</a>

                                         <a class=""  href="{{ route('site.profile.form') }}"><i class="fa fa-cog mr-2"></i>{{__('edit_profile')}}</a>

                                         <a class="" href="{{ route('site.logout') }}"><i class="fa fa-power-off mr-2"></i>{{__('logout')}}</a>
                                     </div>
                                 </div>
                             @else
                                 <span>
                                    <i class="fa fa-user-circle mr-2" aria-hidden="true"></i>
                                    <a href="{{ route('site.login.form') }}">{{ __('login') }}</a> / <a href="{{ route('site.register.form') }}"> {{ __('sign_up') }}</a>
                                </span>
                             @endif
                         </div>
                     </div>
                     <div class="ad-thumb">
                         @include('site.partials.ads', ['ads' => $headerWidgets])
                     </div>
                 </div>
                 @if($lastPost != null)
                 <div class="right-content">
                     <div class="sg-post small-post">
                         <div class="entry-header">
                             <div class="entry-thumbnail">
                                 <a href="{{ route('article.detail', ['id' => $lastPost->slug]) }}">
                                     @if(isFileExist(@$lastPost->image, $result = @$lastPost->image->small_image))
                                         <img src="{{ safari_check() ? basePath(@$lastPost->image).'/'.$result : static_asset('default-image/default-240x160.png') }} " data-original=" {{basePath($lastPost->image)}}/{{$result }} " class="img-fluid"   alt="{!! $lastPost->title !!}"  >
                                     @else
                                         <img src="{{static_asset('default-image/default-240x160.png') }} "  class="img-fluid"   alt="{!! $lastPost->title !!}" >
                                     @endif
                                 </a>
                             </div>
                             @if($lastPost->post_type=="video")
                                 <div class="video-icon">
                                     <img src="{{static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                 </div>
                             @elseif($lastPost->post_type=="audio")
                                 <div class="video-icon">
                                     <img src="{{static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                 </div>
                             @endif
                         </div>
                         <div class="entry-content absolute">
                             <div class="category">
                                 <ul class="global-list">
                                     @isset($lastPost->category)
                                        <li><a href="{{ url('category',$lastPost->category->slug) }}">{{@$lastPost->category->category_name}}</a></li>
                                     @endisset
                                 </ul>
                             </div>
                             <p><a href="{{ route('article.detail', ['id' => $lastPost->slug]) }}">{{\Illuminate\Support\Str::limit(@$lastPost->title, 30) }}</a></p>
                         </div><!-- /.entry-content -->
                     </div>
                 </div>
                 @endif<!-- /.right-content -->
             </div>
         </div><!-- /.container -->
     </div><!-- /.sg-topbar -->

     <div class="sg-menu menu-style-2">
         <nav class="navbar navbar-expand-lg">
             <div class="container">
                 <div class="menu-content">
                     <a class="navbar-brand p-0 sm-logo" href="{{ route('home') }}"><img src="{{ static_asset(settingHelper('logo')) }}" alt="Logo" class="img-fluid mt-2"></a>
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon mt-0"><i class="fa fa-align-justify"></i></span>
                     </button>

                     <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">

                            @foreach($primaryMenu as $mainMenu)

                                @if($mainMenu->is_mega_menu == 'no')
                                    <li class="nav-item sg-dropdown">
                                        <a href="{{menuUrl($mainMenu)}}" target="{{$mainMenu->new_teb == 1? '_blank':''}}">{{$mainMenu->label == 'gallery'? __('gallery'):$mainMenu->label}} @if(!blank($mainMenu->children))<span><i class="fa fa-angle-down" aria-hidden="true"></i></span>@endif </a>
                                        <ul class="sg-dropdown-menu">
                                            @foreach($mainMenu->children as $child)
                                                <li class=""><a href="{{menuUrl($child)}}" target="{{$child->new_teb == 1? '_blank':''}}">{{@$child->label}} @if(!blank($child->children)) <span class="pull-right"><i class="fa fa-angle-right" aria-hidden="true"></i></span>@endif</a>
                                                    <ul class="sg-dropdown-menu-menu">
                                                        @foreach($child->children as $subChild)
                                                            <li class=""><a href="{{menuUrl($subChild)}}" target="{{$subChild->new_teb == 1? '_blank':''}}">{{@$subChild->label}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif

                            @endforeach
                        </ul>
                     </div>
                 </div><!-- /.menu-content -->
             </div><!-- /.container -->
         </nav><!-- /.navbar -->
     </div><!-- /.sg-menu -->
 </header><!-- /.sg-header -->
