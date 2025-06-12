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
    <title>Patients</title>
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
                                    <p class="profile-title">{{$user->name}}</p>
                                    <p class="profile-subtitle">{{$user->email}} </p>
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
                        <a href="{{ route('admin_index') }}" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></div></a>
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
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="{{ route('admin_patients') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Patients</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{ route('admin_patients') }}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin_patients_search') }}" method="get" class="header-search">
                            @csrf
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp;
                            <datalist id="patient">
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->pname }}">
                                    <option value="{{ $patient->pemail }}">
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
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            All Patients ({{ $patients->count() }})
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="93%" class="sub-table scrolldown" style="border-spacing:0;">
                                    <thead>
                                        <tr>
                                            <th class="table-headin">Name</th>
                                            <th class="table-headin">NIC</th>
                                            <th class="table-headin">Telephone</th>
                                            <th class="table-headin">Email</th>
                                            <th class="table-headin">Date of Birth</th>
                                            <th class="table-headin">Events</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($patients->isEmpty())
                                            <tr>
                                                <td colspan="6">
                                                    <br><br><br><br>
                                                    <center>
                                                        <img src="{{ asset('img/notfound.png') }}" width="25%">
                                                        <br>
                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                                            We couldn't find anything related to your keywords!
                                                        </p>
                                                        <a class="non-style-link" href="{{ route('admin_patients',['id' => $patient->pid]) }}">
                                                            <button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">Show all Patients</button>
                                                        </a>
                                                    </center>
                                                    <br><br><br><br>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($patients as $patient)
                                                <tr>
                                                    <td>{{ $patient->pname }}</td>
                                                    <td>{{ $patient->pnic }}</td>
                                                    <td>{{ $patient->ptel }}</td>
                                                    <td>{{ $patient->pemail }}</td>
                                                    <td>{{ $patient->pdob }}</td>
                                                    <td>
                                                            <button class="btn-primary-soft btn button-icon btn-view" style="padding-top: 12px;padding-bottom: 12px; " onclick="showPopup({{ json_encode($patient) }})">
                                                                <font class="tn-in-text">View</font>
                                                            </button>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
        function showPopup(patient) {
            const patientDetails = {
                pname: patient.pname,
                pnic: patient.pnic,
                ptel: patient.ptel,
                pemail: patient.pemail,
                pdob: patient.pdob
            };
            document.getElementById('popup1').style.display = 'flex';
            document.getElementById('popup-content').innerHTML = `
                <h2>Patient Details</h2>
                <p><strong>Name:</strong> ${patientDetails.pname}</p>
                <p><strong>NIC:</strong> ${patientDetails.pnic}</p>
                <p><strong>Telephone:</strong> ${patientDetails.ptel}</p>
                <p><strong>Email:</strong> ${patientDetails.pemail}</p>
                <p><strong>Date of Birth:</strong> ${patientDetails.pdob}</p>
                <a href="{{ route('admin_patients') }}"><input type="button" value="OK" class="login-btn btn-primary-soft btn"></a>
            `;

        }

        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }
    </script>
</body>
</html>
