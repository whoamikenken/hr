<form id="employeeForm" class="row g-2 needs-validation" novalidate>
    @csrf

    <div class="col-md-6 col-sm-12">
        <label>Employee ID<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="employee_id" name="employee_id"
            class="form-control validate" placeholder="Enter Employee ID" required value="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Employee ID.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>First Name<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="fname" name="fname"
            class="form-control validate" placeholder="Enter First Name" required value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a First Name.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Middle Name<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="mname" name="mname"
            class="form-control validate" placeholder="Enter Middle Name" required value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Middle Name.
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12">
        <label>Last Name<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="lname" name="lname"
            class="form-control validate" placeholder="Enter Last Name" required value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Last Name.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Contact<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="contact" name="contact"
            class="form-control validate" placeholder="Enter contact #" required value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a contact #.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Email<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="email" name="email"
            class="form-control validate" placeholder="Enter Email" required value="">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Email.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Office<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="office" id="office" class="form-control form-select">
                <option value="">Select Option</option>
                @foreach ($office_select as $item)
                <option value="{{$item->code}}" {{ (isset($office) && $office == $item->code)? "selected":"" }} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please select a Office.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Department<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="department" id="department" class="form-control form-select">
                <option value="">Select Option</option>
                @foreach ($department_select as $item)
                <option value="{{$item->code}}" {{ (isset($department) && $department == $item->code)? "selected":"" }} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please select a Sections.
            </div>
        </div>
    </div>
</form>

<script>

    $(document).ready(function () {
        $('.form-select').select2({
            dropdownParent: $('#modal-view'),
            theme: 'bootstrap-5'
        });
    });

    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#employeeForm"));
        
        var formdata = $("#employeeForm").serialize();
    
        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('employee/add') }}",
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
                    location.reload();
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
</script>