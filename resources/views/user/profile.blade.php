@extends('layouts.header')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Profile</h1>
</div>
<input type="hidden" id="employee_id" value="{{Auth::user()->username}}">
<div id="employeeContainer">
</div>

<script>
    
    $(document).ready(function () {
        var uid = $("#employee_id").val();
        $.ajax({
            type: "POST",
            url: "{{ url('employee/getEmployeeProfileTab')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#employeeContainer").html(response);
            }
        });
    });
</script>
@endsection
