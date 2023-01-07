@extends('layouts.header')

@section('content')

@php
$office_select = DB::table('offices')->get();
$department_select = DB::table('departments')->get();
$employee_select = DB::table('employees')->where("isactive","Active")->get();
@endphp

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Employee Information</h1>
</div>
<div id="employeeContainer">
    <div class="card shadow animate__animated animate__fadeInRight">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <a href="javascript:void(0);" class="btn btn-primary mb-2 addbtn"><i class="bi bi-plus-circle"></i> Add Employee</a>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="text-sm-end">
                    </div>
                </div><!-- end col-->
            </div><br>
            <form id="employeeListForm">
                <input type="hidden" name="page" id="page" value="1">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="row mb-3">
                            <label for="colFormLabel" class="col-sm-2 col-form-label">Office</label>
                            <div class="col-sm-10">
                                <select name="office" id="office" class="form-select">
                                    <option value="" selected>All Office</option>
                                    @foreach ($office_select as $item)
                                    <option value="{{$item->code}}" >{{$item->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="row mb-3">
                            <label for="colFormLabel" class="col-sm-2 col-form-label">Department</label>
                            <div class="col-sm-10">
                                <select name="department" id="department" class="form-select">
                                    <option value="" selected>All Department</option>
                                    @foreach ($department_select as $item)
                                    <option value="{{$item->code}}" >{{$item->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="row mb-3">
                            <label for="colFormLabel" class="col-sm-2 col-form-label">Employee</label>
                            <div class="col-sm-10">
                                <select name="employee" id="employee" class="form-select">
                                    <option value="" selected>All Employee</option>
                                    @foreach ($employee_select as $item)
                                    <option value="{{$item->employee_id}}" >{{$item->employee_id." - ".$item->lname." ".$item->fname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <button class="btn btn-primary" id="searchEmployee" type="button">Search</button>
                    </div>
            </div>
        </div> <!-- end card-body-->
    </div>
    <br><br>
    <div id="employeeDiv">
        
    </div>
</div>

<script>
    
    $(document).ready(function () {
        $('.form-select').select2({
            theme: 'bootstrap-5'
        });
        EmployeeList();
    });
    
    $("#searchEmployee").click(function() {
        EmployeeList();
    });
    
    function EmployeeList(){
        var formdata = $("#employeeListForm").serialize();
        
        $.ajax({
            type: "POST",
            url: "{{ url('employee/list')}}",
            data: formdata,
            async: false,
            success:function(response){
                $("#employeeDiv").html(response);
            }
        });
    }
    
    $(".addbtn").click(function() {
        var uid = "add";
        $.ajax({
            type: "POST",
            url: "{{ url('employee/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Add Employee");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });
    
    $(document).on("click","#paginationEmployee a, #search_btn",function(){
        //get url and make final url for ajax 
        var url=$(this).attr("href");
        var mystr = url.split("=");
        $("#page").val(mystr[1]);
        EmployeeList();
        return false;
    })

    $(document).on("click",".employeeView",function(){
        var uid = $(this).attr('uid');
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
    })
</script>
@endsection
