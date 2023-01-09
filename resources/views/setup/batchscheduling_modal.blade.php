<form id="batchschedForm" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{($uid)}}">

    <div class="col-md-6 col-sm-12">
        <label>Office<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select class="office-select office select-predefined" name="office" placeholder="Select Options" data-value="{{ (isset($office))? $office:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="office"> 
                            <option value="">Select Office</option>
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
        <label>Department<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select class="department-select department select-predefined" name="department" placeholder="Select Options" data-value="{{ (isset($department))? $department:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="department"> 
                            <option value="">Select Department</option>
                        </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Department.
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <label>Schedule<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select class="schedule-select schedule select-predefined" name="sched_id" placeholder="Select Options" data-value="{{ (isset($sched_id))? $sched_id:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="schedule"> 
                            <option value="">Select Schedule</option>
                        </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Department.
            </div>
        </div>
    </div>

</form>

<script>

    $(document).ready(function () {
        
        $('.select-predefined').each(function (index, element) {
            if($(this).val()){
                var item = $(element);
                if (item.data('url')) {
                    CustomInitSelect2(item, {
                        url: item.data('url'),
                        table: item.data('table'),
                        desc: item.data('desc'),
                        initialValue: item.data('value')
                    });
                }
            }
        });

    });    
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#batchschedForm"));
        
        var formdata = $("#batchschedForm").serialize();

        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('batchschedule/add') }}",
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
                    BatchscheduleList();
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

    $('.office-select').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modal-view'),
        ajax: {
            placeholder: 'Search Office',
            allowClear: true,
            type : "POST",
            data:function (params) {
                var query = {
                    search: params.term,
                    dataSearch:"office",
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

    $('.department-select').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modal-view'),
        ajax: {
            placeholder: 'Search Department',
            allowClear: true,
            type : "POST",
            data:function (params) {
                var query = {
                    search: params.term,
                    dataSearch:"department",
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

    $('.schedule-select').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modal-view'),
        ajax: {
            placeholder: 'Search Schedule',
            allowClear: true,
            type : "POST",
            data:function (params) {
                var query = {
                    search: params.term,
                    dataSearch:"schedule",
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
</script>