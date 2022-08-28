@include('layout.header');

    <!-- main app container -->
    <div class="readersack">
      <div class="container">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <h3>laravel 8 Custom Login and Registration Dashboard after login   - Readerstacks</h3>
               <!-- Show any success message -->
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
          <!-- Show any success message -->

            <!-- Check user is logged in -->
            @if(\Auth::check())
              <div class='dash'>You are logged in as  : {{\Auth::user()->name}} ,  <a href="{{url('logout')}}"> Logout</a></div> 
            @else
            <div class='dash '>
              <div class='error'> You are not logged in  </div>
              <div>  <a href="{{url('login')}}">Login</a> | <a href="{{url('register')}}">Register</a> </div>
            </div>
             
            @endif
           <!-- Check user is logged in --> 
          </div>
        </div>
      </div>
    </div>
    <!-- credits -->
    <div class="text-center">
      <p>
        <a href="#" target="_top">laravel 8 Custom login and registration  </a>
      </p>
      <p>
        <a href="https://readerstacks.com" target="_top">readerstacks.com</a>
      </p>
    </div>
  </div>
    
</body>
</html>