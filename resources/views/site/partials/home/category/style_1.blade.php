@php
    //$posts = data_get($categorySection, 'category.post', collect([]));
    $blockPosts = $posts->skip(1)->take(4);
    $firstPost = $posts->first();
@endphp

<div class="sg-section">
    <div class="section-content">
        <div class="section-title">
            <h1>
                @if(data_get($categorySection, 'label') == 'videos')
                    {{__('videos')}}
                @else
                    {{ \Illuminate\Support\Str::upper(data_get($categorySection, 'label')) }}
                @endif

            </h1>
        </div>
        <div class="row">
            @if(!blank($firstPost))
                <div class="col-lg-6">
                    <div class="sg-post">
                        @include('site.partials.home.category.first_post')
                        <div class="entry-content">
                            <h3 class="entry-title"><a href="{{ route('article.detail', ['id' => $firstPost->slug]) }}">{!! $firstPost->title !!}</a></h3>
                            <div class="entry-meta mb-2">
                                <ul class="global-list">
                                    <li>{{__('post_by')}} <a href="{{ route('site.author',['id' => $firstPost['user']->id]) }}">{{ data_get($firstPost, 'user.first_name') }}</a></li>
                                    <li><a href="{{route('article.date', date('Y-m-d', strtotime($firstPost->updated_at)))}}">{{ Carbon\Carbon::parse($firstPost->updated_at)->translatedFormat('F j, Y') }}</a></li>
                                </ul>
                            </div>
                            <p> {!! strip_tags(\Illuminate\Support\Str::limit($firstPost->content, 155)) !!}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-6">
                <div class="row">
                    @foreach($blockPosts as $post)
                        <div class="col-md-6">
                            <div class="sg-post small-post">
                                @include('site.partials.home.category.block')
                                <div class="entry-content">
                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}"><p>{!! \Illuminate\Support\Str::limit($post->title, 25) !!}</p></a>
                                    <div class="entry-meta">
                                        <ul class="global-list">
                                            <li>{{ __('post_by') }} <a href="{{ route('site.author',['id' => $post->user->id]) }}">{{ data_get($post, 'user.first_name') }}</a></li>
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
