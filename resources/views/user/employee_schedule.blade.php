<div class="container-fluid p-0">
    <div class="card border-secondary mb-3 mt-4">
        <div class="card-header" style="font-size: 23px;background: #0d6cf9;color: white;">Schedule</div>
        <div class="card-body text-secondary">
            @if (count($record) > 0)
                <div class="container-fluid">
                    <table class="table table-responsive">
                        <thead style="background-color: #FFF201;">
                            <tr>
                                {{-- <th>Actions</th> --}}
                                <th style="width:8%">Day of Week</th>
                                <th style="width:9%">From</th>
                                <th style="width:9%">To</th>
                                <th style="width:15%">Subject</th>
                                <th style="width:5%">Units</th>
                                <th style="width:15%">Professor</th>
                                <th style="width:15%">Course</th>
                                <th style="width:13%">Year Level</th>
                                <th style="width:11%">Section</th>
                            </tr>
                        </thead>
                        <tbody id="schedule">
                            @foreach ($sched_per_day as $dcode => $value)
                            
                            @if (count($value) > 0)
                            
                            @foreach ($value as $item => $schedData)
                            @php
                            // dd($schedData);
                            @endphp
                            <tr tag='grp' dayofweek='{{$dcode}}'> 
                                {{-- <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-info" tag='copy_sched'><i class="bi bi-clipboard"></i>Copy</button>
                                        <button type="button" class="btn btn-info" tag='paste_sched'><i class="bi bi-clipboard2-check"></i>Paste</button>
                                        <button type="button" class="btn btn-info" tag='edit_erase_time'><i class="bi bi-clipboard2-x"></i>Erase</button>
                                        <button type="button" class="btn btn-info" tag='add_sched'><i class="bi bi-clipboard2-plus"></i>Add</button>
                                    </div>
                                </td> --}}
                                <td>
                                    {{$dow[$dcode]}}
                                </td>
                                <td>
                                    <div class="input-group"> 
                                        <input  type="text" class="form-control ftime" name="fromtime" value="{{ ($schedData->starttime)? date("g:i A",strtotime($schedData->starttime)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group"> 
                                        <input  type="text" class="form-control totime" name="totime" value="{{ ($schedData->endtime)? date("g:i A",strtotime($schedData->endtime)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="subject-select subject select-predefined" name="subject" placeholder="Select Options" data-value="{{ ($schedData->subject)? $schedData->subject:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="subject"> 
                                            <option value="">Select Subject</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control units" name="units" value="{{ $schedData->units}}">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="prof-select prof select-predefined" name="professor" placeholder="Select Options" data-value="{{ ($schedData->professor)? $schedData->professor:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="prof">
                                            <option value="">Select Professor</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="course-select course select-predefined" name="course" placeholder="Select Options" data-value="{{ ($schedData->coursecode)? $schedData->coursecode:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="course">
                                            <option value="">Select Course</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="yearlevel-select yearlevel select-predefined" name="yearlevels" placeholder="Select Options" data-value="{{ ($schedData->yearlevels)? $schedData->yearlevels:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="yl">
                                            <option value="">Select Year Level</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="section-select section select-predefined" name="section"  placeholder="Select Options" data-value="{{ ($schedData->section)? $schedData->section:''}}" data-url="{{ url('getDropdown/dropdownInit') }}" data-table="section">
                                            <option value="">Select Section</option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr tag='grp' dayofweek='{{$dcode}}'> 
                                {{-- <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-info" tag='copy_sched'><i class="bi bi-clipboard"></i>Copy</button>
                                        <button type="button" class="btn btn-info" tag='paste_sched'><i class="bi bi-clipboard2-check"></i>Paste</button>
                                        <button type="button" class="btn btn-info" tag='edit_erase_time'><i class="bi bi-clipboard2-x"></i>Erase</button>
                                        <button type="button" class="btn btn-info" tag='add_sched'><i class="bi bi-clipboard2-plus"></i>Add</button>
                                    </div>
                                </td> --}}
                                <td>
                                    {{$dow[$dcode]}}
                                </td>
                                <td>
                                    <div class="input-group"> 
                                        <input  type="text" class="form-control ftime" name="fromtime"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group"> 
                                        <input  type="text" class="form-control totime" name="totime" /> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="subject-select subject" name="subject" placeholder="Select Options" subjectSelect="">
                                            <option value=""></option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control units" name="units" min="0" max="5" value="">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="prof-select prof" name="professor" placeholder="Select Options">
                                            <option value=""></option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="course-select course" name="course" placeholder="Select Options">
                                            <option value=""></option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="yearlevel-select yearlevel" name="yearlevels" placeholder="Select Options">
                                            <option value=""></option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="bi bi-option"></i></div>
                                        <select class="section-select section" name="section"  placeholder="Select Options">
                                            <option value=""></option>
                                        </select>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please input.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h1>No Schedule</h1>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $("#sidebarMenu").removeClass("d-md-block").removeClass("col-lg-2").addClass("col-lg-0");
        $("main").removeClass("col-lg-10").addClass("col-lg-12");

        @if (!in_array("803", $editAccess))
            $("input").attr('disabled','disabled');
            $("select").attr('disabled','disabled');
        @endif

        $('.ftime, .totime').tempusDominus({
            display: {
                viewMode: 'clock',
                components: {
                    decades: false,
                    year: false,
                    month: false,
                    date: false,
                    hours: true,
                    minutes: true,
                    seconds: false
                }
            }
        });

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

        $('.subject-select').select2({
            theme: 'bootstrap-5',
            ajax: {
                placeholder: 'Search Subject',
                allowClear: true,
                type : "POST",
                data:function (params) {
                    var query = {
                        search: params.term,
                        dataSearch:"subject",
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
        
        $('.prof-select').select2({
            theme: 'bootstrap-5',
            ajax: {
                placeholder: 'Search Professor',
                allowClear: true,
                type : "POST",
                data:function (params) {
                    var query = {
                        search: params.term,
                        dataSearch:"prof",
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
        
        $('.course-select').select2({
            theme: 'bootstrap-5',
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
        
        $('.yearlevel-select').select2({
            theme: 'bootstrap-5',
            ajax: {
                placeholder: 'Search Year Level',
                allowClear: true,
                type : "POST",
                data:function (params) {
                    var query = {
                        search: params.term,
                        dataSearch:"yl",
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

</script>