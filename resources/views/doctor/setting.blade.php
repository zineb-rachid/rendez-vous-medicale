<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <title>Settings</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-X 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            position: relative;
            margin-top: 15%;
        }
        .close {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
        }
        .password-container {
            position: relative;
            width: 100%;
        }
        .password-container input[type="password"],
        .password-container input[type="text"] {
            width: calc(100% - 40px);
            padding-right: 40px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
</style>
</head>
<body>

    <div class="container">
        <div class="menu">
        <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="{{asset('/img/user.png')}}" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">  {{ Str::limit($docname,13)}}..</p>
                                    <p class="profile-subtitle">  {{ Str::limit($useremail,13)}} </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{route('logout')}}" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord " >
                        <a href="{{route('doctors_index',['id'=>$user->id])}}"  class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment ">
                        <a href="{{route('doctors_appointment',['id'=>$user->id])}}"  class="non-style-link-menu "><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="{{route('doctors_schedule',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="{{route('doctors_patient',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="{{route('doctors_setting',['id'=>$user->id])}}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="{{route('doctors_setting',['id'=>$user->id])}}" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Settings</p>

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">  {{$today}}    </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="{{asset('/img/calendar.svg')}}" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container" style="border: none;" border="0">
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 20px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">
                                        <a href="?action=edit" class="non-style-link">
                                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                                            <div class="btn-icon-back dashboard-icons-setting" style="background-image: url({{asset('/img/icons/doctors-hover.svg')}});"></div>
                                            <div>
                                                    <div class="h1-dashboard">
                                                        Account Settings  &nbsp;

                                                    </div><br>
                                                    <div class="h3-dashboard" style="font-size: 15px;">
                                                        Edit your Account Details & Change Password
                                                    </div>
                                            </div>
                                        </div>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 5px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="width: 25%;">
                                        <a onclick="view({{$doctor}})" class="non-style-link">
                                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                            <div class="btn-icon-back dashboard-icons-setting " style="background-image: url({{asset('/img/icons/view-iceblue.svg')}});"></div>
                                            <div>
                                                    <div class="h1-dashboard" >
                                                        View Account Details

                                                    </div><br>
                                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                                        View Personal information About Your Account
                                                    </div>
                                            </div>

                                        </div>
                                        </a>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 5px">&nbsp;</p>
                                    </td>
                                </tr>
                                <tr>
                                <td style="width: 25%;">
                                        <a class="non-style-link" onclick="deleteAccount({{$user}})">
                                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                            <div class="btn-icon-back dashboard-icons-setting" style="background-image: url({{asset('/img/icons/patients-hover.svg')}});"></div>
                                            <div>
                                                    <div class="h1-dashboard" style="color: #ff5050;">
                                                        Delete Account

                                                    </div><br>
                                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                                        Will Permanently Remove your Account
                                                    </div>
                                            </div>
                                        </div>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@php
     $action = isset($_GET['action']) ? $_GET['action'] : null;
    if(isset($action)){
        echo "<div id='popup1' class='overlay' style='display:flex'>
        <div class='popup'>
            <center>
                <a href=".route('doctors_setting',['id'=>$user->id])." class='close'>&times;</a>
                <div id='popup-content' class='content'>
                    <div style='display: flex;justify-content: center;'>
                            <div class='abc'>
                                <table width='80%' class='sub-table scrolldown add-doc-form-container' border='0'>
                                    <form  action=".route('doctors_setting_update',['docid'=>$doctor->docid]) . " method='POST' class='add-new-form'>";
                                        @endphp
                                        @csrf
                                        @method('put')
                                        @php echo "
                                    <tr>
                                        <td>
                                            <p style='padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;'>Edit Doctor Details.</p>
                                        User ID ".$doctor->docid ."(Auto Generated)<br/><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>

                                            <label for='Email' class='form-label'>Email: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                        <input type='hidden' name='oldemail' value='".$doctor->docemail."' >
                                        <input type='email' name='docemail' class='input-text' placeholder='Email Address' value='".$doctor->docemail."' required><br>
                                        </td>
                                    <tr>

                                        <td class='label-td' colspan='2'>
                                            <label for='pname' class='form-label'>Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='text' name='docname' class='input-text' placeholder='Doctor Name' value='".$doctor->docname."' required><br>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='pnic' class='form-label'>NIC: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='text' name='docnic' class='input-text' placeholder='NIC Number' value='".$doctor->docnic."' required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='ptel' class='form-label'>Telephone: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='tel' name='doctel' class='input-text' placeholder='Telephone Number' value='" .$doctor->doctel."' required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='docassword' class='form-label'>Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <div class='password-container'>
                                                <input type='password' name='docpassword' class='input-text' placeholder='Password' required>
                                                <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password' onclick='togglePassword()'>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='cpassword' class='form-label'>Confirm Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <div class='password-container'>
                                                <input type='password' name='cpassword' class='input-text' placeholder='Confirm Password' required>
                                                <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password' onclick='togglePassword()'>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            "  @endphp
                                            @if ($errors)
                                            <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            </label>
                                            @endif
                                            @php echo "
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='2'>
                                            <input type='reset' value='Reset'  class='login-btn btn-primary-soft btn' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type='submit' value='Save'  class='login-btn btn-primary btn'>
                                        </td>

                                    </tr>

                                    </form>
                                    </tr>
                                </table>
                            </div>
                        </div><br/><br/>
                </div>
            </center>
        </div>
    </div>" ;
    }
@endphp

<div id="popup1" class="overlay">
    <div class="popup">
        <a class="close" onclick="hidePopup()">&times;</a>
        <div id="popup-content">
        </div>
    </div>
</div>
</body>
</html>
<script>
    function view (doctor){
        const detail={
            docname:doctor.docname,
            docemail:doctor.docemail,
            docnic:doctor.docnic,
            doctel:doctor.doctel,
            spec:doctor.specialities.sname
        };
        document.getElementById('popup-content').innerHTML=`
        <div class="content">
            eDoc Web App<br>
        </div>
            <div style="display: flex;justify-content: center;">
            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                <tr>
                    <td>
                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">Name: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        ${detail.docname} <br><br>
                    </td>

                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="Email" class="form-label">Email: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                    ${detail.docemail}<br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="nic" class="form-label">NIC: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                    ${detail.docnic}<br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="Tele" class="form-label">Telephone: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                    ${detail.doctel}<br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="spec" class="form-label">Specialties: </label>

                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        ${detail.spec} <br><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a href="{{route('doctors_setting',['id'=>$user->id])}}"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
                    </td>
                </tr>
            </table>
        </div>`;
        document.getElementById('popup1').style.display = "flex";
    };
    function hidePopup() {
            document.getElementById('popup1').style.display = "none";
        }
    function deleteAccount(user)
        {
            document.getElementById('popup-content').innerHTML=`
            <h2>Are you sure?</h2>
            <div class="content">
                You want to delete Your Account<br>(${user.name}).
            </div>
            <div style="display: flex;justify-content: center;">
            <a href="{{route('doctors_delete-account',['email'=>$user->email])}}" class="non-style-link">
                <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                <font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
            <a href="{{route('doctors_setting',['id'=>$user->id])}}" class="non-style-link">
                <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                    <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
            </div>`;

            document.getElementById('popup1').style.display = "flex";
        }
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
