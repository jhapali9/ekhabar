@extends('site.layouts.app')

@section('content')
    @include('site.partials.home.primary_section', [
        'section' => $primarySection,
        'posts' => $primarySectionPosts,
        'sliderPosts' => $sliderPosts,
    ])

    <div class="sg-main-content mb-4">
        <div class="container">
            <div class="row">
                @php
                    $language = \App::getLocale() ?? settingHelper('default_language')
                @endphp
                <div class="col-md-7 col-lg-8 sg-sticky">
                    <div class="theiaStickySidebar">
                        @include('site.partials.home.category_section')
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 sg-sticky">
                    <div class="sg-sidebar theiaStickySidebar">
                        @include('site.partials.right_sidebar_widgets')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
