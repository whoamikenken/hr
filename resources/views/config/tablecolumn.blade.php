@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Setup Column Picker</h1>
</div>
<div class="card shadow animate__animated animate__fadeInRight">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-5">
                {{-- <a href="javascript:void(0);" class="btn btn-primary mb-2 addbtn"><i class="bi bi-plus-circle"></i> Add Table Picker</a> --}}
            </div>
            <div class="col-sm-7">
                <div class="text-sm-end">
                    {{-- <button type="button" class="btn btn-secondary mb-2"><i class="bi bi-printer"></i> Print</button> --}}
                </div>
            </div><!-- end col-->
        </div>
        
        <div class="table-responsive">
            <table id="TablecolumnTable" class="table table-hover table-responsive">
            <thead>
                <tr >
                    <th class="text-center">Action</th>
                    <th class="text-center">Description</th>
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

        TablecolumnList();

        var bar = getBase64FromUrl('{{asset("icon/ms-icon-150x150.png")}}');
        
        bar.then((result) => {
            logo = result;
            // do whatever you want to do with result
        }).catch(err=>console.log(err))
    });

    function TablecolumnList(){

        if(tableObj!=null){
            tableObj.destroy();
        }

        $.ajax({
            type: "POST",
            url: "{{ url('tablecolumn/table')}}",
            data: {},
            async: false,
            success:function(response){
                $("#tableData").html(response);
                tableObj = $("#TablecolumnTable").DataTable({
                    // responsive: true
                });
                tableObj.draw();
            }
        });
    }

    $("#TablecolumnTable").on("click", ".editbtn", function() {
        var uid = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "{{ url('tablecolumn/getModal')}}",
            data: {
                uid: uid
            },
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text("Edit Table Picker");
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

</script>
@endsection
