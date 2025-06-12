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

    <title>Doctors</title>
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
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="{{ route('patient_doctors', ['id' => $user->id]) }}" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">All Doctors</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="{{route('patient-schedule',['id'=>$user->id])}}" class="non-style-link-menu">
                            <div><p class="menu-text">Scheduled Sessions</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{route('patient-appointments',['id'=>$user])}}" class="non-style-link-menu">
                            <div><p class="menu-text">My Bookings</p></div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="{{route('patient-settings',['id'=>$user->id]) }}" class="non-style-link-menu">
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
                        <a href="{{ route('patient_doctors', ['id' => $user->id]) }}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('patient_doctors_search', ['id' => $user->id]) }}" method="post" class="header-search">
                            @csrf
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">
                            <datalist id="doctors" name='search'>
                                @foreach(App\Models\Doctor::select('docname', 'docemail')->get() as $doctor)
                                    <option value="{{ $doctor->docname }}">
                                    <option value="{{ $doctor->docemail }}">
                                @endforeach
                            </datalist>
                            <input type="submit" value="Search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
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
                            <img src="{{ asset('img/calendar.svg') }}" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Doctors ({{ $doctors->count() }})</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" border="0">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Doctor Name</th>
                                            <th class="table-headin">Email</th>
                                            <th class="table-headin">Specialties</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($doctors as $doctor)
                                            <tr>
                                                <td>&nbsp;{{ $doctor->docname }}</td>
                                                <td>{{ $doctor->docemail }}</td>
                                                <td>{{ $doctor->specialities->sname ?? 'N/A' }}</td>
                                                <td>
                                                    <div style="display:flex;justify-content: center;">
                                                        <button class="btn-primary-soft btn button-icon btn-view"
                                                        style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;" onclick="showPopup({{ $doctor}})">
                                                            <font class="tn-in-text">View</font>
                                                        </button>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <a class="non-style-link">
                                                            <button class="btn-primary-soft btn button-icon menu-icon-session-active" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;" onclick="schedule({{$doctor}})">
                                                                <font class="tn-in-text">Sessions</font>
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
                                                        <img src="{{ asset('img/notfound.svg') }}" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="font-size:20px;color:rgb(49, 49, 49)">We couldn't find anything related to your keywords!</p>

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
            <div id="popup-content">
            </div>
        </div>
    </div>

    <script>
        function showPopup(doctor) {
            const doctorDetails = {
                docname:doctor.docname,
                docemail: doctor.docemail,
                docnic: doctor.docnic,
                doctel: doctor.doctel,
                specialities: doctor.specialities.sname
            };

            document.getElementById('popup-content').innerHTML = `
                <h2>Doctor Details</h2><br/>
                <p><strong>Name:</strong> ${doctorDetails.docname}</p><br/>
                <p><strong>Email:</strong> ${doctorDetails.docemail}</p><br/>
                <p><strong>NIC:</strong> ${doctorDetails.docnic}</p><br/>
                <p><strong>Telephone:</strong> ${doctorDetails.doctel}</p><br/>
                <p><strong>Specialties:</strong> ${doctorDetails.specialities}</p><br/>
                <a href="{{ route('patient_doctors', ['id' => $user->id]) }}">
                    <input type="button" value="OK" class="login-btn btn-primary-soft btn">
                </a>
            `;
            document.getElementById('popup1').style.display = 'flex';
        }

        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }
        function schedule(doctor)
        {
            document.getElementById('popup-content').innerHTML = `
                        <div class="content">
                            You want to view All sessions by <br>${doctor.docname}
                        </div>
                        <form  method="post" action="{{route('patient-schedule_search',['id'=>$user->id])}}" style="display: flex">
                            @csrf
                            <input type="hidden" name="search" value="${doctor.docname}">
                            <div style="display: flex;justify-content:center;margin-left:45%;margin-top:6%;;margin-bottom:6%;">
                            <input type="submit"  value="Yes" class="btn-primary btn" >
                            </div>
                        </form>
            `;
            document.getElementById('popup1').style.display = 'flex';
        }
    </script>
</body>
</html>
