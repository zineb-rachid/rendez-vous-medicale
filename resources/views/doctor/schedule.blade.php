<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/animations.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/admin.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Schedule</title>
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
                                    <img src="/img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">{{ Str::limit($docname, 13) }}..</p>
                                    <p class="profile-subtitle">{{ Str::limit($docemail, 13) }}</p>
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
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="{{ route('doctors_index', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div><p class="menu-text">Dashboard</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment ">
                        <a href="{{route('doctors_appointment',['id'=>$user->id])}}"  class="non-style-link-menu ">
                            <div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="{{ route('doctors_schedule', ['id' => $user->id]) }}" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">My Sessions</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="{{ route('doctors_patient', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div><p class="menu-text">My Patients</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="{{ route('doctors_setting', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div><p class="menu-text">Settings</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{ route('doctors_schedule', ['id' => $user->id]) }}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px; padding-bottom:11px; margin-left:20px; width:125px;">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <p style="font-size: 23px; padding-left:12px; font-weight: 600;">My Sessions</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0; text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0; margin: 0;">
                            {{ $today }}
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex; justify-content: center; align-items: center;">
                            <img src="/img/calendar.svg" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px; width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)">My Sessions ({{ $scheduleCount }})</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px; width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <td width="10%"></td>
                                    <td width="5%" style="text-align: center;">
                                        Date:
                                    </td>
                                    <td width="30%">
                                        <form action="{{ route('doctors_schedule', ['id' => $user->id]) }}" method="post">
                                            @csrf
                                            <input type="date" name="search" id="date" class="input-text filter-container-items" style="margin: 0; width: 95%;">
                                    </td>
                                    <td width="12%">
                                        <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0; width:100%">
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
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Session Title</th>
                                            <th class="table-headin">Scheduled Date</th>
                                            <th class="table-headin">Scheduled Time</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($schedule as $sch)
                                        <tr>
                                            <td>&nbsp; {{ $sch->title }}</td>
                                            <td style="text-align:center;">{{ $sch->scheduledate }}</td>
                                            <td style="text-align:center;">{{ $sch->scheduletime }}</td>
                                            <td>
                                                <div style="display:flex; justify-content: center;">
                                                    <a href="?action=view&id={{ $sch->scheduleid }}" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;">
                                                            <font class="tn-in-text">View</font>
                                                        </button>
                                                    </a>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a onclick="cancel({{ $sch }})" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px; padding-top: 12px; padding-bottom: 12px; margin-top: 10px;">
                                                            <font class="tn-in-text">Cancel Session</font>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">
                                                <br><br><br><br>
                                                <center>
                                                    <img src="{{ asset('img/notfound.png') }}" width="25%">
                                                    <br>
                                                    <p class="heading-main12" style="margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)">
                                                        We couldn't find anything related to your keywords!
                                                    </p>

                                                </center>
                                                <br><br><br><br>
                                            </td>
                                        </tr>
                                        @endforelse
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
            <div id="popup-content"></div>
        </div>
    </div>
    <script>
        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }
        function cancel(schedule) {
            document.getElementById('popup-content').innerHTML = `
                <h2>Are you sure?</h2>
                <a class="close" href="{{ route('doctors_schedule', ['id' => $user->id]) }}">&times;</a>
                <div class="content">
                    You want to delete this record<br/>(${schedule.title}).
                </div>
                <div style="display: flex; justify-content: center;">
                    <a id='dropLink' class="non-style-link">
                        <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin:10px; padding:10px;">
                            <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                        </button>
                    </a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('doctors_schedule', ['id' => $user->id]) }}" class="non-style-link">
                        <button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin:10px; padding:10px;">
                            <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                        </button>
                    </a>
                </div>
            `;
            document.getElementById('popup1').style.display = "flex";
            document.getElementById('dropLink').href = "{{ route('doctors_schedule_delete', ['scheduleid' => ':id']) }}".replace(':id', schedule.scheduleid);
        }
    </script>
    @php
    if (isset($_GET['id']) && $_GET['action'] == 'view') {
        $schedule = $schedule->where('scheduleid', $_GET['id'])->first();
        if ($schedule) {
            echo "
            <div id='popup1' class='overlay' style='display:flex'>
                <div class='popup' >
                    <center>
                        <h2>View Details</h2>
                        <a class='close' href=". route('doctors_schedule', ['id' => $user->id]) .">&times;</a>
                        <div class='content'></div>
                        <div class='abc scroll' style='display: flex; justify-content: center;'>
                            <table width='80%' class='sub-table scrolldown add-doc-form-container' border='0'>
                                <tr>
                                    <td>
                                        <p style='padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;'>View Details.</p><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='name' class='form-label'>Session Title: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                         $schedule->title <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='Email' class='form-label'>Doctor of this session: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                         $docname <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='nic' class='form-label'>Scheduled Date: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                         $schedule->scheduledate <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='Tele' class='form-label'>Scheduled Time: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                         $schedule->scheduletime <br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='label-td' colspan='2'>
                                        <label for='spec' class='form-label'>
                                            <b>Patients that already registered for this session:</b> ". $schedule->appointment->count()." </label><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='4'>
                                        <center>
                                            <div class='abc scroll'>
                                                <table width='100%' class='sub-table scrolldown' border='0'>
                                                    <thead>
                                                        <tr>
                                                            <th class='table-heading'>Patient ID</th>
                                                            <th class='table-heading'>Patient Name</th>
                                                            <th class='table-heading'>Appointment Number</th>
                                                            <th class='table-heading'>Patient Telephone</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>";

                                                        $appointments = $schedule->appointment;
                                                        if ($appointments && $appointments->isNotEmpty()) {
                                                            foreach ($appointments as $appointment) {
                                                                $patient = $appointment->patient;
                                                                echo "
                                                                <tr style='text-align:center;'>
                                                                    <td>".substr($patient->pid, 0, 15)."</td>
                                                                    <td style='font-weight:600;padding:25px'>".substr($patient->pname, 0, 25)."</td>
                                                                    <td style='text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);'>".$appointment->appnum."</td>
                                                                    <td>".substr($patient->ptel, 0, 25)."</td>
                                                                </tr>";
                                                            }
                                                        } else {
                                                            echo "
                                                            <tr>
                                                                <td colspan='4'>
                                                                    <br><br><br><br>
                                                                    <center>
                                                                        <img src='".asset('img/notfound.png')."' width='25%'>
                                                                        <br>
                                                                        <p class='heading-main12' style='margin-left: 45px; font-size:20px; color:rgb(49, 49, 49)'>
                                                                            We couldn't find anything related to your keywords!
                                                                        </p>
                                                                        <a class='non-style-link' href='".route('doctors_appointment', ['id' => $user->id])."'>
                                                                            <button class='login-btn btn-primary-soft btn' style='display: flex; justify-content: center; align-items: center; margin-left:20px;'>
                                                                                &nbsp; Show all Appointments &nbsp;
                                                                            </button>
                                                                        </a>
                                                                    </center>
                                                                    <br><br><br><br>
                                                                </td>
                                                            </tr>";
                                                        }

                                                    echo "
                                                    </tbody>
                                                </table>
                                            </div>
                                        </center>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </center>
                </div>
            </div>";
        }
    }
    @endphp
       </tbody>
                                                        </table>
                                                    </div>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </center>
                        </div>
                    </div>
</body>
</html>
