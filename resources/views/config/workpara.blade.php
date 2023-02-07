@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Work Parameter</h1>
</div>
<div class="card shadow animate__animated animate__fadeInRight">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-5">
                <a href="javascript:void(0);" class="btn btn-primary mb-2 addbtn"><i class="bi bi-plus-circle"></i> Add Work Parameter</a>
            </div>
            <div class="col-sm-7">
                <div class="text-sm-end">
                    {{-- <button type="button" class="btn btn-secondary mb-2"><i class="bi bi-printer"></i> Print</button> --}}
                </div>
            </div><!-- end col-->
        </div>
        
        <div class="table-responsive">
            <table id="WorkParaTable" class="table table-hover table-responsive">
            <thead>
                <tr >
                    <th class="text-center">Action</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Latitude</th>
                    <th class="text-center">Longitude</th>
                    <th class="text-center">Modified On</th>
                    <th class="text-center">Created On</th>
                </tr>
            </thead>
            <tbody id="tableData">
            </tbody>
        </table>
        </div>
    </div> <!-- end card-body-->
</div>

<script>
    var logo;
    var tableObj = null;

    
    $(document).ready(function () {

        WorkParaList();

        var bar = getBase64FromUrl('{{asset("icon/ms-icon-150x150.png")}}');
        
        bar.then((result) => {
            logo = result;
            // do whatever you want to do with result
        }).catch(err=>console.log(err))
    });

    function WorkParaList(){

        if(tableObj!=null){
            tableObj.destroy();
        }

        $.ajax({
            type: "POST",
            url: "{{ url('workpara/table')}}",
            data: {},
            async: false,
            success:function(response){
                $("#tableData").html(response);
                tableObj = $("#WorkParaTable").DataTable({
                });
                tableObj.draw();
            }
        });
    }

    $(".addbtn").click(function() {
        var uid = "add";
        $.ajax({
            type: "POST",
            url: "{{ url('workpara/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Add Work Parameter");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    $("#WorkParaTable").on("click", ".editbtn", function() {
        var uid = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "{{ url('workpara/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Edit Work Parameter");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    $("#WFHTable").on("click", ".delbtn", function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {

                var code = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('workpara/delete')}}",
                    dataType: 'json',
                    data: {
                        code: code,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: response.title,
                                text: response.msg,
                                timer: 1500
                            })

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

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Data is safe.',
                    'error'
                )
            }
        })
    });

</script>
@endsection
