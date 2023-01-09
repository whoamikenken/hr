@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Work Request</h1>
</div>
<div class="card shadow animate__animated animate__fadeInRight">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-5">
                <a href="javascript:void(0);" class="btn btn-primary mb-2 addbtn"><i class="bi bi-plus-circle"></i> Add Work Request</a>
            </div>
            <div class="col-sm-7">
                <div class="text-sm-end">
                </div>
            </div><!-- end col-->
        </div>
        
            <div class="table-responsive">
                <table id="WFHTable" class="table table-hover table-responsive">
                </table>
            </div>
            
    </div> <!-- end card-body-->
</div>

<script>
    var logo;
    var tableObj = null;

    
    $(document).ready(function () {

        WFHList();

        var bar = getBase64FromUrl('{{Session::get('agency_logo')}}');
        
        bar.then((result) => {
            resizeImage = resizeImage(result, 150, 150);
            resizeImage.then((resultBase64) => {
                logo = resultBase64;
            }).catch(err=>console.log(err))
            // do whatever you want to do with result
        }).catch(err=>console.log(err))
    });

    

    function WFHList(){

        if(tableObj!=null){
            tableObj.destroy();
        }

        $.ajax({
            type: "POST",
            url: "{{ url('wfh/table')}}",
            data: {},
            async: false,
            success:function(response){
                $("#WFHTable").html(response);
                // Count TH
                var rowCount = $('#WFHTable th').length - 1;
                var thCount = Array.from({length: rowCount}, (_, i) => i + 1);
                tableObj = $("#WFHTable").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'pdfHtml5',
                        text:'Export PDF',
                        title: 'Work Request List',
                        orientation:'landscape',
                        exportOptions: {
                            columns: thCount
                        },
                        customize: function ( doc ) {
                            var colCount = new Array();
                            $("#WFHTable").find('tbody tr:first-child td').each(function(){
                                if($(this).attr('colspan')){
                                    for(var i=1;i<=$(this).attr('colspan');$i++){
                                        colCount.push('*');
                                    }
                                }else{ 
                                    colCount.push('*'); 
                                }
                            });
                            doc.defaultStyle.alignment = 'center';
                            colCount = colCount.shift();
                            doc.content[1].table.widths = colCount;
                            
                            doc.content.splice( 1, 0, {
                                margin: [ 0, 0, 0, 12 ],
                                alignment: 'center',
                                image: logo
                            } );
                        }
                    },
                    {
                        text:'Export Excel',
                        extend: 'excelHtml5',
                        title: 'Work Request List',
                        exportOptions: {
                            columns: thCount
                        }
                    }
                    ]
                    // responsive: true
                });
                tableObj.draw();
            }
        });
    }

    $(".addbtn").click(function() {
        var uid = "add";
        $.ajax({
            type: "POST",
            url: "{{ url('wfh/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Add Claim");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    $("#WFHTable").on("click", ".editbtn", function() {
        var uid = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "{{ url('wfh/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Edit Claim");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    $("#WFHTable").on("click", ".viewbtn", function() {
        var uid = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: "{{ url('wfh/getModal')}}",
            data: {
                uid: uid,
                mode:"view"
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("View Claim");
                $("#modal-view").find("#saveModal").remove();
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
                    url: "{{ url('wfh/delete')}}",
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
