<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Language\Entities\Language;
use Modules\Post\Entities\Category;
use Modules\Post\Entities\QuizQuestion;
use Modules\Post\Entities\SubCategory;
use Validator;
use Modules\User\Entities\User;
use DB;
use Illuminate\Support\Facades\Mail;
use Modules\Post\Entities\Post;
use Sentinel;
use Carbon\Carbon;
use URL;
use Illuminate\Support\Facades\Storage;
use Aws\S3\Exception\S3Exception as S3;
use Modules\Gallery\Entities\Image as galleryImage;
use Modules\Gallery\Entities\Video;
use Modules\Gallery\Entities\Audio;
use Input;
use Modules\Ads\Entities\Ad;

class PostController extends Controller
{
    public function index()
    {
        $categories     = Category::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $posts          = Post::orderBy('id','desc')->with('image','video','category','subCategory','user')->paginate('15');

        return view('post::index',compact('posts','categories','activeLang'));
    }

    public function createArticle()
    {
        $categories     = Category::where('language', \App::getLocale() ?? settingHelper('default_language'))->get();
        $subCategories  = SubCategory::all();
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage     = galleryImage::count();
        $countVideo     = Video::count();

        return view('post::article_create',compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo'));
    }
    public function saveNewPost(Request $request,$type){

//        dd($request->all());

        Validator::make($request->all(), [
            'title'             => 'required|min:2|unique:posts',
            'content'           => 'required',
            'language'          => 'required',
            'category_id'       => 'required',
            'slug'              => 'nullable|min:2|unique:posts|regex:/^\S*$/u',
        ])->validate();

        $post               =   new Post();
        $post->title        =   $request->title;
        if ($request->slug != null) :
            $post->slug = $request->slug;
        else :
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->user_id      = Sentinel::getUser()->id;
        $post->content      = $request->content;

        $post->visibility   = $request->visibility;

        $post->layout       = $request->layout;


        if(isset($request->featured)):
            $post->featured = 1;
        else :
            $post->featured = 0;
        endif;

        if(isset($request->breaking)):
            $post->breaking = 1;
        else :
            $post->breaking = 0;
        endif;

        if(isset($request->slider)):
            $post->slider   = 1;
        else :
            $post->slider   = 0;
         endif;

        if(isset($request->recommended)):
            $post->recommended  = 1;
        else :
            $post->recommended  = 0;
        endif;

        if(isset($request->editor_picks)):
            $post->editor_picks  = 1;
        else :
            $post->editor_picks  = 0;
        endif;

        if(isset($request->auth_required)):
            $post->auth_required  = 1;
        else :
            $post->auth_required  = 0;
        endif;

        $post->meta_title       = $request->meta_title;
        $post->meta_keywords    = $request->meta_keywords;
        $post->tags             = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language         = $request->language;
        $post->category_id      = $request->category_id;
        $post->sub_category_id  = $request->sub_category_id;
        $post->image_id         = $request->image_id;
        if($type == 'video'):
            if($request->video_url_type != null){
                Validator::make($request->all(), [
                    'video_thumbnail_id' => 'required'
                ])->validate();
            }
            $post->post_type            = 'video';
            $post->video_id             = $request->video_id;
            $post->video_url_type       = $request->video_url_type;
            $post->video_url            = $request->video_url;
            $post->video_thumbnail_id   = $request->video_thumbnail_id;

        elseif($type == 'audio'):

            Validator::make($request->all(), [
                'audio' => 'required'
            ])->validate();

            $post->post_type            = 'audio';
            $post->audio()->attach($request->audio_id);
        else:
            $post->post_type            = 'article';
        endif;

        if($request->status == 2) :
            $post->status           = 0;
            $post->scheduled        = 1;
            $post->scheduled_date   = Carbon::parse($request->scheduled_date);
        else :
            $post->status           = $request->status;
        endif;

        if(isset($request->scheduled)):
            $post->scheduled=1;
        endif;

        $post->contents = $request->new_content;
        $post->save();

        if($type == 'audio'):
            $post->audio()->attach($request->audio);
        endif;

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');
        Cache::forget('lastPost');
        Cache::forget('menuDetails');
        Cache::forget('primary_menu');

        return redirect()->back()->with('success',__('successfully_added'));
    }

    public function fetchCategory(Request $request)
    {
        $select         = $request->get('select');
        $value          = $request->get('value');
        $data           = Category::where('language', $value)->get();
        $output         = '<option value="">' . __('select_category') . '</option>';
        foreach ($data as $row) :
            $output     .= '<option value="' . $row->id . '">' . $row->category_name . '</option>';
        endforeach;

        echo $output;
    }

    public function fetchSubcategory(Request $request)
    {
        $select         = $request->get('select');
        $value          = $request->get('value');
        $data           = SubCategory::where('category_id', $value)->get();
        $output         = '<option value="">' . __('select_sub_category') . '</option>';
        foreach ($data as $row) :
            $output     .= '<option value="' . $row->id . '">' . $row->sub_category_name . '</option>';
        endforeach;

        echo $output;
    }

    public function slider()
    {
         $posts     = Post::orderBy('id','desc')->where('posts.slider',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::slider_posts',compact('posts'));
    }

    public function featuredPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.featured',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::featured_posts',compact('posts'));
    }

    public function breakingPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.breaking',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::breaking_posts',compact('posts'));
    }

    public function recommendedPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.recommended',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::recommended_posts',compact('posts'));
    }

    public function editorPicksPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.editor_picks',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::editor_picks',compact('posts'));
    }

    public function pendingPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.status',0)->with('image','category','subCategory','user')->paginate('15');
        return view('post::pending_posts',compact('posts'));
    }

    public function submittedPosts(){
         $posts     = Post::orderBy('id','desc')->where('posts.submitted',1)->with('image','category','subCategory','user')->paginate('15');

        return view('post::submitted_posts',compact('posts'));
    }

    public function editPost($type,$id){
        $activeLang     = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $post           = Post::where('id',$id)->with(['image','video','videoThumbnail','category','subCategory'])->first();
        $categories     = Category::where('language',$post->language)->get();
        $ads            = Ad::orderBy('id', 'desc')->get();

   /*     dd($post->category['id']);*/
        $subCategories  = [];
        if($post->category_id != ""){
            $subCategories  = SubCategory::where('category_id',$post->category['id'])->get();
        }

        $post_contents = [];
        if(!blank($post->contents)):
            foreach($post->contents as $key=>$content){
                $content_type = array_keys($content);
                //$post_contents[] = $type[0];
                foreach($content as $value){

                    $abc = [];
                    foreach($value as $key => $item){

                        if($key == 'image_id' && $key != ""){

                            $image = galleryImage::find($item);
                            $abc[] = [$key => $item, 'image' => $image];

                        }elseif($key == 'video_thumbnail_id' && $key != ""){

                            $image = galleryImage::find($item);
                            $abc[] = [$key => $item, 'video_thumbnail' => $image];

                        }elseif($key == 'video_id' && $key != ""){

                            $video = Video::find($item);
                            $abc[] = [$key => $item, 'video' => $video];
                        }else{
                            $abc[] = [$key => $item];
                        }
                    }
                    $post_contents[] =[$content_type[0] => $abc];
                }
            }
        endif;

        $countImage  = galleryImage::count();
        $countAudio  = Audio::count();
        $countVideo  = Video::count();


        if($type == 'article') :
            return view('post::article_edit',compact('post','categories','subCategories','activeLang', 'countImage','countVideo', 'post_contents', 'ads'));
        elseif($type == 'video'):
            return view('post::video_post_edit',compact('post','categories','subCategories','activeLang', 'countImage', 'countVideo', 'post_contents', 'ads'));
        elseif($type == 'audio'):
            return view('post::audio_post_edit',compact('post','categories','subCategories','activeLang', 'countImage', 'countAudio', 'countVideo', 'post_contents', 'ads'));
        endif;
    }

    public function updatePost(Request $request,$type,$id){
        // return $request;
        Validator::make($request->all(), [
            'title'             => 'required|min:2',
            'content'           => 'required',
            'language'          => 'required',
            'category_id'       => 'required',
            'slug'              => 'nullable|min:2|max:120|regex:/^\S*$/u|unique:posts,slug,' . $id,
        ])->validate();

        $post           = Post::find($id);
        $post->title    = $request->title;

        if ($request->slug != null) :
            $post->slug = $request->slug;
        else :
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->content      = $request->content;
        $post->visibility   = $request->visibility;
        $post->layout       = $request->layout;

        if(isset($request->featured)):
            $post->featured = 1;
        else :
            $post->featured = 0;
        endif;

        if(isset($request->breaking)):
            $post->breaking = 1;
        else :
            $post->breaking = 0;
        endif;

        if(isset($request->slider)):
            $post->slider   = 1;
        else :
            $post->slider   = 0;
         endif;

        if(isset($request->recommended)):
            $post->recommended  = 1;
        else :
            $post->recommended  = 0;
        endif;

        if(isset($request->editor_picks)):
            $post->editor_picks  = 1;
        else :
            $post->editor_picks  = 0;
        endif;

        if(isset($request->auth_required)):
            $post->auth_required=1;

        else :
            $post->auth_required=0;
        endif;

        $post->meta_title       = $request->meta_title;
        $post->meta_keywords    = $request->meta_keywords;
        $post->tags             = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language         = $request->language;
        $post->category_id      = $request->category_id;
        $post->sub_category_id  = $request->sub_category_id;
        $post->image_id         = $request->image_id;

        if(isset($request->video_id)):
            $post->video_id     = $request->video_id;
        endif;

        if(isset($request->video_url_type)):
            $post->video_url_type    = $request->video_url_type;
        endif;

        if(isset($request->video_url)):
            $post->video_url=$request->video_url;
        endif;
        if(isset($request->video_thumbnail_id)):
            $post->video_thumbnail_id  = $request->video_thumbnail_id;
        endif;

        if($type == 'audio'):

            Validator::make($request->all(), [
                'audio' => 'required'
            ])->validate();

            $post->audio()->detach();
            $post->audio()->attach($request->audio);

        endif;

        if($request->status == 2) :
            $post->status   = 0;
            $post->scheduled= 1;
            $post->scheduled_date=Carbon::parse($request->scheduled_date);
        else :

            $post->status=$request->status;
        endif;

        if(isset($request->scheduled)):
            $post->scheduled=1;
        endif;

        $post->contents = $request->new_content;

        $post->save();

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');
        Cache::forget('lastPost');
        Cache::forget('menuDetails');
        Cache::forget('primary_menu');

        return redirect()->back()->with('success',__('successfully_updated'));
    }

    public function removePostFrom(Request $request){
        $feature        = $request->feature;
        $post           = Post::find($request->post_id);
        $post->$feature = 0;

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        $post->save();

        $data['status']     = "success";
        $data['message']    =  __('successfully_updated');

        echo json_encode($data);

        // return redirect()->back()->with('success',__('successfully_updated'));
    }

    public function addPostTo(Request $request){
        $feature            = $request->feature;
        $post               = Post::find($request->post_id);

        $post->$feature     = 1;

        $post->save();

        Cache::forget('primarySectionPosts');
        Cache::forget('primarySectionPostsAuth');
        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        Cache::forget('sideWidgets');
        Cache::forget('headerWidgets');
        Cache::forget('footerWidgets');

        Cache::forget('categorySections');
        Cache::forget('totalPostCount');
        Cache::forget('latest_posts');

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        $data['status']     = "success";
        $data['message']    =  __('successfully_updated');

        echo json_encode($data);
    }

    public function updateSliderOrder(Request $request){

        for($i=0;$i<count($request->post_id);$i++):
            $post               =   Post::find($request->post_id[$i]);
            $post->slider_order = $request->order[$i];
            $post->save();
        endfor;

        Cache::forget('sliderPostsAuth');
        Cache::forget('sliderPosts');

        return redirect()->back()->with('success',__('successfully_updated'));
    }
    public function updateFeaturedOrder(Request $request){

        for($i=0;$i<count($request->post_id);$i++):
            $post                   = Post::find($request->post_id[$i]);
            $post->featured_order   = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success',__('successfully_updated'));
    }
    public function updateBreakingOrder(Request $request){

        for($i=0;$i<count($request->post_id);$i++){
            $post                   = Post::find($request->post_id[$i]);
            $post->breaking_order   = $request->order[$i];
            $post->save();
        }

        Cache::forget('breakingNewss');
        Cache::forget('breakingNewssAuth');

        return redirect()->back()->with('success',__('successfully_updated'));
    }
    public function updateRecommendedOrder(Request $request){
        for($i=0;$i<count($request->post_id);$i++){
            $post                   = Post::find($request->post_id[$i]);
            $post->recommended_order= $request->order[$i];
            $post->save();
        }

        return redirect()->back()->with('success',__('successfully_updated'));
    }

    public function updateEditorPicksOrder(Request $request){

        for($i=0;$i<count($request->post_id);$i++):
            $post                   = Post::find($request->post_id[$i]);
            $post->editor_picks_order   = $request->order[$i];
            $post->save();
        endfor;

        return redirect()->back()->with('success',__('successfully_updated'));
    }

    public function createVideoPost(){
        $categories         = Category::where('language', \App::getLocale() ?? settingHelper('default_language'))->get();
        $subCategories      = SubCategory::all();
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();
        $countVideo         = Video::count();

        return view('post::video_post_create',compact('categories', 'subCategories', 'activeLang', 'countImage', 'countVideo'));
    }

    public function createAudioPost(){
        $categories         = Category::where('language', \App::getLocale() ?? settingHelper('default_language'))->get();
        $subCategories      = SubCategory::all();
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $countImage         = galleryImage::count();
        $countAudio         = Audio::count();
        $countVideo         = Video::count();

        return view('post::audio_post_create',compact('categories', 'subCategories', 'activeLang', 'countImage', 'countAudio', 'countVideo'));
    }

    public function filterPost(Request $request){
        $categories         = Category::all();
        if($request->category_id == null):
            $subCategories  = [];
        else:
            $subCategories  = SubCategory::where('category_id', $request->category_id)->get();
        endif;
        // return $subCategories;
        $activeLang         = Language::where('status', 'active')->orderBy('name', 'ASC')->get();
        $search_query       = $request;

        $posts = Post::where('language', 'like', '%' . $request->language .'%')
                ->where('post_type', 'like', '%' . $request->post_type .'%')
                ->where('category_id', 'like', '%' . $request->category_id .'%')
                ->where('sub_category_id', 'like', '%' . $request->sub_category_id .'%')
                ->where('title', 'like', '%' . $request->search_key .'%')
                ->orderBy('id','desc')
                ->with('image','video','category','subCategory','user')
                ->paginate('15');
                // return $search_query;

        return view('post::post_search',compact('posts','categories','activeLang','search_query','subCategories'));

    }

    private function make_slug($string, $delimiter = '-') {

        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);

        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);
        $result = mb_strtolower($string);

        if ($result):
            return $result;
        else:
            return $string;
        endif;
    }
}
