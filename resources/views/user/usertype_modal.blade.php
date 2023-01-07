<form id="usertypeForm" class="row g-2 needs-validation" novalidate>
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
    <input type="hidden" name="edatalistRead" id="edatalistRead">
    <input type="hidden" name="edatalistAdd" id="edatalistAdd">
    <input type="hidden" name="edatalistEdit" id="edatalistEdit">
    <input type="hidden" name="edatalistDel" id="edatalistDel">
</form>
    <hr>
    <h2 class="text-center">System Access</h2>
    <hr>
    @php
        echo $showAccess;
    @endphp
<script>
    
    $("#saveModal").unbind("click").click(function() {
        bootstrapForm($("#usertypeForm"));

        var rAccess = $("input[name=rAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistRead").val(rAccess);

        var aAccess = $("input[name=aAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistAdd").val(aAccess);

        var eAccess = $("input[name=eAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistEdit").val(eAccess);

        var dAccess = $("input[name=dAccess]:checked").map(function () {return this.value;}).get().join(","); 
        $("#edatalistDel").val(dAccess);
        
        var formdata = $("#usertypeForm").serialize();
        
        swal.fire({
            html: '<h4>Loading...</h4>',
            didRender: function() {
                $('#swal2-html-container').prepend(sweet_loader);
            }
        });

        $.ajax({
            url: "{{ url('usertype/add') }}",
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
                    UsertypeList();
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