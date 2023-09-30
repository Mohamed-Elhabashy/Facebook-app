@extends('shared.layout')
@section('content')
<!-- main -->
  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- profile brief -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>{{Auth::user()->name}}</h4>
            <p>{{Auth::user()->status}}</p>
          </div>
        </div>
        <!-- ./profile brief -->

        <!-- friend requests -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friend requests</h4>
            <ul>
              
                @foreach($data['request_friends'] as $friend)
                  <li>
                    <b>{{$friend->user_name}}</b>
                    <a class="text-success" href="{{ route('friends.accept', $friend->user_id1) }}">[accept]</a> 
                    
                    <a href="#" class="text-danger" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                      [decline]
                    </a>
                    
                    <form id="delete-form" action="{{ route('friends.destroy', $friend->user_id1) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                  </li>
                @endforeach
            </ul>
          </div>
        </div>
        <!-- ./friend requests -->
      </div>
      <div class="col-md-6">
        <!-- post form -->
        <form method="post" action="{{route('post.store')}}">
          @csrf
          <div class="input-group">
            <input class="form-control" type="text" name="content" placeholder="Make a post...">
            <span class="input-group-btn">
              <button class="btn btn-success" type="submit" name="post">Post</button>
            </span>
          </div>
        </form><hr>
        <!-- ./post form -->

        <!-- feed -->
        <div>
          <!-- post -->
          @foreach($data['posts'] as $post)
            <div class="panel panel-default">
              <div class="panel-body">
                <p>{{$post->content}}</p>
              </div>
              <div class="panel-footer">
                <span>posted {{$post->created_at}} by {{$post->user_name}}</span> 
              </div>
            </div>
          
          @endforeach
          <!-- ./post -->
        </div>
        <!-- ./feed -->
      </div>
      <div class="col-md-3">
      <!-- add friend -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>add friend</h4>
            <ul>
                @foreach($data['usersNotInFriends'] as $model)
                  <li>
                    {{$model->name}} 
                    <a href="{{route('friends.SendFriend',$model->id)}}">[add]</a>
                  </li>
                @endforeach
            </ul>
          </div>
        </div>
        <!-- ./add friend -->

        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>friends</h4>
            <ul>
              @foreach($data['friends'] as $friend)
                <li>
                  @if($friend->user_id1==Auth::User()->id)
                   <b>{{$friend->user2_name}}</b>
                  @endif 
                  @if($friend->user_id2==Auth::User()->id)
                    <b>{{$friend->user1_name}}</b>
                  @endif 
                  <form action="{{route('friends.destroy',($friend->user_id1==Auth::User()->id?$friend->user_id2:$friend->user_id1))}}" method="POST" class="">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="unfriend" class="btn btn-sm btn-danger">
                  </form>
                  
                     <br>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <!-- ./friends -->
      </div>
    </div>
  </main>
  <!-- ./main -->
 @endsection('content')
 