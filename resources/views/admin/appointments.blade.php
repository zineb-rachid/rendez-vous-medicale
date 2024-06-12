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
    </style>
</head>
<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <!-- Menu code omitted for brevity -->
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style="border-spacing: 0; margin: 0; padding: 0; margin-top: 25px;">
                <!-- Header code omitted for brevity -->
                <tr>
                    <td colspan="4" style="padding-top: 10px; width: 100%;">
                        <p class="heading-main12" style="margin-left: 45px; font-size: 18px; color: rgb(49, 49, 49)">
                            All Appointments ({{ $apps->count() }})
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
                                        <form action="{{ route('appointments.filter') }}" method="GET">
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
                @if($filttredappointment->isEmpty())
                    <tr>
                        <td colspan="7">
                            <br><br><br><br>
                            <center>
                                <img src="{{ asset('img/notfound.png') }}" width="25%">
                                <br>
                                <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49)">
                                    We couldn't find anything related to your keywords!
                                </p>
                                <a class="non-style-link" href="{{ route('admin_appointments') }}">
                                    <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">
                                        &nbsp; Show all Appointments &nbsp;
                                    </button>
                                </a>
                            </center>
                            <br><br><br><br>
                        </td>
                    </tr>
                @else
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
                                        <th class="table-headin" style="font-size:10px">Session Date & Time</th>
                                        <th class="table-headin">Appointment Date</th>
                                        <th class="table-headin">Events</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($filttredappointment as $Fapp)
                                        <tr>
                                            <td>{{ $Fapp->patient->pname }}</td>
                                            <td style="text-align: center; font-size: 23px; font-weight: 500; color: var(--btnnicetext);">{{ $Fapp->appnum }}</td>
                                            <td>{{ $Fapp->schedule->doctor->docname }}</td>
                                            <td>{{ Str::limit($Fapp->schedule->title, 15) }}</td>
                                            <td style="text-align: center; font-size: 12px;">{{ $Fapp->schedule->scheduledate }} <br> {{ $Fapp->schedule->scheduletime }}</td>
                                            <td style="text-align: center;">{{ $Fapp->appdate }}</td>
                                            <td>
                                                <div style="display: flex; justify-content: center;">
                                                    &nbsp;&nbsp;&nbsp;
                                                    <a href="{{ route('appointments.delete', ['id' => $Fapp->appid]) }}" class="non-style-link">
                                                        <button class="btn-primary-soft btn button-icon btn-delete">
                                                            <font class="tn-in-text">Cancel</font>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </center>
                </td>
                @endif
            </table>
        </div>
    </div>
</body>
</html>
