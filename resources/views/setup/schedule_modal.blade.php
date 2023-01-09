<form id="scheduleForm" class="row g-2 needs-validation" novalidate>
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
                Please input a Code.
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
</form>

<hr class="mt-2 md-2">
<h3 class="text-center">Schedule</h3>

<div class="container-fluid table-responsive">
    <table class="table">
        <thead style="background-color: #FFF201;">
            <tr>
                <th>Actions</th>
                <th>Day of Week</th>
                <th>From</th>
                <th>To</th>
                <th>Tardy Start</th>
                <th>Absent Start</th>
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
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" tag='copy_sched'><i class="bi bi-clipboard"></i>Copy</button>
                        <button type="button" class="btn btn-info" tag='paste_sched'><i class="bi bi-clipboard2-check"></i>Paste</button>
                        <button type="button" class="btn btn-info" tag='edit_erase_time'><i class="bi bi-clipboard2-x"></i>Erase</button>
                        <button type="button" class="btn btn-info" tag='add_sched'><i class="bi bi-clipboard2-plus"></i>Add</button>
                    </div>
                </td>
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
                        <input  type="text" class="form-control totime" name="totime"  value="{{ ($schedData->endtime)? date("g:i A",strtotime($schedData->endtime)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control tardy" name="tardy" value="{{ ($schedData->tardy_start)? date("g:i A",strtotime($schedData->tardy_start)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control absent" name="absent" value="{{ ($schedData->absent_start)? date("g:i A",strtotime($schedData->absent_start)):''}}"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr tag='grp' dayofweek='{{$dcode}}'> 
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-info" tag='copy_sched'><i class="bi bi-clipboard"></i>Copy</button>
                        <button type="button" class="btn btn-info" tag='paste_sched'><i class="bi bi-clipboard2-check"></i>Paste</button>
                        <button type="button" class="btn btn-info" tag='edit_erase_time'><i class="bi bi-clipboard2-x"></i>Erase</button>
                        <button type="button" class="btn btn-info" tag='add_sched'><i class="bi bi-clipboard2-plus"></i>Add</button>
                    </div>
                </td>
                <td>
                    {{$dow[$dcode]}}
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control ftime" name="fromtime" value=""/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control totime" name="totime"  id="totime" /> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control tardy" name="tardy" /> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="input-group"> 
                        <input  type="text" class="form-control absent" name="absent" /> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i>
                        </span>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<script>
    
    var schedarr = [];
    
    $(document).ready(function () {
        

        $("input[name='fromtime'],input[name='totime'],input[name='tardy'],input[name='absent']").tempusDominus({
            localization: {
            locale: 'en-US',
            format: 'hh:mm T',
            },
            display: {
                viewMode: 'clock',
                buttons: {
                    close: true,
                },
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
    });
    
    $("#saveModal").unbind().bind("click").click(function(){
        
        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });
        
        
        var hasconflict = 0;
        var last_trcode = "";
        var periods = [];

        $("#schedule").find("tr[tag='grp']").each(function(){
            var ftime = $(this).find("input[name='fromtime']:first").val();
            var totime = $(this).find("input[name='totime']:first").val();
            if(last_trcode == $(this).attr("dayofweek")){
                const AnotherPeriod = [{start:toHoursMins(ftime), end:toHoursMins(totime)}];
                periods = periods.concat(AnotherPeriod);
            }else{
                var TimeChecker = timeOverlapChecker(periods);
                if(TimeChecker){
                    hasconflict++;
                }
                if(ftime == totime && ftime && totime){
                    hasconflict++;
                }
                periods = [];
                const AnotherPeriod = [{start:toHoursMins(ftime), end:toHoursMins(totime)}];
                periods = periods.concat(AnotherPeriod);
            }
            last_trcode = $(this).attr("dayofweek");
        });

        if(hasconflict>0){
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Invalid Schedule',
                showConfirmButton: true,
                timer: 1000
            });
            return;
        }
        
        bootstrapForm($("#scheduleForm"));
        
        var formdata = $("#scheduleForm").serialize();
        
        
        var pars2 = "~u~"; 
        var scheduleData = "";
        var timediff = 0;
        $("#schedule").find("tr[tag='grp']").each(function(){
            if($(this).find("input[name='fromtime']:first").val() && $(this).find("input[name='totime']:first").val()){
                scheduleData += scheduleData ? "|" : ""; 
                scheduleData += $(this).attr("dayofweek");
                scheduleData += pars2;
                scheduleData += $(this).find("input[name='fromtime']:first").val() + "-" + $(this).find("input[name='totime']:first").val();
                scheduleData += pars2;
                scheduleData += $(this).find("input[name='tardy']:first").val();
                scheduleData += pars2;
                scheduleData += $(this).find("input[name='absent']:first").val();
            }
        });
        
        formdata+="&schedule=" + scheduleData; 
        
        $.ajax({
            url: "{{ url('schedule/add') }}",
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
                    ScheduleList();
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
    
    $("button[tag='copy_sched']").click(function(){  copytime($(this).parent().parent().parent());
        $("button[tag='copy_sched']").each(function(){   $(this).css({"color":"","background-color":""});});
    });
    
    $("button[tag='paste_sched']").click(function(){ pastetime($(this).parent().parent().parent()); });
    
    function copytime(obj){
        if(schedarr.length > 0)  schedarr = [];
        var schedarr_temp = [];
        $('tr[dayofweek='+obj.attr('dayofweek')+']').each(function(){
            var from          = $(this).find("input[name='fromtime']").val();
            var to            = $(this).find("input[name='totime']").val();
            var tardy            = $(this).find("input[name='tardy']").val();
            var absent            = $(this).find("input[name='absent']").val();
            
            if(from != '' || to != ''){
                schedarr_temp = {
                    'fromtime'  :from,
                    'totime'    :to,
                    'tardy'    :tardy,
                    'absent'    :absent
                };
                schedarr.push(schedarr_temp);
            }
        });
    }
    
    function pastetime(obj){
        var schedarr_orig       = [],
        schedarr_orig_temp  = [];
        $('tr[dayofweek='+obj.attr('dayofweek')+']').each(function(){
            var from          = $(this).find("input[name='fromtime']").val();
            var to            = $(this).find("input[name='totime']").val();
            var tardy            = $(this).find("input[name='tardy']").val();
            var absent            = $(this).find("input[name='absent']").val();

            if(from != '' || to != ''){
                schedarr_orig_temp = {
                    'fromtime'  :from,
                    'totime'    :to,
                    'tardy'    :tardy,
                    'absent'    :absent
                };
                schedarr_orig.push(schedarr_orig_temp);
            }
            $(this).find("button[tag=delete_sched]").click();
        });

        if(schedarr_orig.length == 0){
            if(schedarr.length > 0){
                obj.find("input[name='fromtime']").val(schedarr[0]['fromtime']);
                obj.find("input[name='totime']").val(schedarr[0]['totime']);
                obj.find("input[name='tardy']").val(schedarr[0]['tardy']);
                obj.find("input[name='absent']").val(schedarr[0]['absent']);
                
                if(schedarr.length > 1){
                    for (var i = schedarr.length - 1; i >= 1; i--) {
                        console.log(obj);
                        $(obj).find("button[tag=add_sched]").click();
                        $(obj).next(':first').find("input[name='fromtime']").val(schedarr[i]['fromtime']);
                        $(obj).next(':first').find("input[name='totime']").val(schedarr[i]['totime']);
                        $(obj).next(':first').find("input[name='tardy']").val(schedarr[i]['tardy']);
                        $(obj).next(':first').find("input[name='absent']").val(schedarr[i]['absent']);
                    }
                }
            }
        }else if(schedarr_orig.length > 0){
            if(schedarr.length > 0){
                for (var i = schedarr.length - 1; i >= 0; i--) {
                    $(obj).find("button[tag=add_sched]").click();
                    $(obj).next(':first').find("input[name='fromtime']").val(schedarr[i]['fromtime']);
                    $(obj).next(':first').find("input[name='totime']").val(schedarr[i]['totime']);
                    $(obj).next(':first').find("input[name='tardy']").val(schedarr[i]['tardy']);
                    $(obj).next(':first').find("input[name='absent']").val(schedarr[i]['absent']);
                }
            }
        }
        
        if(schedarr_orig.length == 1){
            obj.find("input[name='fromtime']").val(schedarr_orig[0]['fromtime']);
            obj.find("input[name='totime']").val(schedarr_orig[0]['totime']);
            obj.find("input[name='tardy']").val(schedarr_orig[0]['tardy']);
            obj.find("input[name='absent']").val(schedarr_orig[0]['absent']);
        }
        
        if(schedarr_orig.length > 1){
            for (var i = schedarr_orig.length - 1; i > 0; i--) {
                $(obj).find("button[tag=add_sched]").click();
                $(obj).next(':first').find("input[name='fromtime']").val(schedarr_orig[i]['fromtime']);
                $(obj).next(':first').find("input[name='totime']").val(schedarr_orig[i]['totime']);
                $(obj).next(':first').find("input[name='tardy']").val(schedarr_orig[i]['tardy']);
                $(obj).next(':first').find("input[name='absent']").val(schedarr_orig[i]['absent']);
            }
        }
        
        copytime(obj);
    }
    
    $("button[tag='edit_erase_time']").click(function(){
        var tr_id = $(this).closest("tr").attr("dayofweek");
        $("tr[dayofweek='"+ tr_id +"']").find(".ftime").val('');
        $("tr[dayofweek='"+ tr_id +"']").find(".totime").val('');
        $("tr[dayofweek='"+ tr_id +"']").find(".tardy").val('');
        $("tr[dayofweek='"+ tr_id +"']").find(".absent").val('');
    });
    
    $("button[tag='delete_sched']").click(function(){
        var obj = $(this).parent().parent().parent().remove();  
    });
    
    $("button[tag='add_sched']").click(function(){
        var obj = $(this).parent().parent().parent().clone(true);
        
        var delete_button = $('<button type="button" class="btn btn-info" tag="delete_sched"><i class="bi bi-clipboard2-x"></i>Remove</button>').click(function(){
            $(this).parent().parent().parent().remove();  
        });
        var timefrom_picker = $('<div class="input-group"><input  type="text" class="form-control ftime" name="fromtime"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i></span></div>');

        var timeto_picker = $('<div class="input-group"><input  type="text" class="form-control totime" name="totime"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i></span></div>');

        var tardy_picker = $('<div class="input-group"><input  type="text" class="form-control tardy" name="tardy"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i></span></div>');

        var absent_picker = $('<div class="input-group"><input  type="text" class="form-control absent" name="absent"/> <span class="input-group-text" data-td-toggle="datetimepicker" > <i class="bi bi-calendar-fill"></i></span></div>');
        
        $(obj).find("td:first").find("div:first").html("");
        $(obj).find("td:eq(0)").find("div:first").html($(delete_button));
        $(obj).find("td:eq(1)").find("div:first").html(""); 
        
        $(obj).find("td:eq(2)").find("div:first").html(""); 
        $(obj).find("td:eq(2)").find("div:first").append($(timefrom_picker)); 
        
        $(obj).find("td:eq(3)").find("div:first").html(""); 
        $(obj).find("td:eq(3)").find("div:first").append($(timeto_picker));

        $(obj).find("td:eq(4)").find("div:first").html(""); 
        $(obj).find("td:eq(4)").find("div:first").append($(tardy_picker));

        $(obj).find("td:eq(5)").find("div:first").html(""); 
        $(obj).find("td:eq(5)").find("div:first").append($(absent_picker));
        
        $(obj).find("input[name='fromtime'],input[name='totime'],input[name='tardy'],input[name='absent").tempusDominus({
            localization: {
            locale: 'en-US',
            format: 'hh:mm T',
            },
            display: {
                viewMode: 'clock',
                buttons: {
                    close: true,
                },
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
        
        $(obj).insertAfter($(this).parent().parent().parent());   
        $(obj).find("input[name='fromtime']").focus();
    });
    
</script>