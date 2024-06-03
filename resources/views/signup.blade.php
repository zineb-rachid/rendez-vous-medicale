<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <title>Sign Up</title>
</head>
<body>
    <center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">Add Your Personal Details to Continue</p>
                </td>
            </tr>
            <tr>
                <form action="{{ route('register') }}" method="post">
                @csrf
                <td class="label-td" colspan="2">
                    <label for="name" class="form-label">Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="text" name="fname" class="input-text" placeholder="First Name" required>
                </td>
                @error('pname')
                    <span>{{ $message }}</span>
                    @enderror
                <td class="label-td">
                    <input type="text" name="lname" class="input-text" placeholder="Last Name" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="paddress" class="form-label">Address: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="paddress" class="input-text" placeholder="Address" required>
                    @error('paddress')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="nic" class="form-label">NIC: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="pnic" class="input-text" placeholder="NIC Number" required>
                    @error('pnic')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">Date of Birth: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="pdob" class="input-text" required>
                    @error('pdob')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="ptel" class="form-label">Telephone: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="ptel" class="input-text" placeholder="Telephone" required>
                    @error('ptel')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="pemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="pemail" class="input-text" required>
                    @error('pemail')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="ppassword" class="form-label">Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2" style="display: flex">
                    <input type="password" name="ppassword" class="input-text" onclick='togglePassword()' required>
                    <img src=' {{asset('/img/icons/eye.svg')}} ' class='toggle-password' onclick='togglePassword()'>
                </td>
            </tr>
            <tr>
               <td class="label-td" > @error('ppassword')
                    <span>{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2"></td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="{{ url('login') }}" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>
                </form>
            </tr>
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