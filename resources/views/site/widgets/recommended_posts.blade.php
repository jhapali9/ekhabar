@php
    $firstPost = $content->first();
@endphp
@if (!blank($content))
    <div class="sg-widget">
        <h3 class="widget-title">{{ data_get($detail, 'title') }}</h3>

        <div class="sg-post featured-post">
            @include('site.partials.home.category.first_post')
            <div class="entry-content absolute">
                <div class="category">
                    <ul class="global-list">
                        @isset($firstPost->category)
                            <li><a href="{{ url('category',$firstPost->category->slug) }}">{{ data_get($firstPost, 'category.category_name') }}</a></li>
                        @endisset
                    </ul>
                </div>
                <h2 class="entry-title">
                    <a href="{{ route('article.detail', [$firstPost->slug]) }}">{{ \Illuminate\Support\Str::limit(data_get($firstPost, 'title'), 100) }}</a>
                </h2>
                <div class="entry-meta">
                    <ul class="global-list">
                        <li>{{ __('post_by') }}<a href="{{ route('site.author',['id' => $firstPost->user->id]) }}"> {{ data_get($firstPost, 'user.first_name') }}</a></li>
                        <li><a href="{{route('article.date', date('Y-m-d', strtotime($firstPost->updated_at)))}}"> {{ Carbon\Carbon::parse($firstPost->updated_at)->translatedFormat('F j, Y') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="global-list">
            @foreach($content as $post)
                @if(!$loop->first)
                    <li>
                        <div class="sg-post small-post post-style-1">
                            @include('site.partials.home.category.post_block')
                            <div class="entry-content">
                                <a href="{{ route('article.detail', ['id' => $post->slug]) }}"><p>{{ \Illuminate\Support\Str::limit(data_get($post, 'title'), 25) }}</p></a>
                                <div class="entry-meta">
                                    <ul class="global-list">
                                        <li class="d-sm-none d-md-none d-lg-block">{{ __('post_by') }}<a href="{{ route('site.author',['id' => $post->user->id]) }}"> {{ data_get($post, 'user.first_name') }}</a></li>
                                        <li><a href="{{route('article.date', date('Y-m-d', strtotime($post->updated_at)))}}"> {{ Carbon\Carbon::parse($post->updated_at)->translatedFormat('F j, Y') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif
