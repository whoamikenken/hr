<form id="userForm" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{($uid)}}">

    <div class="col-md-6 col-sm-12">
        <label>Username<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="username" name="username"
            class="form-control validate" placeholder="Enter Username" required value="{{ (isset($username))? $username:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Username.
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12">
        <label>Email<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="email" id="email" name="email"
            class="form-control validate" placeholder="Enter Email" required value="{{ (isset($email))? $email:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Email.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>First Name<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="fname" name="fname"
            class="form-control validate" placeholder="Enter First Name" required value="{{ (isset($fname))? $fname:"" }}">
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
            class="form-control validate" placeholder="Enter Last Name" required value="{{ (isset($lname))? $lname:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Last Name.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>User Type<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="user_type" id="user_type" class="form-select validate">
                @foreach ($usertype_select as $item)
                    <option value="{{$item->code}}" {{ (isset($user_type) && $user_type == $item->code)? "selected":"" }} >{{$item->code}}</option>
                @endforeach

                {{-- <option value="Admin" {{ (isset($user_type) && $user_type == "Admin")? "selected":"" }} >Admin</option>
                <option value="Sales" {{ (isset($user_type) && $user_type == "Sales")? "selected":"" }} >Sales</option> --}}
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Description.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Status<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select name="status" id="status" class="form-select validate">
                <option value="verified" {{ (isset($status) && $status == "verified")? "selected":"" }} >Verified</option>
                <option value="unverified" {{ (isset($status) && $status == "unverified")? "selected":"" }} >Unverified</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Description.
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <label>User Image<span class="text-danger"></span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-image"></i></div>
            <input type="file" id="user_image" name="user_image" class="form-control" value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a image.
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <label>Password<span class="text-danger"></span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
            <input type="password" id="password" name="password"
            class="form-control" placeholder="Update password?" value="" max="16">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Description.
            </div>
        </div>
    </div>
    <input type="hidden" name="edatalistRead" id="edatalistRead">
    <input type="hidden" name="edatalistAdd" id="edatalistAdd">
    <input type="hidden" name="edatalistEdit" id="edatalistEdit">
    <input type="hidden" name="edatalistDel" id="edatalistDel">
</form>
<hr class="mt-2">
<h2 class="text-center">System Access</h2>
<hr>
@php
    echo $showAccess;
@endphp
<script>
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#userForm"));
        
        var rAccess = $("input[name=rAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistRead").val(rAccess);

        var aAccess = $("input[name=aAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistAdd").val(aAccess);

        var eAccess = $("input[name=eAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistEdit").val(eAccess);

        var dAccess = $("input[name=dAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistDel").val(dAccess);

        var formdata = processForm($("#userForm"));
    
        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('user/add') }}",
            type: "POST",
            data: formdata,
            cache:false,
            contentType: false,
            processData: false,
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
                    UserList();
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

    function processForm(form){

        var formdata = new FormData(); // Creating object of FormData class
        
        form.find("select, textarea, input").each(function() {
            console.log(this);
            if ($(this).attr('type') == "file") {
                var user_file = $(this)[0].files[0];
                formdata.append($(this).attr('name'), user_file);
            }else{
                formdata.append($(this).attr('name'), $(this).val());
            }
        });

        return formdata;
    }
</script>