@php
    $blockPosts = $posts->take(4);
@endphp

<div class="sg-breaking-news">
    <div class="container">
        <div class="breaking-content d-flex">
            <span>{{ __('breaking_news') }}</span>
            <ul class="news-ticker">
                @foreach($breakingNewss as $post)
                    <li id="display-nothing">
                        <a href="{{ route('article.detail', ['id' => $post->slug]) }}">{!! \Illuminate\Support\Str::limit($post->title, 100) !!}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="sg-home-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="post-slider">
                    @foreach($sliderPosts as $post)
                        <div class="sg-post featured-post">
                            @include('site.partials.home.primary.slider')
                            <div class="entry-content absolute">
                                <div class="category">
                                    <ul class="global-list">
                                        @isset($post['category']->category_name)
                                            <li>
                                                <a href="{{ url('category',$post['category']->slug) }}">{{ $post['category']->category_name }}</a>
                                            </li>
                                        @endisset
                                    </ul>
                                </div>
                                <h2 class="entry-title">
                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}">{!! \Illuminate\Support\Str::limit($post->title, 50) !!}</a>
                                </h2>
                                <div class="entry-meta">
                                    <ul class="global-list">
                                        <li>{{ __('post_by') }} <a
                                                href="{{ route('site.author',['id' => $post['user']->id]) }}">{{ data_get($post, 'user.first_name') }}</a>
                                        </li>
                                        <li><a href="{{route('article.date', date('Y-m-d', strtotime($post->updated_at)))}}">{{ Carbon\Carbon::parse($post->updated_at)->translatedFormat('F j, Y') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-12">
                <div class="section-title">
                    <h1>
                        {{ __('recent.news') }}
                    </h1>
                </div>
                <div class="row">
                    @foreach($blockPosts as $post)
                    <div class="col-md-6">
                            <div class="sg-post">
                                <div class="entry-header">
                                    <div class="entry-thumbnail">
                                        <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                            @if(isFileExist(@$post['image'], $result = @$post['image']->medium_image))
                                                <img src="{{ safari_check() ? basePath(@$post['image']).'/'.$result : static_asset('default-image/default-358x215.png')  }} "
                                                     data-original=" {{basePath(@$post['image'])}}/{{ $result }} "
                                                     class="img-fluid lazy" alt="{!! $post->title !!}">
                                            @else
                                                <img src="{{ static_asset('default-image/default-358x215.png') }} "
                                                     class="img-fluid" alt="{!! $post->title !!}">
                                            @endif
                                        </a>
                                    </div>
                                   @if($post->post_type=="video")
                                        <div class="video-icon block">
                                            <img src="{{static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                        </div>
                                    @elseif($post->post_type=="audio")
                                        <div class="video-icon block">
                                            <img src="{{static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                        </div>
                                    @endif
                                    <div class="category">
                                        <ul class="global-list">
                                            @isset($post->category->category_name)
                                                <li>
                                                    <a href="{{ url('category',$post['category']->slug) }}">{{ $post['category']->category_name }}</a>
                                                </li>
                                            @endisset
                                        </ul>
                                    </div>
                                </div>
                                <div class="entry-content block">
                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                        <p>{!! \Illuminate\Support\Str::limit($post->title, 40) !!}</p></a>
                                    <div class="entry-meta">
                                        <ul class="global-list">
                                            <li><a href="{{route('article.date', date('Y-m-d', strtotime($post->updated_at)))}}"> {{ Carbon\Carbon::parse($post->updated_at)->translatedFormat('F j, Y') }}</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


