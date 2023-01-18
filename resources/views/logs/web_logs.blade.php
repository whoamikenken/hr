@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Employee Logs</h1>
</div>
<div class="card shadow animate__animated animate__fadeInRight">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-5">
                {{-- <a href="javascript:void(0);" class="btn btn-primary mb-2 addbtn"><i class="bi bi-plus-circle"></i> Add Employee Logs</a> --}}
            </div>
            <div class="col-sm-7">
                <div class="text-sm-end">
                </div>
            </div><!-- end col-->
        </div>
        
            <div class="table-responsive">
                <table id="webLogs" class="table table-hover table-responsive">
                </table>
            </div>
            
    </div> <!-- end card-body-->
</div>


<script>
    var logo;
    var tableObj = null;

    
    $(document).ready(function () {

        WebLogsList();

        var bar = getBase64FromUrl('{{Session::get('agency_logo')}}');
        
        bar.then((result) => {
            resizeImage = resizeImage(result, 150, 150);
            resizeImage.then((resultBase64) => {
                logo = resultBase64;
            }).catch(err=>console.log(err))
            // do whatever you want to do with result
        }).catch(err=>console.log(err))
    });

    

    function WebLogsList(){

        if(tableObj!=null){
            tableObj.destroy();
        }

        $.ajax({
            type: "POST",
            url: "{{ url('logs/table')}}",
            data: {},
            async: false,
            success:function(response){
                $("#webLogs").html(response);
                // Count TH
                var rowCount = $('#webLogs th').length - 1;
                var thCount = Array.from({length: rowCount}, (_, i) => i + 1);
                tableObj = $("#webLogs").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                    {
                        extend: 'pdfHtml5',
                        text:'Export PDF',
                        title: 'Employee Logs List',
                        orientation:'landscape',
                        exportOptions: {
                            columns: thCount
                        },
                        customize: function ( doc ) {
                            var colCount = new Array();
                            $("#webLogs").find('tbody tr:first-child td').each(function(){
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
                        title: 'Employee Logs List',
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
            url: "{{ url('logs/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Add Employee Logs");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    $("#webLogs").on("click", ".viewbtn", function() {
        var uid = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: "{{ url('logs/getModal')}}",
            data: {
                uid: uid,
                mode:"view"
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("View Employee Logs");
                $("#modal-view").find("#saveModal").remove();
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

</script>
@endsection
