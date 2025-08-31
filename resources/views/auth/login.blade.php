
<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    @vite(['resources/css/Login/style.css', 'resources/css/Login/script.js'])
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="style.css" />
    <title>Login</title>
  </head>
  <body>
    <div class="container">
       @if (session('auth_required'))
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg text-center">
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('auth_required') }}
                </div>
            </div>
        @endif
        <x-validation-errors class="mb-4" />
        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession
        
      <div class="forms">
        <div class="form login">
          <span class="title">Login</span>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif
            <div class="input-field">
              <input placeholder="Enter your email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
              <i class="uil uil-envelope icon"></i>
            </div>
            <div class="input-field">
              <input type="password" class="password" type="password" name="password" required autocomplete="current-password" />
              <i class="uil uil-lock icon"></i>
              <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="checkbox-text">
              <div class="checkbox-content">
                <input type="checkbox" id="logCheck" />
                <label for="logCheck" class="text">Remember me</label>
              </div>
              @if (Route::has('password.request'))
                    <a class="text" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="input-field button">
              <input type="submit" value="Login" />
            </div>
          </form>

          <div class="login-signup">
            <span class="text"
              >Not a member?
              <a href="#" class="text signup-link">Signup Now</a>
            </span>
          </div>
        </div>

        <!-- Registration Form -->
        <div class="form signup">
          <span class="title">Registration</span>

          <form action="#">
            <div class="input-field">
              <input type="text" placeholder="Enter your name" required />
              <i class="uil uil-user"></i>
            </div>
            <div class="input-field">
              <input type="text" placeholder="Enter your email" required />
              <i class="uil uil-envelope icon"></i>
            </div>
            <div class="input-field">
              <input type="password" class="password" placeholder="Create a password" required />
              <i class="uil uil-lock icon"></i>
            </div>
            <div class="input-field">
              <input type="password" class="password" placeholder="Confirm a password" required />
              <i class="uil uil-lock icon"></i>
              <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="checkbox-text">
              <div class="checkbox-content">
                <input type="checkbox" id="termCon" />
                <label for="termCon" class="text">I accepted all terms and conditions</label>
              </div>
            </div>

            <div class="input-field button">
              <input type="submit" value="Signup" />
            </div>
          </form>

          <div class="login-signup">
            <span class="text"
              >Already a member?
              <a href="#" class="text login-link">Login Now</a>
            </span>
          </div>
        </div>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>


