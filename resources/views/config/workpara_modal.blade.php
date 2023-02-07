<form id="workPara" class="row g-2 needs-validation" novalidate>
    @csrf
    <input type="hidden" name="uid" value="{{$uid}}">
    <div class="col-md-12 col-sm-12">
        <label>Description<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-bookmark-star"></i></div>
            <input type="text" id="description" name="description" class="form-control" value="{{ (isset($description))? $description:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input purpose.
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <label>Latitude<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pin-map"></i></div>
            <input type="text" id="latitude" name="latitude" class="form-control" value="{{ (isset($latitude))? $latitude:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input latitude.
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <label>Longitude<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-text"><i class="bi bi-pin-map"></i></div>
            <input type="text" id="longitude" name="longitude" class="form-control" value="{{ (isset($longitude))? $longitude:"" }}">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please input longitude.
            </div>
        </div>
    </div>
</form>
<script>
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#workPara"));
        
        var formdata = $("#workPara").serialize();

        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('workpara/add') }}",
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
                    WorkParaList();
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