@include('layout.header');
<div class="container">
  <div class="frame">
    <div class="nav">
      <ul class"links" style="list-style-type: none;">
        <li class="signup-inactive" style="float: left; text-decoration:none;"><a class="btn" href="{{url('login')}}">Login </a></li>
        <li class="signin-active" style="float: left; text-decoration:none;"><a class="btn" href="{{url('signup')}}">Sign up </a></li>
      </ul>
    </div>
    <div ng-app ng-init="checked = false">
        @if (Session::has('error'))
            <p style="color: red">{{Session::get('error')}}</p>
        @endif
        <form class="form-signin" action="{{route('signupstore')}}" method="post">
          @csrf
            <label for="name">Full name</label>
            <input class="form-styling" type="text" name="name" placeholder=""/>
            <label for="email">Email</label>
            <input class="form-styling" type="text" name="email" placeholder=""/>
            <label for="password">Password</label>
            <input class="form-styling" type="password" name="password" placeholder=""/>
            <label for="confirmpassword">Confirm password</label>
            <input class="form-styling" type="password" name="confirmpassword" placeholder=""/>
            <input type="submit" class="btn-signup" value="Sign Up">
        </form>
    </div>
      
      {{-- <div class="forgot">
        <a href="#">Forgot your password?</a>
      </div> --}}
      
    <div>
      <div class="cover-photo"></div>
      <div class="profile-photo"></div>
      <h1 class="welcome">Welcome, Chris</h1>
      <a class="btn-goback" value="Refresh" onClick="history.go()">Go back</a>
    </div>
</div>

</div>
</body>
</html>