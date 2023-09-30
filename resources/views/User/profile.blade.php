@extends('shared.layout')
@section('content')

  <!-- main -->
  <main class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- edit profile -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Edit profile</h4>
            <form method="post" action="{{route('user.edit.profile')}}">
              @csrf
              <div class="form-group">
                <input class="form-control" type="text" name="status" placeholder="Status" value="">
              </div>

              <div class="form-group">
                <input class="form-control" type="text" name="location" placeholder="Location" value="">
              </div>

              <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_profile" value="Save">
              </div>
            </form>
          </div>
        </div>
        <!-- ./edit profile -->
      </div>
      <div class="col-md-6">
        <!-- user profile -->
        <div class="media">
          <div class="media-left">
            <img src="{{asset('img')}}/my_avatar.png" class="media-object" style="width: 128px; height: 128px;">
          </div>
          <div class="media-body">
            <h2 class="media-heading">{{$data['user_information']['name']}}</h2>
            <p>Status: {{$data['user_information']['status']}}, Location: {{$data['user_information']['location']}}</p>
          </div>
        </div>
        <!-- user profile -->

        <hr>

        <!-- timeline -->
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
        <!-- ./timeline -->
      </div>
      <div class="col-md-3">
        <!-- friends -->
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Friends</h4>
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