<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>Appointments</title>
    <style>
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
            max-width: 500px;
        }
        .close {
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
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
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="{{route('patient_index',['id'=>$user])}}" class="non-style-link-menu">
                            <div><p class="menu-text">Home</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="{{ route('patient_doctors', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div><p class="menu-text">All Doctors</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="{{ url('schedule') }}" class="non-style-link-menu">
                            <div><p class="menu-text">Scheduled Sessions</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="{{route('patient-appointments',['id'=>$user])}}" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">My Bookings</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="{{route('patient-settings',['id'=>$user->id])}}" class="non-style-link-menu">
                            <div><p class="menu-text">Settings</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{route('patient-appointments',['id'=>$user->id])}}" >
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p style="font-size:23px;font-weight:600;padding-left: 12px;">My bookings history</p> 
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            {{ $today }}
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                            <img src="{{ asset('img/calendar.svg') }}" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">My Bookings ({{$appointments->count()}})</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                   <td width="10%">
                                   </td> 
                                    <td width="5%" style="text-align: center;">
                                    Date:
                                    </td>
                                    <td width="30%">
                                        <form action="{{route('patient-appointments_search',['id'=>$user->id])}}" method="post" class="header-search">
                                            @csrf                                          
                                            <input type="date" name="search" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                                    </td>                                
                                    <td width="12%">
                                            <input type="submit" name="filter" value=" Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0;width:100%">
                                        </form>
                                    </td>
                                
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0" style="border:none">                        
                                    <tbody> 
                                        <tr>
                                            <td style="width: 25%;">
                                                @forelse($appointments as $app)                                                
                                                <div class="dashboard-items search-items">
                                                    <div style="width:100%;">
                                                        <div class="h3-search">
                                                            Booking Date: {{$app->appdate}} <br>
                                                            Reference Number: OC-000-{{$app->appid}}
                                                        </div>
                                                        <div class="h1-search">
                                                            {{$app->schedule->title}} <br>
                                                        </div>
                                                        <div class="h3-search">
                                                            Appointment Number:<div class="h1-search">{{$app->appnum}}</div>
                                                        </div>
                                                        <div class="h3-search">
                                                           {{$app->schedule->doctor->docname}}
                                                        </div>
                                                        <div class="h4-search">
                                                            Scheduled Date: {{$app->schedule->scheduledate}} <br> Starts: {{$app->schedule->scheduletime}}
                                                        </div>
                                                        <br>
                                                        <button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%" onclick="showPopup({{ $app }})">
                                                            <font class="tn-in-text">Cancel Booking</font>
                                                        </button>
                                                    </div>        
                                                </div>
                                                @empty
                                                <tr>
                                                    <td colspan="7">
                                                        <br><br><br><br>
                                                        <center>
                                                        <img src="{{ asset('img/notfound.png') }}" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn't find anything related to your keywords!</p>
                                                        <a class="non-style-link" href="{{route('patient-appointments',['id'=>$user->id])}}">
                                                            <button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">
                                                                &nbsp; Show all Appointments &nbsp;
                                                            </button>
                                                        </a>
                                                        </center>
                                                        <br><br><br><br>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td> 
                </tr>
            </table>
        </div>
    </div>

    
    <div id="popup1" class="overlay">
        <div class="popup">
            <a class="close" onclick="hidePopup()">&times;</a>
            <div id="popup-content">
            </div>
        </div>
    </div>
    
    <script>
        function showPopup(app) {
            const appDetails = {
                sname: app.schedule.title,
                dname: app.schedule.doctor.docname
            };
    
            document.getElementById('popup-content').innerHTML = `
                <h2>Are you sure?</h2>
                <div class="content">
                    You want to Cancel this Appointment?<br><br>
                    Session Name: &nbsp;<b>${appDetails.sname}</b><br>
                    Doctor name&nbsp; : <b>${appDetails.dname}</b><br><br>
                </div>
                <div style="display: flex;justify-content: center;">
                    <a id="cancelLink" class="non-style-link" href="">
                        <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                            <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                        </button>
                    </a>&nbsp;&nbsp;&nbsp;
                    <a href="{{ route('patient-appointments',['id' => $user->id]) }}" class="non-style-link">
                        <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                            <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                        </button>
                    </a>
                </div>`;
    
            document.getElementById('popup1').style.display = "flex";
    
            // Set the href for the cancel link
            document.getElementById('cancelLink').href = "{{ route('patient-appointments-delete', ['id' => ':id']) }}".replace(':id', app.appid);
        }
    
        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }
    
        if (!app || app.length === 0) {
            document.getElementById('cancelLink').style.display = 'none';
        }
    </script>
    
    

    
    

</body>
</html>