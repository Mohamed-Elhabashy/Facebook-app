@extends('shared.layout')
@section('content')

  <!-- main -->
  <main class="container">
  <h1 class="text-center">Welcome to FaceClone! <br><small>A simple Facebook clone.</small></h1>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
    <div class="row">
      <div class="col-md-6">
        <h4>Login to start enjoying unlimited fun!</h4>
        

        <!-- login form -->
        <form method="post" action="{{ route('submit.login') }}">
          @csrf
          <div class="form-group">
            <input class="form-control" type="text" name="email" placeholder="email">
          </div>

          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="form-group">
            <input class="btn btn-primary" type="submit" name="login" value="Login">
          </div>
        </form>
        <!-- ./login form -->
      </div>
      <div class="col-md-6">
        <h4>Don't have an account yet? Register!</h4>

        <!-- register form -->
        <form method="post" action="{{ route('submit.register') }}">
          @csrf
          <div class="form-group">
            <input class="form-control" type="text" name="email" placeholder="Email">
          </div>

          <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Name">
          </div>

          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>

          <div class="form-group">
            <input class="btn btn-success" type="submit" name="register" value="Register">
          </div>
        </form>
        <!-- ./register form -->
      </div>
    </div>
  </main>
  <!-- ./main -->

  @endsection('content')