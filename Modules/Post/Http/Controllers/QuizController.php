<?php

namespace Modules\Post\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\QuizAnswer;
use Modules\Post\Entities\QuizQuestion;
use Modules\Post\Entities\QuizResult;
use Validator;
use Sentinel;

class QuizController extends Controller
{
    public function saveNewQuiz(Request $request, $type)
    {
        //        dd($request->all());

        Validator::make($request->all(), [
            'title' => 'required|min:2|unique:posts',
            'language' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            //            'slug'              => 'nullable|min:2|unique:posts|regex:/^\S*$/u',
        ])->validate();

        $post = new Post();
        $post->title = $request->title;

        if ($request->slug != null):
            $post->slug = $request->slug;
        else:
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->user_id = Sentinel::getUser()->id;
        $post->content = $request->content;

        $post->visibility = $request->visibility;

        $post->layout = $request->layout;
        $post->post_type = $type;

        if (isset($request->featured)):
            $post->featured = 1;
        else:
            $post->featured = 0;
        endif;

        if (isset($request->breaking)):
            $post->breaking = 1;
        else:
            $post->breaking = 0;
        endif;

        if (isset($request->slider)):
            $post->slider = 1;
        else:
            $post->slider = 0;
        endif;

        if (isset($request->recommended)):
            $post->recommended = 1;
        else:
            $post->recommended = 0;
        endif;

        if (isset($request->editor_picks)):
            $post->editor_picks = 1;
        else:
            $post->editor_picks = 0;
        endif;

        if (isset($request->auth_required)):
            $post->auth_required = 1;
        else:
            $post->auth_required = 0;
        endif;

        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->tags = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language = $request->language;
        $post->category_id = $request->category_id;
        $post->sub_category_id = $request->sub_category_id;
        $post->image_id = $request->image_id;

        if ($request->status == 2):
            $post->status = 0;
            $post->scheduled = 1;
            $post->scheduled_date = Carbon::parse($request->scheduled_date);
        else:
            $post->status = $request->status;
        endif;

        if (isset($request->scheduled)):
            $post->scheduled = 1;
        endif;

        $post->save();

        $last_post_id = $post->id;

        Cache::Flush();

        return redirect()->back()->with('success', __('successfully_added'));
    }
    public function updateQuiz(Request $request, $type, $id)
    {
        Validator::make($request->all(), [
            'title' => 'required|min:2',
            'language' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'slug' => 'nullable|min:2|max:120|regex:/^\S*$/u|unique:posts,slug,' . $id,
        ])->validate();

        $post = Post::findOrfail($id);
        $post->title = $request->title;
        $post->content = $request->content;

        if ($request->slug != null):
            $post->slug = $request->slug;
        else:
            $post->slug = $this->make_slug($request->title);
        endif;

        $post->visibility = $request->visibility;
        $post->layout = $request->layout;

        if (isset($request->featured)):
            $post->featured = 1;
        else:
            $post->featured = 0;
        endif;

        if (isset($request->breaking)):
            $post->breaking = 1;
        else:
            $post->breaking = 0;
        endif;

        if (isset($request->slider)):
            $post->slider = 1;
        else:
            $post->slider = 0;
        endif;

        if (isset($request->recommended)):
            $post->recommended = 1;
        else:
            $post->recommended = 0;
        endif;

        if (isset($request->editor_picks)):
            $post->editor_picks = 1;
        else:
            $post->editor_picks = 0;
        endif;

        if (isset($request->auth_required)):
            $post->auth_required = 1;
        else:
            $post->auth_required = 0;
        endif;

        $post->meta_title = $request->meta_title;
        $post->meta_keywords = $request->meta_keywords;
        $post->tags = $request->tags;
        $post->meta_description = $request->meta_description;
        $post->language = $request->language;
        $post->category_id = $request->category_id;
        $post->sub_category_id = $request->sub_category_id;
        $post->image_id = $request->image_id;

        if ($request->status == 2):
            $post->status = 0;
            $post->scheduled = 1;
            $post->scheduled_date = Carbon::parse($request->scheduled_date);
        else:
            $post->status = $request->status;
        endif;

        if (isset($request->scheduled)):
            $post->scheduled = 1;
        endif;

        $post->save();

        Cache::Flush();

        return redirect()->back()->with('success', __('successfully_updated'));
    }

    private function make_slug($string, $delimiter = '-')
    {
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", '', $string);

        $string = preg_replace('/[\/_|+ -]+/', $delimiter, $string);
        $result = mb_strtolower($string);

        if ($result):
            return $result;
        else:
            return $string;
        endif;
    }
}
