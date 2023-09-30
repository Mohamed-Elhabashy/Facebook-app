<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;

use Illuminate\Support\Facades\Auth;
class FriendController extends Controller
{
    public function SendFriend($user_id)
    {
        Friend::create([
            'user_id1'=>Auth::user()->id,
            'user_id2'=>$user_id,
            'accepted'=>false
        ]);
        return redirect()->back();
    }
    public function update($id)
    {
        $friend = Friend::where('user_id1', $id)->where('user_id2', Auth::user()->id)->first();
        
        if ($friend!=null) {
            $friend->update([
                'accepted' => true
            ]);
        }
    
        return redirect()->back();
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $friend=Friend::where('user_id2',$id)->where('user_id1',Auth::user()->id)->first();
        if($friend==null){
            $friend=Friend::where('user_id1',$id)->where('user_id2',Auth::user()->id)->first();
        }
        if($friend!=null){
            $friend->delete();
        }
        return redirect()->back();
    }
}
