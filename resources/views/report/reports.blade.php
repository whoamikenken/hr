@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">System Reports</h1>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
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
                                <p class="mb-1">Print All Applicant Info.</p>
                            </div>
                            <div class="col-sm-12 col-md-4 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-printer"></i>
                            </div>
                        </div>
                    </a>
                    @if (in_array("999", $readAccess))
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="costbreakdown" report="Cost Breakdown Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Cost Report</h5>
                                </div>
                                <p class="mb-1">Pring All Applicant Cost.</p>
                            </div>
                            <div class="col-sm-12 col-md-4 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-printer"></i>
                            </div>
                        </div>
                    </a>
                    @endif
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="infosheet" report="Information Sheet" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Infosheet</h5>
                                </div>
                                <p class="mb-1">Print applicant infosheet</p>
                            </div>
                            <div class="col-sm-12 col-md-4 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-printer"></i>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="lacking" report="Document Lacking List Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Lacking Document List</h5>
                                </div>
                                <p class="mb-1">List of applicant that lacks documents and certificate.</p>
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
    <div class="col-sm-12 col-md-6">
        <div class="card shadow animate__animated animate__fadeInRight">
            <div class="card-header bg-info text-white text-center fs-3 fw-bold">
                System Reports
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="departure" report="Departure List Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Departure List</h5>
                                </div>
                                <p class="mb-1">List of applicant departure.</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-airplane-engines"></i>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="expiration" report="Expiration List Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Expiration List</h5>
                                </div>
                                <p class="mb-1">Applicant Passport/Visa expired.</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-bookmark-x"></i>
                            </div>
                        </div>
                    </a>
                    {{-- <a href="#" class="list-group-item list-group-item-action printReport" tag="performance" report="Branch Performance Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Branch Performance Report</h5>
                                </div>
                                <p class="mb-1">Print Branch Performance</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-building"></i>
                            </div>
                        </div>
                    </a> --}}
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="termination" report="Applicant Termination Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Termination Report</h5>
                                </div>
                                <p class="mb-1">Print Applicant Termination</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-person-x"></i>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="deployment" report="Applicant Deployment Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Deployment Report</h5>
                                </div>
                                <p class="mb-1">Print Applicant Deployment</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-person-check"></i>  
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="joborder" report="Job Order Status Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Job Order Status Report</h5>
                                </div>
                                <p class="mb-1">Print Job Order Status</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-person-badge"></i>  
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action printReport" tag="biodata" report="Biodata Report" aria-current="true">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Biodata Report</h5>
                                </div>
                                <p class="mb-1">Print Biodata Report</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-end d-sm-none d-md-block fs-2">
                                <i class="bi bi-folder-symlink"></i>  
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
        $("#saveModal").text("Print");
    });

    
    $(document).on("click", ".printReport", function() {
        var tag = $(this).attr('tag');
        var reportName = $(this).attr('report');
        $.ajax({
            type: "POST",
            url: "{{ url('report/getModalFilter')}}",
            data: {tag:tag, reportName:reportName},
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text(reportName);
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

</script>
@endsection
