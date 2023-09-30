<!DOCTYPE html>
<html>
<head>
  <title>FaceClone</title>

  <link rel="stylesheet" type="text/css" href="{{asset('front')}}/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('css')}}/app.css">
</head>
<body>
  <!-- nav -->
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="{{route('home')}}">FaceClone</a>
      </div>
      @if(Auth::user()!=null)
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('home')}}">Home</a></li>
        <li><a href="{{route('user.profile')}}">Profile</a></li>
        <li><a href="{{route('logout')}}">Logout</a></li>
      </ul>
      @endif
    </div>
  </nav>
  <!-- ./nav -->