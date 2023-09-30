<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public $user;
    public function Index(){
        $this->user=Auth::user();
        // Get friends who have accepted friend requests
        $friends = $this->user->friends()->get();
        
        // Get friends who have requested friend
        $request_friends = $this->user->request_friends();
        

        
        $friendIds=$this->GetFriendsId();
        
        
        $data['posts'] = DB::table('users')
        ->select('users.id as user_id', 'users.name as user_name', 'posts.id as post_id', 'posts.content','posts.created_at')
        ->whereIn('users.id', $friendIds)
        ->join('posts', 'users.id', '=', 'posts.user_id')
        ->orderBy('posts.created_at', 'desc')
        ->get();

        
        $data['usersNotInFriends']=$this->GetNonFriends($friendIds);

        $data['friends']=$friends;
        $data['request_friends']=$request_friends;
        return view('index')->with('data',$data);
    }
    public function GetFriendsId(){
        $friends = Friend::select('user_id1','user_id2')->where(function ($query) {
            $query->where('user_id1', $this->user->id)
                  ->orWhere('user_id2', $this->user->id);
        })
        ->where('accepted', true)
        ->get();

        $friendsIds = [];

        foreach ($friends as $friendId) {
            if ($friendId->user_id1 == $this->user->id) {
                $friendsIds[] = $friendId->user_id2;
            } elseif ($friendId->user_id2 == $this->user->id) {
                $friendsIds[] = $friendId->user_id1;
            }
        }
        return $friendsIds;
    }
    public function GetNonFriends($friendIds){
        return User::select('id','name')->whereNotIn('id', $friendIds)
                    ->where('id', '!=', Auth::id())
                    ->whereDoesntHave('sentFriendRequests', function ($query) {
                        $query->where('user_id2', Auth::id())->where('accepted', 0);
                    })
                    ->whereDoesntHave('receivedFriendRequests', function ($query) {
                        $query->where('user_id1', Auth::id())->where('accepted', 0);
                    })
                    ->take(10)
                    ->get();
    }
}
