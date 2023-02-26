<form id="officeForm" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{($uid)}}">
    <div class="col-md-6 col-sm-12">
        <label>Code<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <input type="text" id="code" name="code"
            class="form-control validate" placeholder="Enter Code" required value="{{ (isset($code))? $code:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a test.
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12">
        <label>Description<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <input type="text" id="description" name="description"
            class="form-control validate" placeholder="Enter Description" required value="{{ (isset($description))? $description:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Description.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Department<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select name="department" id="department" class="form-select">
                <option value="">Select Department</option>
                @foreach ($department_select as $item)
                <option value="{{$item->code}}" {{ (isset($department) && $department == $item->code)? "selected":""}} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Department.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Work Parameter<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select name="work_parameter" id="work_parameter" class="form-select">
                <option value="">Select Work Parameter</option>
                @foreach ($work_parameter_select as $item)
                <option value="{{$item->id}}" {{ (isset($work_parameter) && $work_parameter == $item->id)? "selected":""}} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Work Parameter.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Office Head<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select class="head_id-select head_id select-predefined" name="head_id" placeholder="Select Options" data-value="{{ (isset($head_id))? $head_id:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="user"> 
                            <option value="">Select Head</option>
                        </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Department.
            </div>
        </div>
    </div>

    
    <div class="col-md-6 col-sm-12">
        <label>Color<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <input type="color" class="form-control form-control-color" id="exampleColorInput" name="color" value="{{ (isset($color) && $color != "")? $color:"" }}" title="Choose your color">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Color.
            </div>
        </div>
    </div>

</form>

<script>

    $(document).ready(function () {

        $('.select-predefined').each(function (index, element) {
            var item = $(element);
            if (item.data('url')) {
                CustomInitSelect2(item, {
                    url: item.data('url'),
                    table: item.data('table'),
                    desc: item.data('desc'),
                    initialValue: item.data('value')
                });
            }
        });
    });

    $('.head_id-select').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modal-view'),
        ajax: {
            placeholder: 'Search User',
            allowClear: true,
            type : "POST",
            data:function (params) {
                var query = {
                    search: params.term,
                    dataSearch:"user",
                    mode:"single",
                }
                return query;
            },
            async: false,
            url: "{{ url('getDropdown/dropdown') }}",
            dataType: 'json',
            delay: 500,
            minimumInputLength: 1,
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item) {
                        return {
                            text: item.name,
                            units: item.units,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#officeForm"));
        
        var formdata = $("#officeForm").serialize();

        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('office/add') }}",
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
                    OfficeList();
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