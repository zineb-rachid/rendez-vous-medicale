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
    <title>Patients</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
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
                                <td width="30%" style="padding-left:20px" >
                                    <img src="/img/user.png" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">{{ Str::limit($docname, 13) }}..</p>
                                    <p class="profile-subtitle">{{ Str::limit($docemail, 13) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{route('logout')}}" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="{{route('doctors_index',['id'=>$user->id])}}" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="{{route('doctors_appointment',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="{{route('doctors_schedule',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="{{route('doctors_patient',['id'=>$user->id])}}" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="{{route('doctors_setting',['id'=>$user->id])}}" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>

            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="{{route('doctors_patient',['id'=>$user->id])}}" >
                        <button class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button>
                    </a>
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
                            <img src="/img/calendar.svg" width="100%"/></button>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">
                            My Patients ({{$patientsCount}})</p>
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
                                    Patient:
                                    </td>
                                <td width="30%">
                                    <form action="{{route('doctors_patient_search',['id'=>$user->id])}}" method="post" class="header-search">
                                        @csrf
                                        <input type="search" name="query" id="search" class="input-text filter-container-items" style="margin: 0;width: 95%;" list="patient">&nbsp;&nbsp;
                                </td>
                                <td width="12%">
                                        <input type="submit" name="filter" value=" Search" class="btn-primary-soft btn button-icon btn-filter" style="padding: 15px; margin: 0;width:100%">
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
                        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                        <thead>
                            <tr>
                                <th class="table-headin">
                                Name
                                </th>
                                <th class="table-headin">
                                    NIC
                                </th>
                                <th class="table-headin">
                                Telephone
                                </th>
                                <th class="table-headin">
                                    Email
                                </th>
                                <th class="table-headin">
                                    Date of Birth
                                </th>
                                <th class="table-headin">
                                    Events
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                            <tr>
                                <td> &nbsp; {{$patient->pname}} </td>
                                <td>
                                    {{$patient->pnic}}
                                </td>
                                <td>
                                    {{$patient->ptel}}
                                </td>
                                <td>
                                    {{$patient->pemail}}
                                 </td>
                                <td>
                                    {{$patient->pdob}}
                                </td>
                                <td >
                                <div style="display:flex;justify-content: center;">

                                <a href="?action=view&id={{$patient->pid}}" class="non-style-link">
                                    <button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                        <font class="tn-in-text">View</font>
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
                                <img src="/img/notfound.png" width="25%">

                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">
                                    We  couldnt find anything related to your keywords !
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
    <?php
    if (isset($_GET['id']) && $_GET['action'] == 'view') {
        $patient = $patients->where('pid', $_GET['id'])->first();
        if ($patient) {
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup" style=" overflow-y: scroll; height: 600px;">
                    <center>
                        <a class="close" href="'.route('doctors_patient',['id'=>$user->id]).'">&times;</a>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Patient ID: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    P-'.$patient->pid.'<br><br>
                                </td>

                            </tr>

                            <tr>

                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Name: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$patient->pname.'<br><br>
                                </td>

                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Email: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$patient->pemail.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">NIC: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$patient->pnic.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Telephone: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$patient->ptel.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">Address: </label>

                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$patient->paddress.'<br><br>
                            </td>
                            </tr>
                            <tr>

                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Date of Birth: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$patient->pdob.'<br><br>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="'.route('doctors_patient',[ "id" => $user->id ]).'"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>


                                </td>

                            </tr>


                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';

        };
    }
?>
</div>

</body>
</html>
