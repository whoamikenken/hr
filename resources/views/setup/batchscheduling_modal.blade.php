<form id="batchschedForm" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{($uid)}}">
    
    <div class="col-md-6 col-sm-12">
        <label>Schedule<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="sched_id" id="sched_id" class="form-control form-select">
                @foreach ($sched_select as $item)
                    <option value="{{$item->id}}" {{ (isset($sched_id) && $sched_id == $item->id)? "selected":"" }} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Schedule.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Campus<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="campus" id="campus" class="form-control form-select">
                @foreach ($campus_select as $item)
                    <option value="{{$item->code}}" {{ (isset($campus) && $campus == $item->code)? "selected":"" }} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Schedule.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Course<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="course" id="course" class="form-control form-select course-select select-predefined" placeholder="Select Options" data-value="{{ (isset($course))? $course:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="course">
                <option value="">Select Course</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Course.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Year Level<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="yearlevel" id="yearlevel" class="form-control form-select">
                @foreach ($yearlevel_select as $item)
                    <option value="{{$item->code}}" {{ (isset($yearlevel) && $yearlevel == $item->id)? "selected":"" }} >{{$item->description}}</option>
                @endforeach
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Year Level.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Section<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select class="section-select section select-predefined form-control" name="section"  placeholder="Select Options" data-value="{{ (isset($section))? $section:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="section">
                <option value="">Select Section</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input a Section.
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

        $('.course-select').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modal-view'),
            ajax: {
                placeholder: 'Search Course',
                allowClear: true,
                type : "POST",
                data:function (params) {
                    var query = {
                        search: params.term,
                        dataSearch:"course",
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
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $('.section-select').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modal-view'),
            ajax: {
                placeholder: 'Search Section',
                allowClear: true,
                type : "POST",
                data:function (params) {
                    var query = {
                        search: params.term,
                        dataSearch:"section",
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
                                id: item.id
                            }
                        })
                    };
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
</script>