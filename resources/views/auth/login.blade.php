@extends('layouts.app')

@section('content')
<style>
    a {
        text-decoration: none;
    }
    
    .login-page {
        width: 100%;
        height: 60vh;
        display: inline-block;
        display: flex;
        align-items: center;
    }
    
    .form-right i {
        font-size: 100px;
    }
</style>
<div class="login-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h3 class="mb-3">Login Now</h3>
                <div class="bg-white shadow rounded animate__animated animate__fadeInUp">
                    <div class="row">
                        <div class="col-md-7 pe-0">
                            <div class="form-left h-100 py-5 px-5">
                                <form id="loginForm" class="row g-4 needs-validation" novalidate>
                                    @csrf
                                    <div class="col-12">
                                        <label>Username<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                            <input type="text" id="username" name="username"
                                            class="form-control validate" placeholder="Enter Username" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input a username.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label>Password<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                            <input type="password" id="password" name="password"
                                            class="form-control validate" placeholder="Enter Password" required max='16'>
                                            <div toggle="#password" class="input-group-text toggle-password"><i class="bi bi-eye-fill"></i></div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please input a password.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-6">
                                        <a href="#" class="float-start text-primary">Forgot Password?</a>
                                    </div>
                                    
                                    <div class="col-sm-12 col-sm-6 text-end">
                                        <button type="button" id="login"
                                        class="btn btn-primary px-4">Login</button>&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-info px-4 text-white" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 ps-0 d-none d-md-block">
                            <div class="form-right h-100 text-white text-center pt-5" style="background-color:#c2d6e7">
                                <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt=""
                                style="max-width:50%;">
                                <h2 class="fs-1">Welcome!</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="registerLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-2 d-none d-md-block">
                        <img src="{{ asset('images/logo.png')}}" class="img-fluid img-thumbnail rounded float-start" alt="...">
                    </div>
                    <div class="col-sm-10">
                        <h3 class="modal-title" id="registerLabel">Register User</h3>
                        <h5>Envision and achieve an optimum goal</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <div class="row">
                    <form id="registrationForm" class="row g-2 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-6 col-sm-12">
                            <label>Username<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" id="usernameReg" name="username"
                                class="form-control validate" placeholder="Enter Username" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input a username.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label>Email<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-mailbox"></i></div>
                                <input type="email" id="emailReg" name="email"
                                class="form-control validate" placeholder="Enter Email" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input a email.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label>First Name<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" id="fname" name="fname"
                                class="form-control validate" placeholder="Enter First Name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input a First Name.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label>Last Name<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" id="lname" name="lname"
                                class="form-control validate" placeholder="Enter Last Name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input a Last Name.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label>Password<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-file-lock"></i></div>
                                <input type="password" id="passwordReg" name="password"
                                class="form-control validate" placeholder="Enter Password" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input a password.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label>Confirm Password<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-file-lock"></i></div>
                                <input type="password" id="confirm_password" name="password_confirmation"
                                class="form-control validate" placeholder="Enter Password" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please input retype password.
                                </div>
                                
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modalclose">Close</button>
            <button type="button" class="btn btn-primary" id="register">Register</button>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    $("#login").unbind("click").click(function() {
        bootstrapForm($("#loginForm"));
        if ($("#username").val() == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please input username.',
                timer: 5000
            })
            $("#username").focus();
            return;
        }
        
        if ($("#password").val() == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please input password.',
                timer: 1500
            })
            $("#password").focus();
            return;
        }
        
        
        var formdata = $("#loginForm").serialize();
        
        $.ajax({
            url: "{{ url('login/validate') }}",
            type: "POST",
            data: formdata,
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.msg,
                        time: 2500
                    })
                    $("#modalclose").click();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                }else if (response.status == 2) {
                    Swal.fire({
                        icon: 'info',
                        title: response.title,
                        text: response.msg
                    })
                }else if (response.status == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: response.title,
                        text: response.msg
                    })
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: "System Error",
                        text: "Please contact developer."
                    })
                }
            }
        });
    });
    
    $("#register").unbind("click").click(function() {
        bootstrapForm($("#registrationForm"));
        
        if ($("#passwordReg").val() != $("#confirm_password").val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Password are not the same.',
                timer: 1500
            })
            $("#confirm_password").focus();
            return;
        }
        
        
        var formdata = $("#registrationForm").serialize();
        
        $.ajax({
            url: "{{ url('login/register') }}",
            type: "POST",
            data: formdata,
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.msg
                    })
                    $("#modalclose").click();
                } else if (response.trim() == "Unverified") {
                    Swal.fire({
                        icon: 'error',
                        title: response.title,
                        text: response.msg
                    })
                }
            }
        });
    });
    
    function bootstrapForm(form) {
        
        $(form).find('select.validate').each(function(idx) {
            $(this).parent().find('select').addClass("is-invalid");
            if ($(this).val().length == 0) {
                throw new Error("Something went badly wrong!");
            } else {
                $(this).parent().find('select').removeClass("is-invalid");
                $(this).parent().find('select').addClass("is-valid");
            }
        });
        
        $(form).find('input.validate').each(function(idx) {
            if ($(this).val().length == 0) {
                $(this).addClass("is-invalid");
                throw new Error("Something went badly wrong!");
            } else {
                if($(this).attr("type") == "email"){
                    var emailpattern=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                    if(emailpattern.test($(this).val()))
                    {
                        $(this).removeClass("is-invalid").addClass("is-valid");
                    }
                    else
                    {
                        $(this).addClass("is-invalid");
                        // console.log( $(this).next(".invalid-feedback"));
                        $(this).parent().find(".invalid-feedback").text("Please input a valid email");
                        throw new Error("Something went badly wrong!");
                    }
                }
            }
        });
        
        
        $(form).find('textarea.validate').each(function(idx) {
            if ($(this).val().length == 0) {
                $(this).addClass("is-invalid");
                throw new Error("Something went badly wrong!");
            } else {
                $(this).removeClass("is-invalid").addClass("is-valid");
            }
        });
        return true;
    }

    var clickedPasswordToggler = 0;
    $(".toggle-password").click(function (e) {
        e.preventDefault();

        $(this).toggleClass("toggle-password");
        if (clickedPasswordToggler == 0) {
            $(this).html('<i class="bi bi-eye-fill"></i>');
            clickedPasswordToggler = 1;
        } else {
            $(this).html('<i class="bi bi-eye-slash-fill"></i>');
            clickedPasswordToggler = 0;
        }

        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
</script>

@endsection
