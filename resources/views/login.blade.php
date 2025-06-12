<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Login</title>
</head>
<body>
    <center>

    <div class="container ">

        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Welcome Back!</p>
                </td>
            </tr>

        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Login with your details to continue</p>
                </td>
            </tr>
            <tr>
                <form action="{{route('connecter')}}" method="POST" >
                    @csrf
                <td class="label-td">
                    <label for="useremail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td>
                @error('useremail')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </tr>
            <tr>
                <td class="label-td">
                    <label for="userpassword" class="form-label">Password: </label>
                </td>
                @error('userpassword')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </tr>

            <tr>
                <td class="label-td" style="display: flex">
                    <input type="Password" name="userpassword" class="input-text" placeholder="Password" onclick='togglePassword()' required>
                    <img src=' {{asset('/img/icons/eye.svg')}} ' class='toggle-password' onclick='togglePassword()'>
                </td>
            </tr>


            <tr>
                <td>
                    @if ($errors->any())
                    <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </label>
                    @endif
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                    <a href="signup" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td>
            </tr>
                    </form>
        </table>

    </div>

</center>
</body>
</html>
<script>
     function togglePassword(){
                const input = event.target.previousElementSibling;
                if (input.type == "password") {
                    input.type = "text";
                    event.target.src = "{{ asset('/img/icons/eye-off.svg') }}";
                } else {
                    input.type = "password";
                    event.target.src = "{{ asset('/img/icons/eye.svg') }}";
                }
            }
</script>
