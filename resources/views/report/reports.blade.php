@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">System Reports</h1>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card shadow animate__animated animate__fadeInRight">
            <div class="card-header bg-primary text-white text-center fs-3 fw-bold">
                HR Reports
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="hrreport" report="Master List Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Master List Report</h5>
                                </div>
                                <p class="mb-1">Print All Employee Info.</p>
                            </div>
                            <div class="col-sm-12 col-md-4 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-printer"></i>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="attendance" report="Attendance Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Attendance</h5>
                                </div>
                                <p class="mb-1">List of employee attendance.</p>
                            </div>
                            <div class="col-sm-12 col-md-4 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-paperclip"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        
    });

    
    $(document).on("click", ".printReport", function() {
        var tag = $(this).attr('tag');
        var reportName = $(this).attr('report');
        $.ajax({
            type: "POST",
            url: "{{ url('report/getModalFilter')}}",
            data: {tag:tag, reportName:reportName},
            success: function(response) {
                $("#saveModal").text("Print");
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text(reportName);
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

</script>
@endsection
