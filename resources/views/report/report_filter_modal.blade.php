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
        <label style="font-weight:600">Branch</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="branch" id="branch" class="form-select">
                <option value="" selected>All Branch</option>
                @foreach ($branch_select as $item)
                <option value="{{$item->code}}" >{{$item->description}}</option>
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
    <div class="col-md-6 col-sm-12">
        <label style="font-weight:600">Jobsite</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="jobsite" id="jobsite" class="form-select">
                <option value="" selected>All Jobsite</option>
                @foreach ($jobsite_select as $item)
                <option value="{{$item->code}}" >{{$item->description}}</option>
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
    <div class="col-md-6 col-sm-12" {{ $hidden }}>
        <label style="font-weight:600">Sales</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="sales" id="sales" class="form-select">
                <option value="" selected>All Sales</option>
                @foreach ($users_select as $item)
                <option value="{{$item->id}}" >{{$item->lname." ".$item->fname}}</option>
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
    <div class="col-md-6 col-sm-12" {{ $hidden }}>
        <label style="font-weight:600">Applicant</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="applicant_id" id="applicant_id" class="form-select">
                <option value="" selected> {{($tag == "infosheet")? "Select":"All"}} Applicant</option>
                @foreach ($applicant_select as $item)
                <option value="{{$item->applicant_id}}" >{{$item->lname." ".$item->fname}}</option>
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
    <div class="col-md-6 col-sm-12">
        <label style="font-weight:600">Biodata Availability</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="bio_availability" id="bio_availability" class="form-control form-select">
                <option value="" >All</option>
                <option value="Sold" >Sold</option>
                <option value="Available" >Available</option>
                <option value="Signed Up" >Signed Up</option>
                <option value="Pending" >Pending</option>
                <option value="Backed out" >Backed out</option>
                <option value="Resell/Push" >Resell/Push</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input.
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <label style="font-weight:600">Account Status</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-person-check"></i></div>
            <select name="isactive" id="isactive" class="form-control form-select">
                <option value="" >All</option>
                <option value="Active">Active</option>
                <option value="Inactive" {{($tag == "termination")? "selected":""}}>Terminated</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input.
            </div>
        </div>
    </div>
    @if ($tag == "hrreport" || $tag == "infosheet")
    <hr class="mt-4">
    <br>
    <h4 class="text-center p-1">Select Data</h4>
    @php
    echo $showColumn;
    @endphp
    <input type="hidden" name="edatalist" id="edatalist">
    @elseif ($tag == "departure" || $tag == "deployment")
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
    @elseif ($tag == "expiration")
    <div class="col-sm-12">
        <label style="font-weight:600">Type</label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-option"></i></div>
            <select name="edatalist" id="edatalist" class="form-control form-select">
                <option value="all" >All</option>
                <option value="Visa">Visa Expiration</option>
                <option value="Passport">Passport Expiration</option>
            </select>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input.
            </div>
        </div>
    </div>
    @else
    
    @endif
</form>

<script>
    
    $(document).ready(function () {
        
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        
        $('.form-select').select2({
            dropdownParent: $('#modal-view'),
            theme: 'bootstrap-5'
        });
        
    });
    
    $("#saveModal").unbind("click").click(function(){
        if($("#tag").val() == "hrreport" || $("#tag").val() == "infosheet"){
            var edata = $("input[name=edata]:checked").map(function () {return this.value;}).get().join(","); 
            $("#edatalist").val(edata);
        }

        if($("#tag").val() == "infosheet"){
            if($("#applicant_id").val() == ""){
                Swal.fire({
                    icon: 'info',
                    title: "Please Select An Applicant",
                    // text: "Please contact developer."
                })
                return false;
            }
        }
        jQuery('#reportForm').submit();
    });
    
</script>