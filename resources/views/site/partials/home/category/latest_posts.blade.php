<div class="sg-section">
    <div class="section-content mt-3">
        <div class="section-title">
            <h1>{{ __('latest_post') }}</h1>
        </div>
        <div class="latest-post-area">
            @foreach($posts as $post)
                <div class="sg-post medium-post-style-1">
                    <div class="entry-header">
                        <div class="entry-thumbnail">
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                @if(isFileExist($post->image, $result =  @$post->image->medium_image))
                                    <img src="{{safari_check() ? basePath(@$post->image).'/'.$result : static_asset('default-image/default-358x215.png') }} " data-original="{{basePath($post->image)}}/{{ $result }}" class="img-fluid"   alt="{!! $post->title !!}"  >
                                @else
                                    <img src="{{static_asset('default-image/default-358x215.png') }}"  class="img-fluid"   alt="{!! $post->title !!}" >
                                @endif
                            </a>
                        </div>
                        @if($post->post_type=="video")
                            <div class="video-icon large-block">
                                <img src="{{static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                            </div>
                        @elseif($post->post_type=="audio")
                            <div class="video-icon large-block">
                                <img src="{{static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                            </div>
                        @endif
                    </div>
                    <div class="category">
                        <ul class="global-list">
                            @isset($post->category->category_name)
                                <li><a href="{{ url('category',$post->category->slug) }}">{{ $post->category->category_name }}</a></li>
                            @endisset
                        </ul>
                    </div>
                    <div class="entry-content align-self-center">
                        <h3 class="entry-title"><a
                                href="{{ route('article.detail', ['id' => $post->slug]) }}">{!! \Illuminate\Support\Str::limit($post->title, 65) !!}</a>
                        </h3>
                        <div class="entry-meta mb-2">
                            <ul class="global-list">
                                <li>{{ __('post_by') }} <a href="{{ route('site.author',['id' => $post->user->id]) }}">{{$post->user->first_name}} </a></li>
                                <li><a href="{{route('article.date', date('Y-m-d', strtotime($post->updated_at)))}}"> {{ Carbon\Carbon::parse($post->updated_at)->translatedFormat('F j, Y') }}</a></li>
                            </ul>
                        </div>
                        <p>{!! strip_tags(\Illuminate\Support\Str::limit($post->content, 120)) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @if($posts->count() != 0)
        <input type="hidden" id="last_id" value="1">
        <div class="col-sm-12 col-xs-12 d-none" id="latest-preloader-area">
            <div class="row latest-preloader">
                <div class="col-md-7 offset-md-5">
                    <img src="{{static_asset('site/images/')}}/preloader-2.gif" alt="Image" class="tr-preloader img-fluid">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="row">
                <button class="btn-load-more {{ $totalPostCount > 6? '':'d-none'}}" id="btn-load-more"> {{ __('load_more') }} </button>
                <button class="btn-load-more {{ $totalPostCount > 6? 'd-none':''}}" id="no-more-data">
                    {{ __('no_more_records') }}                                            </button>
                    <input type="hidden" id="url" value="{{ url('') }}">
            </div>
        </div>
        @endif
    </div><!-- /.section-content -->
</div><!-- /.sg-section -->
