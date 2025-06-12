<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
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
                                <td style="padding:0;margin:0;">
                                    <p class="profile-title">{{$user->name}}</p>
                                    <p class="profile-subtitle">{{$user->email}} </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ route('logout') }}"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
                        <a href="{{ route('admin_index') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="{{ route('admin_doctors') }}" class="non-style-link-menu"><div><p class="menu-text">Doctors</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule">
                        <a href="{{ route('admin_schedule') }}" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{ route('admin_appointment') }}" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="{{ route('admin_patients') }}" class="non-style-link-menu"><div><p class="menu-text">Patients</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="2" class="nav-bar">
                        <form action="{{ route('admin_doctors_search') }}" method="post" class="header-search">
                            @csrf
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
                            <datalist id="doctors">
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->docname }}">
                                    <option value="{{ $doctor->docemail }}">
                                @endforeach
                            </datalist>
                            <input type="Submit" value="Search" class="login-btn btn-primary-soft btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
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
                            <img src="{{ asset('img/calendar.svg') }}" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container" style="border: none;" border="0">
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                            <div>
                                                <div class="h1-dashboard">{{ $doctorsCount->count() }}</div><br>
                                                <div class="h3-dashboard">Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                            </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/doctors-hover.svg') }}');"></div>
                                        </div>
                                    </td>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                            <div>
                                                <div class="h1-dashboard">{{ $patients->count() }}</div><br>
                                                <div class="h3-dashboard">Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                            </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/patients-hover.svg') }}');"></div>
                                        </div>
                                    </td>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                            <div>
                                                <div class="h1-dashboard">{{ $appointments->count() }}</div><br>
                                                <div class="h3-dashboard">New Bookings</div>
                                            </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/book-hover.svg') }}');"></div>
                                        </div>
                                    </td>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex;">
                                            <div>
                                                <div class="h1-dashboard">{{ $schedules->count() }}</div><br>
                                                <div class="h3-dashboard">Today Sessions</div>
                                            </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('{{ asset('img/icons/session-iceblue.svg') }}');"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" style="border-spacing: 15px;">
                            <tr>
                                <!-- Upcoming Appointments -->
                                <td width="50%" style="vertical-align: top;">
                                    <table width="100%" border="0" class="dashbord-tables">
                                        <tr>
                                            <td colspan="2">
                                                <p style="padding: 10px 0 0 5px;font-size: 18px;font-weight: 600;">Upcoming Appointments until Next {{ $nextWeek }}</p>
                                                <p style="padding: 0 0 0 5px;font-size: 14px;font-weight: 600;color: rgba(0, 0, 0, 0.452);">Here's Quick access to Upcoming Appointments until 7 days</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="abc scroll" style="height: 200px;">
                                                    <table width="100%" class="sub-table scrolldown" border="0">
                                                        <thead>
                                                            <tr>
                                                                <th class="table-headin">Appoint. Number</th>
                                                                <th class="table-headin">Session Title</th>
                                                                <th class="table-headin">Doctor</th>
                                                                <th class="table-headin">Scheduled Date & Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($upcomingAppointments->isEmpty())
                                                                <tr>
                                                                    <td colspan="4">
                                                                        <center>
                                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                                            <p class="heading-main12" style="margin-top: 20px;font-size: 20px;color: #ff5050;">Nothing to show here!</p>
                                                                            <a class="non-style-link" href="{{ route('admin_appointment') }}">
                                                                                <button class="login-btn btn-primary-soft btn">Show all Appointments</button>
                                                                            </a>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @foreach($upcomingAppointments as $appointment)
                                                                    <tr>
                                                                        <td>{{ $appointment->appid }}</td>
                                                                        <td>{{ $appointment->title }}</td>
                                                                        <td>{{ $appointment->docname }}</td>
                                                                        <td>{{ $appointment->scheduledate }} @ {{ $appointment->scheduletime }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Show all button row -->
                                        <tr>
                                            <td colspan="2" style="padding-top: 15px;">
                                                <center>
                                                    <a href="{{ route('admin_appointment') }}" class="non-style-link">
                                                        <button class="login-btn btn-primary btn" style="padding: 10px 25px;">Show all Appointments</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Upcoming Sessions -->
                                <td width="50%" style="vertical-align: top;">
                                    <table width="100%" border="0" class="dashbord-tables">
                                        <tr>
                                            <td colspan="2">
                                                <p style="padding: 10px 0 0 5px;font-size: 18px;font-weight: 600;">Upcoming Sessions until Next {{ $nextWeek }}</p>
                                                <p style="padding: 0 0 0 5px;font-size: 14px;font-weight: 600;color: rgba(0, 0, 0, 0.452);">Here's Quick access to Upcoming Sessions until 7 days</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="abc scroll" style="height: 200px;">
                                                    <table width="100%" class="sub-table scrolldown" border="0">
                                                        <thead>
                                                            <tr>
                                                                <th class="table-headin">Session Title</th>
                                                                <th class="table-headin">Doctor</th>
                                                                <th class="table-headin">Scheduled Date & Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if($upcomingSessions->isEmpty())
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <center>
                                                                            <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                                            <p class="heading-main12" style="margin-top: 20px;font-size: 20px;color: #ff5050;">Nothing to show here!</p>
                                                                            <a class="non-style-link" href="{{ route('admin_schedule') }}">
                                                                                <button class="login-btn btn-primary-soft btn">Show all Sessions</button>
                                                                            </a>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @foreach($upcomingSessions as $session)
                                                                    <tr>
                                                                        <td>{{ $session->title }}</td>
                                                                        <td>{{ $session->docname }}</td>
                                                                        <td>{{ $session->scheduledate }} @ {{ $session->scheduletime }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Show all button row -->
                                        <tr>
                                            <td colspan="2" style="padding-top: 15px;">
                                                <center>
                                                    <a href="{{ route('admin_schedule') }}" class="non-style-link">
                                                        <button class="login-btn btn-primary btn" style="padding: 10px 25px;">Show all Sessions</button>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
