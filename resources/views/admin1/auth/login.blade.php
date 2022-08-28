
@include('layout.header');
<div class="container">
  <div class="frame">
    <div class="nav">
      <ul class"links" style="list-style-type: none;">
        <li class="signup-active" style="float: left; text-decoration:none;"><a class="btn" href="{{url('login')}}">Login </a></li>
        <li class="signin-inactive" style="float: left; text-decoration:none;"><a class="btn" href="{{url('signup')}}">Sign up </a></li>
      </ul>
    </div>
    <div ng-app ng-init="checked = false">
      <form class="form-signin" action="{{route('loginchack')}}" method="post" name="form">
      @csrf
        <label for="username">Email</label>
        <input class="form-styling" type="text" name="email" placeholder=""/>
        <label for="password">Password</label>
        <input class="form-styling" type="password" name="password" placeholder=""/>
        <input type="checkbox" id="checkbox"/>
        {{-- <label for="checkbox" ><span class="ui"></span>Keep me signed in</label> --}}
   
          <input type="submit" class="btn-signup" value="Sign in">

      </form>
      
           
    </div>
      
      {{-- <div class="forgot">
        <a href="#">Forgot your password?</a>
      </div> --}}
      

  </div>
    
 
</div>
</body>
</html>