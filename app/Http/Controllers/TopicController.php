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
use App\Models\Vote;
use Classes\Services\VoteService;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TopicController extends BaseController
{

    public function createPage()
    {

        $categories = Category::get();
        $statuses = Topic::getAllStatus();

        return \View::make('topic.create',[
            'categories' => $categories,
            'statuses' => $statuses]
            );
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
        $topic->status = $request->input('status');
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
        $voteService = new VoteService();

        $topic = Topic::join('users', 'users.id', '=', 'user_id')
            ->join('categories', 'categories.id', '=', 'category_id')
            ->where('topics.id', $id)
            ->select('topics.*', 'users.name as user_name', 'categories.name as category_name')
            ->first();
        if(!$topic){
            return Redirect::to('/');
        }

        //Like
        $data['topic'] = $topic;
        $data['up_vote'] = $voteService->countTopicVote($id, Vote::TYPE_VOTE_UP);
        $data['down_vote'] = $voteService->countTopicVote($id, Vote::TYPE_VOTE_DOWN);
        $data['is_up_voted'] = $voteService->isVoted(Vote::TARGET_TOPIC, Vote::TYPE_VOTE_UP, $id);
        $data['is_down_voted'] = $voteService->isVoted(Vote::TARGET_TOPIC, Vote::TYPE_VOTE_DOWN, $id);

        // sort comment by upvote

        $comments = Comment::join('users', 'users.id', '=', 'user_id')
            ->where('topic_id', $id)
            ->select('comments.*', 'users.name as user_name')
            ->get();

        $comments_data = Array();

        foreach ($comments as $comment){
            $comment_data = Array();
            $comment_data['comment'] = $comment;

            $comment_data['is_up_voted'] = $voteService->isVoted(Vote::TARGET_COMMENT, Vote::TYPE_VOTE_UP, $comment->id);
            $comment_data['is_down_voted'] = $voteService->isVoted(Vote::TARGET_COMMENT, Vote::TYPE_VOTE_DOWN, $comment->id);
            $comment_data['up_vote'] = $voteService->countCommentVote($comment->id, Vote::TYPE_VOTE_UP);
            $comment_data['down_vote'] = $voteService->countCommentVote($comment->id, Vote::TYPE_VOTE_DOWN);

            $comments_data[] = $comment_data;
        }

        $data['comments_data'] = $this->_sortCommentList($comments_data);

        return \View::make('topic.view',['data' => $data]);
    }

    public function editTopicPage($id)
    {
        $user = Auth::user();
        $topic = Topic::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
        if($topic){
            $categories = Category::get();
            $statuses = Topic::getAllStatus();

            return \View::make('topic.edit', [
                'topic'=> $topic,
                'categories' => $categories,
                'statuses' => $statuses]);
        }else{
            return Redirect::to('/topic/view/'.$id);
        }

    }

    public function editTopic(Request $request)
    {
        $id = $request->input('id');

        $user = Auth::user();
        $topic = Topic::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
        $topic->status = $request->input('status');
        $topic->category_id = $request->input('category_id');
        $topic->content = $request->input('content');
        $topic->title = $request->input('title');
        $topic->tags = $request->input('tags');
        $topic->save();

        return Redirect::to('/topic/view/'.$id);

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


    private function _sortCommentList($array){
        $array = array_values(array_sort($array, function ($value) {
            return $value['up_vote'];
        }));
        $array = array_reverse($array);
        return $array;
    }

}