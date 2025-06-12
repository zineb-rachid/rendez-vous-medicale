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
    <title>Appointments</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <div class="container">
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
                        <td class="menu-btn menu-icon-dashbord">
                            <a href="{{ route('admin_index') }}" class="non-style-link-menu"><div>
                                <p class="menu-text">Dashboard</p></div></a>
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
                        <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                            <a href="{{ route('admin_appointment') }}" class="non-style-link-menu non-style-link-menu-active">
                                <div><p class="menu-text">Appointment</p></div></a>
                        </td>
                    </tr>
                    <tr class="menu-row">
                        <td class="menu-btn menu-icon-patient">
                            <a href="{{ route('admin_patients') }}" class="non-style-link-menu"><div><p class="menu-text">Patients</p></div></a>
                        </td>
                    </tr>
                </table>
            </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">

                <tr>
                    <td width="13%" >
                        <a href="{{route('admin_appointment')}}" >
                            <button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font></button></a>
                        </td>
                    <td colspan="4" style="padding-top: 10px; width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49)">
                            All Appointments ({{ $appointments->count() }})
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 0px; width: 100%;">
                        <center>
                            <table class="filter-container" border="0">
                                <tr>
                                    <td width="10%"></td>
                                    <td width="5%" style="text-align: center;">
                                        Date:
                                    </td>
                                    <td width="30%">
                                        <form action="{{ route('admin_appointment_search') }}" method="post">
                                            @csrf
                                            <input type="date" name="search" id="date" class="input-text filter-container-items" style="margin: 0; width: 95%;">@error('search') <div class="error" style="color:red">{{ $message }}</div>@enderror
                                            <td width="5%" style="text-align: center;">
                                                Doctor:
                                            </td>
                                            <td width="30%">
                                                <select name="docname" id="" class="box filter-container-items" style="width: 90%; height: 37px; margin: 0;">
                                                    <option value="" disabled selected hidden>Choose Doctor Name from the list</option>
                                                    @foreach($doctors as $doctor)
                                                        <option value="{{ $doctor->docname }}">{{ $doctor->docname }}</option>
                                                    @endforeach
                                                </select>
                                                @error('docname') <div class="error" style="color:red">{{ $message }}</div>@enderror
                                            </td>
                                            <td width="12%">
                                                <input type="submit" name="filter" value="Filter" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0; width: 100%">
                                            </td>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>

                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">Patient name</th>
                                        <th class="table-headin">Appointment number</th>
                                        <th class="table-headin">Doctor</th>
                                        <th class="table-headin">Session Title</th>
                                        <th class="table-headin" >Session Date & Time</th>
                                        <th class="table-headin">Appointment Date</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $appointment)
                                    <tr>
                                        <td style="margin-top:10px;font-size:15px">{{ $appointment->patient->pname }}</td>
                                        <td style="text-align: center; font-size: 20px; font-weight: 500; color: var(--btnnicetext);margin-top:10px;">{{ $appointment->appnum }}</td>
                                        <td style="margin-top:10px">{{ $appointment->schedule->doctor->docname }}</td>
                                        <td style="margin-top:10px">{{ Str::limit($appointment->schedule->title, 15) }}</td>
                                        <td style="text-align: center; font-size: 16px;margin-top:10px">{{ $appointment->schedule->scheduledate }} <br> {{ $appointment->schedule->scheduletime }}</td>
                                        <td style="text-align: center;margin-top:10px">{{ $appointment->appdate }}</td>
                                        <td>
                                            <div style="display: flex; justify-content: center;">
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="?action=remove_appointment&id={{$appointment->appid}}&pname={{$appointment->patient->pname }}&num={{$appointment->appnum }}" class="non-style-link">
                                                    <button class="btn-primary-soft btn button-icon btn-delete">
                                                        <font class="tn-in-text">Cancel</font>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <br><br><br><br>
                                            <center>
                                                <img src="{{ asset('img/notfound.png') }}" width="25%">
                                                <br>
                                                <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49)">
                                                    We couldn't find anything related to your keywords!
                                                </p>
                                                <a class="non-style-link" href="{{ route('admin_appointment') }}">
                                                    <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">
                                                        &nbsp; Show all Appointments &nbsp;
                                                    </button>
                                                </a>
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
            </table>
        </div>
    </div>
    @if (request()->has('action') && request()->get('action') == 'remove_appointment')
        @php
            $id=$_GET['id'];
            $patient=$_GET['pname'];
            $number=$_GET['num'];
        @endphp
        <div id="popup1" class="overlay">
            <div class="popup">
            <center>
                <h2>Are you sure?</h2>
                <a class="close" href="{{route('admin_appointment')}}">&times;</a>
                <div class="content">
                    You want to delete this record<br><br>
                    Patient Name: &nbsp;<b> {{$patient}} </b><br>
                    Appointment number &nbsp; : <b> {{$number}} </b><br><br>

                </div>
                <div style="display: flex;justify-content: center;">
                <a href="{{route('appointments.delete',['id'=>$id])}}" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                    <font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                <a href="{{route('admin_appointment')}}" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">
                    &nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                </div>
            </center>
    </div>
    </div>
    @endif
</body>
</html>
