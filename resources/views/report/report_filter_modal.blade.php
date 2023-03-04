@php
    $hidden = "";
    if($tag == "termination"){
        $hidden = "style=display:none";
    }
@endphp

<form id="reportForm" class="row g-2" action="{{ url('report/generateReport') }}" method="POST" target="_blank">
    @csrf
    <input type="hidden" name="tag" id="tag" value="{{($tag)}}">
    <input type="hidden" name="reportName" id="reportName" value="{{($reportName)}}">
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
    @if ($tag == "hrreport")
    <hr class="mt-4">
    <br>
    <h4 class="text-center p-1">Select Data</h4>
    @php
    echo $showColumn;
    @endphp
    <input type="hidden" name="edatalist" id="edatalist">
    @elseif ($tag != "hrreport")
    <div class="col-sm-12">
        <label>Employee<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pencil-fill"></i></div>
            <select class="employee-select employee select-predefined" name="employee_id" placeholder="Select Options" data-value="{{ (isset($employee))? $employee:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="employee"> 
                            <option value="">Select Employee</option>
                        </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Employee.
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-lg-6">
        <label style="font-weight:600">From</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-calendar-date"></i></div>
            <input type="text" id="from" name="from" class="form-control datepicker" value="{{ date("Y-m-d") }}" placeholder="Select date from">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input.
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-lg-6">
        <label style="font-weight:600">To</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-calendar-date"></i></div>
            <input type="text" id="to" name="to" class="form-control datepicker" value="{{ date("Y-m-d") }}" placeholder="Select date to">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input.
            </div>
        </div>
    </div>
    @endif
</form>

<script>
    
    $(document).ready(function () {
        $('.datepicker').tempusDominus({
            localization: {
            locale: 'en-US',
            format: 'yyyy-mm-dd',
            },
        });
        
        $('.form-select').select2({
            dropdownParent: $('#modal-view'),
            theme: 'bootstrap-5'
        });
    });

    $(".selectAll").unbind("click").click(function(){
        var tag = $(this).attr("tag");
        if($(this).is(':checked')){
            $("."+tag).prop('checked', true);
        }else{
            $("."+tag).prop('checked', false);
        }
    });
    
    $("#saveModal").unbind("click").click(function(){
        if($("#tag").val() == "hrreport"){
            var edata = $("input[name=edata]:checked").map(function () {return this.value;}).get().join(","); 
            $("#edatalist").val(edata);
        }

        jQuery('#reportForm').submit();
    });

    $('.employee-select').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modal-view'),
        ajax: {
            placeholder: 'Search Employee',
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
    
</script>