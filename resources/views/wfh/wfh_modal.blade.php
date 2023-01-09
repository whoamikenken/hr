@php
    $mode = ($mode == "true")? "disabled":"";
@endphp
<form id="WFHForm" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{($uid)}}">
    <div class="col-md-6 col-sm-12">
        <label>Purpose<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-file-earmark-minus"></i></div>
            <input type="text" id="purpose" name="purpose" class="form-control" value="{{ (isset($purpose))? $purpose:"" }}" {{$mode}}>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input purpose.
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <label>Date<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-calendar2-check"></i></div>
            <input type="text" id="date" name="date" class="form-control datepicker" value="{{ (isset($date))? $date:date("Y-m-d") }}" {{$mode}}>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input Work Done.
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <label>Work Done<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-card-text"></i></div>
                <textarea class="form-control" placeholder="Work done" id="work_done" name="work_done" style="height: 100px" {{$mode}}>{{ (isset($work_done))? $work_done:""}}</textarea>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input Work Done.
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12">
        <label style="font-weight:600">Upload Work Document</label>
        <div class="input-group custom-file-button">
            <label class="input-group-text" for="payment_doc"><i class="bi bi-file-earmark-text"></i>&nbsp;&nbsp;{{(isset($accomplishment_file) && $accomplishment_file != "")? "Replace":"Upload"}} Detail</label>
            <input type="file" class="form-control form-control-sm" id="accomplishment_file" name="accomplishment_file">
        </div>
    </div>
    @if (isset($accomplishment_file) && $accomplishment_file != "")
        <div class="col-lg-6 col-sm-12">
            <label style="font-weight:600">Payment Details</label>
            <div class="input-group">
                <a class="btn btn-info text-white" target="_blank" href="{{  Storage::url($accomplishment_file)}}"><i class="bi bi-eye"></i> View</a>
            </div>
        </div>
    @endif
</form>

<script>
    
    $(document).ready(function () {

        $(".datepicker").tempusDominus({
            localization: {
            locale: 'en-US',
            format: 'yyyy-MM-dd',
            },
            display: {
                buttons: {
                    close: true,
                },
                components: {
                    decades: false,
                    year: false,
                    month: false,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false
                }
            }
        });

        $('.form-select').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modal-view .modal-body')
        });
    });
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#WFHForm"));

        var formdata = processForm($("#WFHForm"));

        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('wfh/add') }}",
            type: "POST",
            data: formdata,
            ache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: response.title,
                        text: response.msg,
                        timer: 1500
                    })
                    $("#modalclose").click();
                    WFHList();
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