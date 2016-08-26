<?php
/**
 * Created by IntelliJ IDEA.
 * User: LeTung
 * Date: 西暦16/07/02
 * Time: 19:55
 */

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class TopicController extends BaseController
{

    public function createPage()
    {

        $categories = Category::get();
        return \View::make('topic.create',['categories' => $categories]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create(Request $request)
    {
        $user = Auth::user();

        $topic = new Topic();
        $topic->category_id = $request->input('category_id');
        $topic->content = $request->input('content');
        $topic->title = $request->input('title');
        $topic->tags = $request->input('tags');
        $topic->user_id = $user->id;


        $topic->save();
        //TODO check validate

        return redirect()->route('index');
    }


    public function viewTopic($id)
    {
        $topic = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->where('topics.id', $id)
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name')
            ->first();
        //Like
        $data['topic'] = $topic;
        $data['up_vote'] = 0;
        $data['down_vote'] = 0;

        // sort comment by upvote

        $comments = Comment::join('users', 'users.id', '=', 'user_id')
            ->where('topic_id', $id)
            ->select('comments.*', 'users.name as user_name')
            ->get();
        $data['comments'] = $comments;
        return \View::make('topic.view',['data' => $data]);
    }

    public function editTopicPage($id)
    {

    }


    public function commentTopic(Request $request)
    {
        $user = Auth::user();
        $topic_id = $request->input('topic_id');

        $comment = new Comment();
        $comment->content = $request->input('m_comment');
        $comment->user_id = $user->id;
        $comment->topic_id = $topic_id;
        $comment->save();

        return Redirect::to('/topic/view/'.$topic_id);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItems(Request $request)
    {
        $this->validate($request, [
            'csv_file' => 'file|required',
            'data_type' => 'required'
        ]);


        return redirect()->route('item_list');
    }

}