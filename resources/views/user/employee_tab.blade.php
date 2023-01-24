<input type="hidden" type="text" id="uid" value="{{$uid}}">
<ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
    @if (in_array("803",$readAccess))
       <li class="nav-item" role="presentation">
            <button class="nav-link active" link="{{ url('employee/profile') }}" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</button>
        </li> 
    @endif
    @if (in_array("804",$readAccess))
       <li class="nav-item" role="presentation">
            <button class="nav-link" link="{{ url('employee/schedule') }}" id="pills-schedule-tab" data-bs-toggle="pill" data-bs-target="#pills-schedule" type="button" role="tab" aria-controls="pills-schedule" aria-selected="true">Schedule</button>
        </li> 
    @endif
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        
    </div>

    <div class="tab-pane fade show" id="pills-schedule" role="tabpanel" aria-labelledby="pills-schedule-tab">
        
    </div>
</div>
<div class="visually-hidden">
<form id="profileForm" enctype="multipart/form-data">
@csrf
<input type="hidden" name="employee_id" value="{{$uid}}">
</form>
</div>
<script>
    
    $(document).ready(function () {
        $("#pills-profile-tab").click();
    });

    $("#pills-tab").on("click",".nav-link",function(){
        var link = $(this).attr('link');
        $.ajax({
            type: "POST",
            url: link,
            data: {
                uid: $("#uid").val()
            },
            success: function(response) {
                setTimeout(() => {
                    $("#pills-tabContent").find(".active").html(response);
                }, 500);
            }
        });
    })

    const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })

    function saveSingleProfileColumn(tags){
        $("#column").remove();
        $("#columnVal").remove();
        if(tags.attr("type") != "file"){
            if(tags.val()){
                $("<input type='text'/>")
                .attr("name", "column")
                .attr("id", "column")
                .attr("value", tags.attr("name"))
                .prependTo("#profileForm");

                $("<input type='text'/>")
                .attr("name", "value")
                .attr("id", "columnVal")
                .attr("value", tags.val())
                .prependTo("#profileForm");

                var formdata = $("#profileForm").serialize();

                $.ajax({
                    url : "{{ url('employee/store') }}",
                    type : "POST",
                    data : formdata,
                    dataType: "JSON",
                    success : function(response){
                        console.log(response);
                        if (response.status == 1) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Updated'
                            });
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: 'Error please contact HR/AMS Team.'
                            });
                        }
                    }
                });
            }
        }else{
            $("<input type='text'/>")
            .attr("name", "column")
            .attr("id", "column")
            .attr("value", tags.attr("name"))
            .prependTo("#profileForm");

            $("<input type='text'/>")
            .attr("name", "value")
            .attr("id", "columnVal")
            .attr("value", "file")
            .prependTo("#profileForm");

            var formdata = processForm($("#profileForm"));

            var user_file = tags[0].files[0];
            formdata.append("file", user_file);

            $.ajax({
                url : "{{ url('employee/store') }}",
                type : "POST",
                data : formdata,
                cache:false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success : function(response){
                    if (response.status == 1) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated'
                        });

                        setTimeout(() => {
                            $("#pills-tab").find(".active").click();
                        }, 2000);
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Error.'
                        });
                    }
                }
            });
        }
        
    }

</script>