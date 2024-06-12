<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

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
                                <td style="padding:0;margin:0;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@edoc.com</p>
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
                        <a href="{{ route('admin_appointments') }}" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></div></a>
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
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%">
                        <a href="{{ route('admin_doctors') }}">
                            <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                                <font class="tn-in-text">Back</font>
                            </button>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin_doctors_search' ) }}" method="GET" class="header-search">
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
                <tr >
                    <td colspan="2" style="padding-top:30px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">Add New Doctor</p>
                    </td>
                    <td colspan="2">
                        <a href="?action=add"  class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../img/icons/add.svg');">Add New</font></button>
                            </a></td>
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
                                                       <button  class="btn-primary-soft btn button-icon btn-edit" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><a href="?action=edit&docid={{ $doctor->docid }}" class="non-style-link">Edit</a></button>

                                                        &nbsp;&nbsp;&nbsp;
                                                        <button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;" onclick="showPopup({{ $doctor}})">
                                                            <font class="tn-in-text">View</font>
                                                        </button>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <a href="{{ url('doctor/sessions', $doctor->docid) }}" class="non-style-link">
                                                            <button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">
                                                                <a href="{{ route('admin_doctors_delete', ['doctor' => $doctor]) }}">Remove</a>

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
                                                        <a class="non-style-link" href="{{ route('patient_doctors', ['id' => $user->id]) }}">
                                                            <button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">
                                                                &nbsp; Show all Doctors &nbsp;
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
                <a href="{{ route('admin_doctors')}}"><input type="button" value="OK" class="login-btn btn-primary-soft btn"></a>
            `;
            document.getElementById('popup1').style.display = 'flex';
        }

        function hidePopup() {
            document.getElementById('popup1').style.display = 'none';
        }

    </script>







@php
$action = isset($_GET['action']) ? $_GET['action'] : null;

if(isset($action)){

   echo "<div id='popup1' class='overlay' style='display:flex'>
   <div class='popup'>
       <center>
           <a href=".route('admin_doctors')." class='close'>&times;</a>
           <div id='popup-content' class='content'>
               <div style='display: flex;justify-content: center;'>
                       <div class='abc'>
                           <table width='80%' class='sub-table scrolldown add-doc-form-container' border='0'>
                               <form  action=".route('doctors.store') . " method='POST' class='add-new-form'>";
                                   @endphp
                                   @csrf
                                   @method('post')
                                   @php echo "
                               <tr>
                                   <td>
                                       <p style='padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;'>Edit Doctor Details.</p>
                                   User ID ".$doctor->docid ."(Auto Generated)<br/><br/>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>

                                       <label for='Email' class='form-label'>Email: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                   <input type='hidden' name='oldemail' value='".$doctor->docemail."' >
                                   <input type='email' name='docemail' class='input-text' placeholder='Email Address' value='".$doctor->docemail."' required><br>
                                   </td>
                               <tr>

                                   <td class='label-td' colspan='2'>
                                       <label for='pname' class='form-label'>Name: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='text' name='docname' class='input-text' placeholder='Doctor Name' value='".$doctor->docname."' required><br>
                                   </td>

                               </tr>

                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='pnic' class='form-label'>NIC: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='text' name='docnic' class='input-text' placeholder='NIC Number' value='".$doctor->docnic."' required><br>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='ptel' class='form-label'>Telephone: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='tel' name='doctel' class='input-text' placeholder='Telephone Number' value='" .$doctor->doctel."' required><br>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='docassword' class='form-label'>Password: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <div class='password-container'>
                                           <input type='password' name='docpassword' class='input-text' placeholder='Password' required>
                                           <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password' onclick='togglePassword()'>
                                       </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='cpassword' class='form-label'>Confirm Password: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <div class='password-container'>
                                           <input type='password' name='cpassword' class='input-text' placeholder='Confirm Password' required>
                                           <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password' onclick='togglePassword()'>
                                       </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>
                                       "  @endphp
                                       @if ($errors)
                                       <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">
                                           @foreach ($errors->all() as $error)
                                               <p>{{ $error }}</p>
                                           @endforeach
                                       </label>
                                       @endif
                                       @php echo "
                                   </td>
                               </tr>
                               <tr>
                                   <td colspan='2'>
                                       <input type='reset' value='Reset'  class='login-btn btn-primary-soft btn' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type='submit' value='Save'  class='login-btn btn-primary btn'>
                                   </td>

                               </tr>

                               </form>
                               </tr>
                           </table>
                       </div>
                   </div><br/><br/>
           </div>
       </center>
   </div>
</div>" ;
}
@endphp

@php
$action = isset($_GET['action']) ? $_GET['action'] : null;

if(isset($action)){

   echo "<div id='popup1' class='overlay' style='display:flex'>
   <div class='popup'>
       <center>
           <a href=".route('admin_doctors')." class='close'>&times;</a>
           <div id='popup-content' class='content'>
               <div style='display: flex;justify-content: center;'>
                       <div class='abc'>
                           <table width='80%' class='sub-table scrolldown add-doc-form-container' border='0'>
                               <form  action=".route('doctors.store') . " method='POST' class='add-new-form'>";
                                   @endphp
                                   @csrf
                                   @method('post')
                                   @php echo "

                               <tr>
                                   <td class='label-td' colspan='2'>

                                       <label for='Email' class='form-label'>Email: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                   <input type='hidden' name='oldemail' >
                                   <input type='email' name='docemail' class='input-text' placeholder='Email Address'  required><br>
                                   </td>
                               <tr>

                                   <td class='label-td' colspan='2'>
                                       <label for='pname' class='form-label'>Name: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='text' name='docname' class='input-text' placeholder='Doctor'  required><br>
                                   </td>

                               </tr>

                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='pnic' class='form-label'>NIC: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='text' name='docnic' class='input-text' placeholder='NIC Number'  required><br>
                                   </td>
                               </tr>

                                 <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='ptel' class='form-label'>Telephone: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <input type='tel' name='doctel' class='input-text' placeholder='Telephone Number'  required><br>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <label for='docassword' class='form-label'>Password: </label>
                                   </td>
                               </tr>
                               <tr>
                                   <td class='label-td' colspan='2'>
                                       <div class='password-container'>
                                           <input type='password' name='docpassword' class='input-text' placeholder='Password' required>
                                           <img src='" . asset('/img/icons/eye.svg') . "' class='toggle-password' onclick='togglePassword()'>
                                       </div>
                                   </td>
                               </tr>

                               <tr>
                                   <td>
                                       "  @endphp
                                       @if ($errors)
                                       <label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">
                                           @foreach ($errors->all() as $error)
                                               <p>{{ $error }}</p>
                                           @endforeach
                                       </label>
                                       @endif
                                       @php echo "
                                   </td>
                               </tr>
                               <tr>
                                   <td colspan='2'>
                                       <input type='reset' value='Reset'  class='login-btn btn-primary-soft btn' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       <input type='submit' value='Save'  class='login-btn btn-primary btn'>
                                   </td>

                               </tr>

                               </form>
                               </tr>
                           </table>
                       </div>
                   </div><br/><br/>
           </div>
       </center>
   </div>
</div>" ;
}
@endphp


</body>
</html>
