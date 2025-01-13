<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Modules\Ads\Entities\AdLocation;
use Modules\Appearance\Entities\ThemeSection;
use Modules\Post\Entities\Post;
use App\VisitorTracker;
use Illuminate\Support\Facades\Input;
use Sentinel;
use DB;
use Modules\Post\Entities\Category;
use File;

use function PHPUnit\Framework\isNull;

class HomeController extends Controller
{
    public function home()
    {
        $primarySection = ThemeSection::where('is_primary', 1)->first();

        $language = \App::getLocale() ?? settingHelper('default_language');

        if (Sentinel::check()):
            if (!View::exists('site.website.' . $language . '.logged.widgets')):
                $this->widgetsSection($language);
            endif;
            if ($primarySection->status == 1):
                $primarySectionPosts = Post::with(['category', 'image', 'user'])
                    ->where('visibility', 1)
                    ->where('status', 1)
                    ->where('slider', '!=', 1)
                    ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                    ->orderBY('id', 'desc')
                    ->limit(10)
                    ->get();
            else:
                $primarySectionPosts = [];
            endif;

            $sliderPosts = Post::with(['category', 'image', 'user'])
                ->where('visibility', 1)
                ->where('slider', 1)
                ->where('status', 1)
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->orderBY('id', 'desc')
                ->limit(5)
                ->get();

            $categorySections = ThemeSection::with('ad')
                ->with(['category'])
                ->where('is_primary', '<>', 1)
                ->orderBy('order', 'ASC')
                ->where(function ($query) {
                    $query->where('language', \App::getLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                })
                ->get();

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts = Post::with('category', 'image', 'user')
                ->where('post_type', 'video')
                ->where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(8)
                ->get();

            $latest_posts = Post::with('category', 'image', 'user')
                ->where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(6)
                ->get();

            $totalPostCount = Post::where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->count();
        else:
            if ($primarySection):
                if ($primarySection->status == 1):
                    $primarySectionPosts = Post::with(['category', 'image', 'user'])
                        ->where('visibility', 1)
                        ->where('status', 1)
                        ->where('slider', '!=', 1)
                        ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                        ->orderBY('id', 'desc')
                        ->when(Sentinel::check() == false, function ($query) {
                            $query->where('auth_required', 0);
                        })
                        ->limit(10)
                        ->get();
                else:
                    $primarySectionPosts = [];
                endif;
            else:
                $primarySectionPosts = [];
            endif;

            $sliderPosts = Post::with(['category', 'image', 'user'])
                ->where('visibility', 1)
                ->where('slider', 1)
                ->where('status', 1)
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBY('id', 'desc')
                ->limit(5)
                ->get();

            $categorySections = ThemeSection::with('ad')
                ->with(['category'])
                ->where('is_primary', '<>', 1)
                ->orderBy('order', 'ASC')
                ->where(function ($query) {
                    $query->where('language', \App::getLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                })
                ->get();

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts = Post::with('category', 'image', 'user')
                ->where('post_type', 'video')
                ->where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(8)
                ->get();

            $latest_posts = Post::with('category', 'image', 'user')
                ->where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(6)
                ->get();

            $totalPostCount = Post::where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->count();
        endif;

        $tracker = new VisitorTracker();
        $tracker->page_type = \App\Enums\VisitorPageType::HomePage;
        $tracker->url = \Request::url();
        $tracker->source_url = \url()->previous();
        $tracker->ip = \Request()->ip();
        $tracker->agent_browser = UserAgentBrowser(\Request()->header('User-Agent'));

        $tracker->save();

        //        if (!View::exists('site.website.'.$language.'.widgets')):
        //            $this->widgetsSection($language);
        //        endif;
        //        if (!View::exists('site.website.category_sections')):
        //            $this->categorySections($language);
        //        endif;

        return view('site.pages.home', compact('primarySection', 'primarySectionPosts', 'sliderPosts', 'categorySections', 'video_posts', 'totalPostCount', 'latest_posts'));
    }

    public function categorySections($language)
    {
        if (Sentinel::check()):
            $categorySections = ThemeSection::with('ad')
                ->with(['category'])
                ->where('is_primary', '<>', 1)
                ->orderBy('order', 'ASC')
                ->where(function ($query) {
                    $query->where('language', \App::getLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                })
                ->get();

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts = Post::with('category', 'image', 'user')
                ->where('post_type', 'video')
                ->where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(8)
                ->get();

            $latest_posts = Post::with('category', 'image', 'user')
                ->where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(6)
                ->get();

            $totalPostCount = Post::where('visibility', 1)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->count();
        else:
            $categorySections = ThemeSection::with('ad')
                ->with(['category'])
                ->where('is_primary', '<>', 1)
                ->orderBy('order', 'ASC')
                ->where(function ($query) {
                    $query->where('language', \App::getLocale() ?? settingHelper('default_language'))->orWhere('language', null);
                })
                ->get();

            $categorySections->each(function ($section) {
                $section->load('post');
            });

            $video_posts = Post::with('category', 'image', 'user')
                ->where('post_type', 'video')
                ->where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(8)
                ->get();

            $latest_posts = Post::with('category', 'image', 'user')
                ->where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->limit(6)
                ->get();

            $totalPostCount = Post::where('visibility', 1)
                ->where('status', 1)
                ->when(Sentinel::check() == false, function ($query) {
                    $query->where('auth_required', 0);
                })
                ->orderBy('id', 'desc')
                ->where('language', \App::getLocale() ?? settingHelper('default_language'))
                ->count();
        endif;

        if (fopen(resource_path() . '/views/site/website/category_sections.blade.php', 'w')):
            $file = resource_path() . '/views/site/website/category_sections.blade.php';
            $view = view('site.partials.home.category_section', compact('categorySections', 'video_posts', 'totalPostCount', 'latest_posts'))->render();
            File::put($file, $view);
        endif;

        //        return view('site.partials.home.category_section',compact('categorySections','video_posts','totalPostCount','latest_posts'))->render();
    }

    public function widgetsSection($language)
    {
        if (Sentinel::Check()):
            $path = resource_path() . '/views/site/website/' . $language . '/logged';
        else:
            $path = resource_path() . '/views/site/website/' . $language;
        endif;

        File::makeDirectory($path, 0777, true, true);

        $file = $path . '/widgets.blade.php';

        if (fopen($file, 'w')):
            $view = view('site.partials.right_sidebar_widgets');

            File::put($file, $view);
        endif;
    }
}
