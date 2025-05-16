<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Schedule</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
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
            z-index: 1000;
        }
        .popup {
            overflow: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            position: relative;
            margin-top: 10%;
            height:550px;
            z-index: 1001;

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
                        <a href="{{ route('admin_index') }}" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="{{ route('admin_doctors') }}" class="non-style-link-menu"><div><p class="menu-text">Doctors</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule menu-active menu-icon-schedule-active">
                        <a href="{{ route('admin_schedule') }}" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Schedule</p></div></a>
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
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="{{route('admin_schedule')}}" >
                        <button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                        <font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Shedule Manager</p>

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
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;">
                            <img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>

                <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">
                            Schedule a Session</div>
                        <a href="?action=add_schedule" class="non-style-link" name="add_schedule">
                            <button  class="login-btn btn-primary btn button-icon"
                            style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr>
                @if(request()->has('action') && request()->get('action') == 'add_schedule')
<div class="overlay" id="addSchedulePopup" style="display:flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); justify-content: center; align-items: center; z-index: 1000;">
    <div class="popup" style="background: white; padding: 25px; border-radius: 8px; width: 90%; max-width: 600px; position: relative;">
        <a href="{{route('admin_schedule')}}" class="non-style-link" style="position: absolute; top: 10px; right: 10px; font-size: 30px; cursor: pointer; color: black;">&times;</a>

        <form action="{{route('admin_schedule_add')}}" method="POST" class="add-new-form" >
            @csrf
            <div style="margin-bottom: 20px;">
                <h1 style="font-size: 22px; margin-bottom: 20px; color: #333;">Add New Session.</h1>

                <div style="margin-bottom: 20px;">
                    <h2 style="font-size: 16px; margin-bottom: 8px; color: #555;">Session Title:</h2>
                    <input type="text" name="title" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" placeholder="Name of this Session" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <h2 style="font-size: 16px; margin-bottom: 8px; color: #555;">Select Doctor:</h2>
                    <select name="docid" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="0" disabled selected hidden>Choose Doctor Name from the list</option>
                        @foreach ($doctors as $doc)
                            <option value="{{$doc->docid}}">{{$doc->docname}}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <h2 style="font-size: 16px; margin-bottom: 8px; color: #555;">Number of Patients/Appointment Numbers:</h2>
                    <input type="number" name="nop" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" min="0" placeholder="Maximum appointments" required>
                    <p style="font-size: 12px; color: #777; margin-top: 5px;">The final appointment number for this session depends on this number.</p>
                </div>

                <div style="margin-bottom: 20px;">
                    <h2 style="font-size: 16px; margin-bottom: 8px; color: #555;">Session Date:</h2>
                    <input type="date" name="scheduledate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" min="{{ date('Y-m-d') }}" required>
                </div>

                <div style="margin-bottom: 25px;">
                    <h2 style="font-size: 16px; margin-bottom: 8px; color: #555;">Schedule Time:</h2>
                    <input type="time" name="scheduletime" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <input type="reset" value="Reset" style="background: #f0f0f0; color: #333; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                    <input type="submit" value="Place this Session" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;" name="schedulesubmit">
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('addSchedulePopup').addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>

                @elseif(request()->has('action') && request()->get('action') == 'remove_schedule')
                @php
                $scheduleId = request()->get('id');
                $name = request()->get('name');
                @endphp

                <div id="removeSchedulePopup" class="overlay" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); justify-content: center; align-items: center; z-index: 1000;">
                    <div class="popup" style="background: white; padding: 20px; border-radius: 8px; width: 80%; max-width: 500px; position: relative; z-index: 1001;height:200px;margin-top: 10%;w">
                        <center>
                            <h2>Are you sure?</h2>
                            <a class="close" href="{{route('admin_schedule')}}" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer">&times;</a>
                            <div class="content" style="margin: 20px 0;">
                                You want to delete: {{$name}}
                            </div>
                            <div style="display: flex; justify-content: center;">
                                <a href="{{ route('admin_schedule_delete', ['id' => $scheduleId]) }}" class="non-style-link">
                                    <button class="btn-primary btn" style="margin: 0 10px; padding: 10px 20px;">Yes</button>
                                </a>
                                <a href="{{route('admin_schedule')}}" class="non-style-link">
                                    <button class="btn-primary btn" style="margin: 0 10px; padding: 10px 20px;">No</button>
                                </a>
                            </div>
                        </center>
                    </div>
                </div>
                @endif
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >

                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Sessions </p>
                    </td>

                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%">

                           </td>
                        <td width="5%" style="text-align: center;">
                        Date:
                        </td>
                        <td width="30%">
                        <form action="{{route('admin_schedule_search')}}" method="post">
                        @csrf
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                        </td>
                        <td width="5%" style="text-align: center;">
                        Doctor:
                        </td>
                        <td width="30%">
                        <select name="docid" id="" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                            <option value="0" >Choose Doctor Name from the list</option><br/>
                            @foreach ($doctors as $doc)
                                <option value="{{$doc->docid}}">{{$doc->docname}}</option>
                            @endforeach


                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
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
                                <th class="table-headin">
                                Session Title
                                </th>

                                <th class="table-headin">
                                    Doctor
                                </th>
                                <th class="table-headin">
                                    Sheduled Date & Time
                                </th>
                                <th class="table-headin">
                                Max num that can be booked
                                </th>
                                <th class="table-headin">
                                    Events
                                </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedule as $sch)
                            <tr>
                                <td>
                                    {{$sch->title}}
                                </td>
                                <td>
                                    {{$sch->doctor->docname}}
                                </td>
                                <td>
                                    {{$sch->scheduledate }}  {{$sch->scheduletime}}
                                </td>
                                <td style="text-align: center">
                                    {{$sch->nop}}
                                </td>
                                <td>
                                    <div style="display:flex;justify-content: center;">

                                        <a  class="non-style-link">
                                            <button onclick="showPopup({{ $sch}})" class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                            <font class="tn-in-text">View</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=remove_schedule&id={{$sch->scheduleid}}&name={{$sch->title}}" class="non-style-link">
                                        <button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">Remove</font></button></a>
                                        </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                <br><br><br><br>
                                <center>
                                <img src="../img/notfound.png" width="25%">

                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                    We  couldnt find anything related to your keywords !</p>
                                <a class="non-style-link" href="{{route('admin_schedule')}}">
                                    <button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">
                                        &nbsp; Show all Schedules &nbsp;</font></button>
                                </a>
                                </center>
                                <br><br><br><br>
                                </td>
                                </tr>
                            @endforelse
                        </tbody>
    </div>





    <div id="popup1" class="overlay">
        <div class="popup">
            <center>
                <a class="close" onclick="hidePopup()" >&times;</a>
                <div id="popup-content" class="content">

                </div>
            </center>
        </div>
    </div>
    <script>
         document.getElementById('popup1').style.display = 'none';
        function showPopup(schedule) {

            const title = schedule.title;
            const doctor = schedule.doctor?.docname ?? 'Unknown';
            const scheduledate = schedule.scheduledate;
            const scheduletime = schedule.scheduletime;
            const maxPatients = schedule.nop ?? 0;
            const appointments = schedule.appointment ?? [];

            const registeredCount = appointments.length;
            let patientRows = '';
            const popup_content=document.getElementById('popup-content');
    appointments.forEach((appointment) => {
        if (appointment.patient) {
            patientRows += `
                <tr style="text-align:center;">
                    <td>${appointment.patient.pid}</td>
                    <td style="font-weight:600;padding:25px">${appointment.patient.pname}</td>
                    <td  style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">${appointment.appnum}</td>
                    <td>${appointment.patient.ptel}</td>
                </tr>
            `;
        }
        else{
            patientRows+=`<tr>
                            <td colspan="7">
                            <br><br><br><br>
                            <center>
                            <img src="../img/notfound.png" width="25  /> <br>
                            <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                We  couldnt find anything related to your keywords !</p>
                            <a class="non-style-link" href="appointment.php">
                                <button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                            </a>
                            </center>
                            <br><br><br><br>
                            </td>
                            </tr>`
        }
    });
    popup_content.innerHTML = `


                        <div class="abc scroll" style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">

                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>

                            <tr>

                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Session Title: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ${title}<br><br>
                                </td>

                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Doctor of this session: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ${doctor}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">Scheduled Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ${scheduledate}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Scheduled Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                ${scheduletime}<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"><b>Patients that Already registerd for this session:</b>
                                         (${registeredCount}/${maxPatients})</label>
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                            <td colspan="4">
                                <center>
                                 <div class="abc scroll">
                                 <table width="100%" class="sub-table scrolldown" border="0">
                                 <thead>
                                 <tr>
                                        <th class="table-headin">
                                             Patient ID
                                         </th>
                                         <th class="table-headin">
                                             Patient name
                                         </th>
                                         <th class="table-headin">

                                             Appointment number

                                         </th>


                                         <th class="table-headin">
                                             Patient Telephone
                                         </th>

                                 </thead>
                                 <tbody>
                                    ${patientRows}
                                   </tbody>

                                 </table>
                                 </div>
                                 </center>
                            </td>
                         </tr>

                        </table>
                   `;
            document.getElementById('popup1').style.display = "flex";
        }
        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }
        window.onclick = function(event) {
            const addPopup = document.getElementById('addSchedulePopup');
            const removePopup = document.getElementById('removeSchedulePopup');

            if (event.target == addPopup) {
                addPopup.style.display = "none";
            }
            if (event.target == removePopup) {
                removePopup.style.display = "none";
            }
        }
    </script>
</body>
</html>
