<form id="studentForm" class="row g-2 needs-validation" novalidate>
    @csrf

    <div class="col-md-6 col-sm-12">
        <label>Student ID<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
            <input type="text" id="student_id" name="student_id"
            class="form-control validate" placeholder="Enter Student ID" required value="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Student ID.
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
        <label>Campus<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="campus" id="campus" class="form-select validate">
                @foreach ($campuses_select as $item)
                    <option value="{{$item->code}}" >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please select a Campus.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Courses<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="courses" id="courses" class="form-select validate">
                @foreach ($courses_select as $item)
                    <option value="{{$item->code}}">{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please select a Courses.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Year Level<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="year_level" id="year_level" class="form-select validate">
                @foreach ($yearlevels_select as $item)
                    <option value="{{$item->code}}">{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please select a Year Level.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Sections<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-lines-fill"></i></div>
            <select name="section" id="section" class="form-select validate">
                @foreach ($sections_select as $item)
                    <option value="{{$item->code}}">{{$item->description}}</option>
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
        bootstrapForm($("#studentForm"));
        
        var formdata = $("#studentForm").serialize();
    
        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('student/add') }}",
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
                    StudentList();
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