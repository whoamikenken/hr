<div class="container-fluid p-0">
    <div class="card border-secondary mb-3 mt-4">
        <div class="card-header" style="font-size: 23px;background: #0d6cf9;color: white;">Schedule</div>
        <div class="card-body text-secondary">
            @if (count($record) > 0)
            <div class="container-fluid">
                <table class="table table-responsive">
                    <thead style="background-color: #1770f9;">
                        <tr>
                            <th style="width:8%">Day of Week</th>
                            <th style="width:9%">From</th>
                            <th style="width:9%">To</th>
                            <th style="width:9%">Tardy Start</th>
                            <th style="width:9%">Absent Start</th>
                        </tr>
                    </thead>
                    <tbody id="schedule">
                        @foreach ($sched_per_day as $dcode => $value)
                        @if (count($value) > 0)
                        @foreach ($value as $item => $schedData)
                        <tr tag='grp' dayofweek='{{$dcode}}'> 
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
                                    <input  type="text" class="form-control totime" name="totime" value="{{ ($schedData->tardy_start)? date("g:i A",strtotime($schedData->tardy_start)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group"> 
                                    <input  type="text" class="form-control totime" name="totime" value="{{ ($schedData->absent_start)? date("g:i A",strtotime($schedData->absent_start)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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