<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>Sessions</title>
    <style>
        .popup, .sub-table {
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
        .sessions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
            width: 100%;
        }
        .dashboard-items {
            width: 100% !important;
            margin: 0 !important;
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
                                    <p class="profile-subtitle">{{ Str::limit($username, 13) }}</p>
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
                    <td class="menu-btn menu-icon-home">
                        <a href="{{ route('patient_index', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Home</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="{{ route('patient_doctors', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">All Doctors</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="{{ route('patient-schedule', ['id' => $user->id]) }}" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <p class="menu-text">Scheduled Sessions</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{ route('patient-appointments', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">My Bookings</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="{{ route('patient-settings', ['id' => $user->id]) }}" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Settings</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin:0; padding:0; margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{ route('patient-schedule', ['id' => $user->id]) }}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px; padding-bottom:11px; margin-left:20px; width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('patient-schedule_search', ['id' => $user->id]) }}" method="post" class="header-search">
                            @csrf
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email or Date (YYYY-MM-DD)" list="doctors" value="">&nbsp;&nbsp;
                            <input type="submit" value="Search" name="btn" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0; text-align: right;">Today's Date</p>
                        <p class="heading-sub12" style="padding: 0; margin: 0;">{{ $today }}</p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex; justify-content: center; align-items: center;">
                            <img src="{{ asset('img/calendar.svg') }}" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px; width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px; font-size:18px; color:rgb(49, 49, 49)">All Sessions ({{ $countS }})</p>
                        <p class="heading-main12" style="margin-left: 45px;font-size:22px;color:rgb(49, 49, 49)">
                            @php
                                if(isset($_POST['btn'])){
                                    $write = $_POST['search'];
                                    echo $write ;
                                }
                            @endphp
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc">
                                <div class="appointments-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; padding: 30px; width: 90%; margin: 0 auto;">
                                    @forelse ($schedule as $sc)
                                        <div class="session-card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                            <div style="width:100%">
                                                <div class="h1-search" style="font-size: 20px; margin-bottom: 15px;">
                                                    {{ $sc->title }}
                                                </div>
                                                <div class="h3-search" style="color: #3b3a3a; margin-bottom: 10px;">
                                                    {{ $sc->doctor->docname }}
                                                </div>
                                                <div class="h4-search" style="color: #3b3a3a;">
                                                    {{ $sc->scheduledate }}<br>
                                                    Starts: <b>@ {{ substr($sc->scheduletime, 0, 5) }}</b> (24h)
                                                </div>
                                                <br>
                                                <a onclick="book({{ json_encode($sc) }}, {{$sc->appointment->pluck('apptime')}})">
                                                    <button class="login-btn btn-primary-soft btn" style="width: 100%; padding: 12px;">
                                                        <font class="tn-in-text">Book Now</font>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div style="width: 100%; text-align: center; padding: 50px; grid-column: 1 / -1;">
                                            <img src="{{ asset('img/notfound.png') }}" width="25%">
                                            <br>
                                            <p class="heading-main12" style="margin-top: 20px; font-size:20px; color:rgb(49, 49, 49)">
                                                We couldn't find anything related to your keywords!
                                            </p>
                                            <a class="non-style-link" href="{{ route('patient-schedule', ['id' => $user->id]) }}">
                                                <button class="login-btn btn-primary-soft btn" style="margin-top: 20px;">
                                                    &nbsp; Show all Sessions &nbsp;
                                                </button>
                                            </a>
                                        </div>
                                    @endforelse
                                </div>
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
        function book(schedule, appointments) {
            let startTime = schedule.scheduletime.substring(0, 5);
            let startHour = parseInt(startTime.split(':')[0]);
            let duration = 9;
            let availableSlots = '';

            for (let i = 0; i < duration; i++) {
                let hour = startHour + i;
                let timeSlot = ('0' + hour).slice(-2) + ':00';
                if (appointments.includes(timeSlot + ':00')) {
                    availableSlots += `
                        <button class="time-slot-button unavailable-slot btn" disabled>
                            ${timeSlot}
                        </button>
                    `;
                } else {
                    availableSlots += `
                        <button onclick="bookSlot('${schedule.scheduleid}', '${timeSlot}', this)" class="time-slot-button btn btn-primary">
                            ${timeSlot}
                        </button>
                    `;
                }
            }

            document.getElementById('popup-content').innerHTML = `
                <h2>Available Slots</h2><br/>
                <div class="time-slots-container">
                    ${availableSlots}
                </div><br/><br/>
                <a id="myRoute" onClick="booked()">
                    <button class="book-button btn-primary-soft btn">
                        <font class="tn-in-text">Book</font>
                    </button>
                </a>
            `;

            document.getElementById('popup1').style.display = "flex";
        }

        function hidePopup() {
            document.getElementById('popup1').style.display = "none";
        }

        function bookSlot(scheduleId, timeSlot, element) {
            const buttons = document.querySelectorAll('.time-slot-button');
            buttons.forEach(button => button.classList.remove('selected-slot'));

            element.classList.add('selected-slot');

            const routeUrl = `/patient/{{ $user->id }}/schedules/${scheduleId}/${timeSlot}`;
            document.getElementById('myRoute').href = routeUrl;
        }

        function booked() {
            alert('Booked Successfully!');
            document.getElementById('popup1').style.display = "none";
        }
    </script>
</body>
</html>
