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
                                <td width="30%" style="padding-left:20px">
                                    <img src="{{ asset('img/user.png') }}" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">{{ Str::limit($username, 13) }}..</p>
                                    <p class="profile-subtitle">{{ Str::limit($useremail, 22) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ route('logout') }}">
                                        <input type="button" value="Log out" class="logout-btn btn-primary-soft btn">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>                
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="{{route('patient_index',['id'=>$user->id])}}" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="{{route('patient_doctors',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{route('patient-appointments',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="{{route('patient-settings',['id'=>$user->id])}}" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td width="13%">
                        <a href="{{route('patient-settings',['id'=>$user->id])}}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Settings</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            {{$today}}
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                            <img src="{{ asset('/img/calendar.svg')}}" width="100%">
                        </button>
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
                                        <a href="?action=edit" class="non-style-link" name='edit' >
                                            <div class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex">
                                                <div class="btn-icon-back dashboard-icons-setting" style="background-image: url({{asset('/img/icons/doctors-hover.svg')}});"></div>
                                                <div>
                                                    <div class="h1-dashboard">Account Settings &nbsp;</div><br>
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
                                        <a  class="non-style-link" onclick="showPopup({{ json_encode($patient) }})">
                                            <div class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div class="btn-icon-back dashboard-icons-setting" style="background-image: url({{asset('/img/icons/view-iceblue.svg')}});"></div>
                                                <div>
                                                    <div class="h1-dashboard">View Account Details</div><br>
                                                    <div class="h3-dashboard" style="font-size: 15px;">
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
                                        <a  class="non-style-link" onclick="deleteAccount({{ json_encode($user) }})">
                                            <div class="dashboard-items setting-tabs" style="padding:20px;margin:auto;width:95%;display: flex;">
                                                <div class="btn-icon-back dashboard-icons-setting" style="background-image: url({{asset('/img/icons/patients-hover.svg')}});"></div>
                                                <div>
                                                    <div class="h1-dashboard" style="color: #ff5050;">Delete Account</div><br>
                                                    <div class="h3-dashboard" style="font-size: 15px;">
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
    @php
     $action = isset($_GET['action']) ? $_GET['action'] : null;
    if(isset($action)){
        echo "<div id='popup1' class='overlay' style='display:flex'>
        <div class='popup'>
            <center>
                <a class='close' onclick='hidePopup()'>&times;</a>
                <div id='popup-content' class='content'>
                    <div style='display: flex;justify-content: center;'>
                            <div class='abc'>
                                <table width='80%' class='sub-table scrolldown add-doc-form-container' border='0'> 
                                    <form  action=".route('patient-settings-update',['pid'=>$patient->pid]) . " method='POST' class='add-new-form'>";
                                        @endphp
                                        @csrf
                                        @method('put')
                                        @php echo "
                                    <tr>
                                        <td>
                                            <p style='padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;'>Edit User Account Details.</p>
                                        User ID ".$patient->pid ."(Auto Generated)<br/><br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                           
                                            <label for='Email' class='form-label'>Email: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                        <input type='hidden' name='oldemail' value='".$patient->pemail."' >
                                        <input type='email' name='pemail' class='input-text' placeholder='Email Address' value='".$patient->pemail."' required><br>
                                        </td>
                                    <tr>
                                        
                                        <td class='label-td' colspan='2'>
                                            <label for='pname' class='form-label'>Name: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='text' name='pname' class='input-text' placeholder='Doctor Name' value='".$patient->pname."' required><br>
                                        </td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='pnic' class='form-label'>NIC: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='text' name='pnic' class='input-text' placeholder='NIC Number' value='".$patient->pnic."' required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='ptel' class='form-label'>Telephone: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <input type='tel' name='ptel' class='input-text' placeholder='Telephone Number' value='" .$patient->ptel."' required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='paddress' class='form-label'>Address</label>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                        <input type='text' name='paddress' class='input-text' placeholder='Address' value='". $patient->paddress ."' required><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <label for='password' class='form-label'>Password: </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='label-td' colspan='2'>
                                            <div class='password-container'>
                                                <input type='password' name='ppassword' class='input-text' placeholder='Password' required>
                                                <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password'>
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
                                                <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password'>
                                            </div>
                                        </td>
                                    </tr>                                    
                                    
                                    <tr>
                                        <td colspan='2'>
                                            <input type='reset' value='Reset' onclick='hidePopup()' class='login-btn btn-primary-soft btn' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        
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
            <center>
                <a class="close" onclick="hidePopup()">&times;</a>
                <div id="popup-content" class="content">
                   
                </div>
            </center>
        </div>
    </div>

    <script>
        function showPopup(patient) {
            const patientDetails = {
                name: patient.pname,
                email: patient.pemail,
                phone: patient.ptel,
                address: patient.paddress,
                dob: patient.pdob,
                nic: patient.pnic
            };

            document.getElementById('popup-content').innerHTML = `
            <div class="abc">
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
                            ${patientDetails.name}<br><br>
                        </td>                    
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ${patientDetails.email}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="nic" class="form-label">NIC: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ${patientDetails.nic}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ${patientDetails.phone}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Address: </label>                        
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ${patientDetails.address}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Date of Birth: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            ${patientDetails.dob}<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button class="login-btn btn-primary-soft btn" onclick="hidePopup()">OK</button>             
                        </td>
                    </tr>
                </table><br/><br/>
                </div>`;
            document.getElementById('popup1').style.display = "flex";
        }

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
            <a href="{{route('patient-delete-account',['email'=>$user->email])}}" class="non-style-link">
                <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                <font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
            <a href="{{route('patient-settings',['id'=>$user->id])}}" class="non-style-link">
                <button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                    <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
            </div>`;
            document.getElementById('popup1').style.display = "flex";
        }
        document.querySelectorAll('toggle-password').forEach(item => {
            item.addEventListener('click', event => {
                const input = event.target.previousElementSibling;
                if (input.type == "password") {
                    input.type = "text";
                    event.target.src = "{{ asset('/img/icons/eye-off.svg') }}";
                } else {
                    input.type = "password";
                    event.target.src = "{{ asset('/img/icons/eye.svg') }}";
                }
            });
        });
    </script>
</body>
</html>