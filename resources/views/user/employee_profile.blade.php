<div class="container-fluid p-0">
    <div class="card border-secondary mb-3 mt-4">
        <div class="card-header" style="font-size: 23px;background: #0d6cf9;color: white;">General Information</div>
        <div class="card-body text-secondary">
            <div class="row">
                <div class="col-sm-12 col-lg-4 text-center">
                    @if ($user_profile != "")
                    <img src="{{  Storage::disk("s3")->url($user_profile)}}" class="img-fluid rounded-start" alt="..." style="max-height: 268px;">
                    @else
                    <img src="{{ asset('images/user.png')}}" class="img-fluid rounded-start" alt="..." style="max-height: 268px;">
                    @endif
                    <br>
                    <div class="input-group custom-file-button mt-2">
                        <label class="input-group-text" for="user_profile">{{($user_profile != "")? "Replace":"Upload"}} Picture</label>
                        <input type="file" class="form-control form-control-sm" id="user_profile" name="user_profile">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Employee ID.</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-pass"></i></div>
                            <input type="text" id="employee_id" name="employee_id"
                            class="form-control" placeholder="Enter Employee ID" value="{{ $employee_id }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">First Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person"></i></div>
                            <input type="text" id="fname" name="fname"
                            class="form-control validate" placeholder="Enter First Name" value="{{ $fname }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a First Name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Middle Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person"></i></div>
                            <input type="text" id="mname" name="mname"
                            class="form-control validate" placeholder="Enter Middle Name" value="{{ $mname }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a Middle Name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Email</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-rolodex"></i></div>
                            <input type="email" id="email" name="email"
                            class="form-control validate" placeholder="Enter Email" value="{{ $email }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Emergency Person</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-rolodex"></i></div>
                            <input type="text" id="family_contact_name" name="family_contact_name"
                            class="form-control validate" placeholder="Enter Emergency Person" value="{{ $family_contact_name }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Height</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-rolodex"></i></div>
                            <input type="text" id="height" name="height"
                            class="form-control validate" placeholder="Enter Height" value="{{ $height }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Date of Birth</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-calendar-date"></i></div>
                            <input type="text" id="date_of_birth" name="date_of_birth" class="form-control datepicker" value="{{ $date_of_birth }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Office</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-building"></i></div>
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
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Marital Status</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
                            <select name="marital_status" id="marital_status" class="form-control form-select">
                                <option value="">Select Option</option>
                                <option value="Single" {{ (isset($marital_status) && $marital_status == "Single")? "selected":"" }} >Single</option>
                                <option value="Married" {{ (isset($marital_status) && $marital_status == "Married")? "selected":"" }} >Married</option>
                                <option value="Widow" {{ (isset($marital_status) && $marital_status == "Widow")? "selected":"" }} >Widow</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Date Employed</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-calendar-date"></i></div>
                            <input type="text" id="date_applied" name="date_applied" class="form-control datepicker" value="{{ $date_applied }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Employee Status</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
                            <select name="status" id="status" class="form-control form-select">
                                <option value="">Select Option</option>
                                <option value="Regular" {{ (isset($status) && $status == "Regular")? "selected":"" }} >Regular</option>
                                <option value="Irregular" {{ (isset($status) && $status == "Irregular")? "selected":"" }} >Irregular</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Last Name</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person"></i></div>
                            <input type="text" id="lname" name="lname"
                            class="form-control validate" placeholder="Enter Last Name" value="{{ $lname }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a Last Name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Account Status</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
                            <select name="isactive" id="isactive" class="form-control form-select">
                                <option value="">Select Option</option>
                                <option value="Active" {{ (isset($isactive) && $isactive == "Active")? "selected":"" }} >Active</option>
                                <option value="Inactive" {{ (isset($isactive) && $isactive == "Inactive")? "selected":"" }} >Terminated</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Contact</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-hash"></i></div>
                            <input type="text" id="contact" name="contact"
                            class="form-control validate" value="{{ $contact }}" placeholder="+639__-___-____" data-slots="_">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a Contact.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Emergency Contact</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-hash"></i></div>
                            <input type="text" id="family_contact" name="family_contact"
                            class="form-control validate" value="{{ $family_contact }}" placeholder="+639__-___-____" data-slots="_">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a Emergency Contact.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Weight</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-rolodex"></i></div>
                            <input type="text" id="weight" name="weight"
                            class="form-control validate" placeholder="Enter Weight" value="{{ $weight }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Age</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-hash"></i></div>
                            <input type="number" id="age" name="age"
                            class="form-control validate" value="{{ $age }}"  max="99">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input a Age.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Department</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-building"></i></div>
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
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Gender</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
                            <select name="gender" id="gender" class="form-control form-select">
                                <option value="">Select Option</option>
                                <option value="Male" {{ (isset($gender) && $gender == "Male")? "selected":"" }} >Male</option>
                                <option value="Female" {{ (isset($gender) && $gender == "Female")? "selected":"" }} >Female</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <label style="font-weight:600">Religion</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
                            <select name="religion" id="religion" class="form-control form-select">
                                <option value="">Select Option</option>
                                <option value="Roman catholic" {{ (isset($religion) && $religion == "Roman catholic")? "selected":"" }} >Roman catholic</option>
                                <option value="INC" {{ (isset($religion) && $religion == "INC")? "selected":"" }} >INC</option>
                                <option value="Pagan" {{ (isset($religion) && $religion == "Pagan")? "selected":"" }} >Pagan</option>
                                <option value="Islam" {{ (isset($religion) && $religion == "Islam")? "selected":"" }} >Islam</option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please input.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-12 offset-md-4">
                    <label style="font-weight:600">Address</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="bi bi-geo-alt"></i></div>
                        <input type="text" id="address" name="address"
                        class="form-control validate" placeholder="Enter address" value="{{ $address }}">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please input a address.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".datepicker").tempusDominus({
            localization: {
                locale: 'en-US',
                format: 'yyyy-MM-dd',
            }
        });
        
        $('.form-select').select2({
            theme: 'bootstrap-5'
        });

        @if (!in_array("803", $editAccess))
            $("input").attr('disabled','disabled');
            $("select").attr('disabled','disabled');
        @endif

        $("#age").val(getAge($("#date_of_birth").val()));
        $("#age").trigger("change");
    });
    
    $('#userVideo').on('hidden.bs.modal', function (e) {
        $('video').trigger('pause');
    })
    
    
    $("input[type=text], input[type=file], input[type=number], textarea, select").on("change", function(){
        // if ($(this).val()) {
            @if (!in_array("803", $editAccess))
                Swal.fire({
                    icon: 'error',
                    title: "You have no edit permission",
                    text: "This will be recorded."
                })
                $("input").attr('disabled','disabled');
                $("select").attr('disabled','disabled');
                setTimeout(() => {
                    $("#pills-tab").find(".active").click();
                }, 2000);
                return false;
            @else
                saveSingleProfileColumn($(this));
            @endif
            
        // }else return;   
    });
    
</script>