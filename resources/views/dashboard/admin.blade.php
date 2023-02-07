<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df!important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc!important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e!important;
    }
    .border-left-danger {
        border-left: 0.25rem solid #f80101!important;
    }
    .border-left-success {
        border-left: 0.25rem solid #18ff5d!important;
    }
</style>
@if (Auth::user()->user_type == "Admin")
    <div class="row animate__animated animate__backInRight">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Registered Employee {{ date("F")}}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employee_month}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employee_count}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Present Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employee_present}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Absent Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employee_absent}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi-person-exclamation
    fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
@endif
@if (Auth::user()->user_type == "Admin")
    <div class="row animate__animated animate__fadeInRight">
        <div class="col-sm-12 col-md-12 col-xl-8">
            <div class="card mb-4">
                <div class="card-header bg-info">
                    <i class="bi bi-bar-chart-line-fill me-1"></i>
                    Employement Performance Chart
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center" id="performanceLoader">
                        <div class="spinner-border text-info" role="status" style="width: 8rem; height: 8rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <canvas id="myBarChart" width="100%" height="47"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-xl-4 animate__animated animate__backInRight">
            <div class="card mb-4">
                <div class="card-header bg-info">
                    <i class="bi bi-pie-chart-fill me-1"></i>
                    Offices
                </div>
                <div class="card-body"><canvas id="pieChartBranch" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>
@endif


<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-header bg-info">
                <i class="bi bi-award-fill me-1"></i>
                Announcement  {{ date("F")}}
            </div>
            <div class="card-body">
                <div class="row animate__animated animate__fadeInUp">
                    @unless (count($announcement) == 0)
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($announcement as $item)
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card text-center" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{$item->title}}</h5>
                                    <p class="card-text">{{$item->description}}</p>
                                    <button class="btn btn-primary viewAnnouncement" uid="{{$item->id}}" title="{{$item->title}}">View</button>
                                </div>
                            </div>
                        </div>
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                @else
                        <h2 class="text-center">No Announcement</h2>
                @endunless
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="performanceBar">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-header bg-info">
                <i class="bi bi-award-fill me-1"></i>
                Top Performing Employee Of  {{ date("F")}}
            </div>
            <div class="card-body">
                <div class="row animate__animated animate__fadeInUp">
                    @unless (count($top_employee) == 0)
                    @php
                        $counter = 1;
                    @endphp
                    @foreach ($top_employee as $item)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card mb-3 shadow" >
                                <div class="row g-0">
                                    <div class="col-4">
                                        @if ($item->user_image)
                                            <img src="{{  Storage::disk('s3')->url($item->user_image)}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s m-2" alt="..." style="height: -webkit-fill-available;" width="120" height="123">
                                        @else
                                            @if ($item->gender == "male")
                                                <img src="{{ asset('images/male_sales.png')}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s" alt="..." width="120" height="123">
                                            @elseif ($item->gender == "female")
                                                <img src="{{ asset('images/female_sales.png')}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s" alt="..." width="120" height="123">
                                            @else
                                                <img src="{{ asset('images/user.png')}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s" alt="..." width="120" height="123"> 
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$item->fname." ".$item->lname}} <span class="float-end">{{$counter}}</span></h5>
                                            Department: {{$item->department}}<br>
                                            Office: {{$item->office}}<br>
                                            Work Tasks: {{$item->total_att}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                @else
                        <h2 class="text-center">No Data</h2>
                @endunless
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
let delayed;

    $(document).ready(function () {
        $("#modal-view").find(".modal-dialog").removeClass("modal-lg").addClass("modal-fullscreen");
        $("#modal-view").find("#saveModal").hide();
        getOfficeEmployee();
        getPerformancePerMonth();
    });

    $(window).scroll(function () {
        if ($('#performanceBar').isOnScreen()) {
            $("#performanceBar").addClass("animate__animated animate__fadeInRight");
        } else {
            $("#performanceBar").removeClass("animate__animated animate__fadeInRight");
        }
    });

    $(".viewAnnouncement").click(function () {
        var uid = $(this).attr("uid");
        var title = $(this).attr("title");
        $.ajax({
            url: "{{ url('announcement/view') }}",
            type: "POST",
            data: {id:uid},
            success: function(response) {
                $("#modal-view").modal('toggle');
                $("#modal-view").find(".modal-title").text(title);
                $("#modal-view").find("#modal-display").html(response);
            }
        });
    });

    function getOfficeEmployee(){
        $.ajax({
            type: "GET",
            url: "{{ url('dashboard/getOfficePie')}}",
            data: {},
            dataType: "json",
            success:function(response){
                const config = {
                    type: 'pie',
                    data: {
                        labels: response.dataset.label,
                        datasets: [{
                        label: "Offices",
                        backgroundColor: response.dataset.backgroundColor,
                        data: response.dataset.data,
                        }],
                    },
                    options: {
                    responsive: true,
                    plugins: {
                      legend: {
                        position: 'top',
                      },
                      title: {
                        display: true,
                        text: 'Offices'
                      }
                    }
                  }
                };

                const myChart = new Chart(
                    document.getElementById('pieChartBranch'),
                    config
                );
            }
        });
    }

    function getPerformancePerMonth(){
        $.ajax({
            type: "GET",
            url: "{{ url('dashboard/getPerformanceMontly')}}",
            data: {},
            dataType: "json",
            success:function(response){
                $("#performanceLoader").remove();
                const config = {
                    type: 'bar',
                    data: {
                        labels: JSON.parse(response.month),
                        datasets: [
                            {
                            label: "Employee",
                            backgroundColor: "rgb(0,255,255)",
                            borderColor: "rgb(0, 0, 0)",
                            data: JSON.parse(response.employee.data),
                            borderRadius: 5,
                            borderWidth: 2,
                            }
                        ],
                    },
                    options: {
                        animation: {
                            onComplete: () => {
                                delayed = true;
                            },
                            delay: (context) => {
                                let delay = 0;
                                if (context.type === 'data' && context.mode === 'default' && !delayed) {
                                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                                }
                                return delay;
                            },
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Performance Chart'
                            },
                        },
                        responsive: true,
                        scales: {
                            x: {
                                // stacked: true,
                            },
                            y: {
                                // stacked: true
                            }
                        }
                    },
                };

                const myChart = new Chart(
                    document.getElementById('myBarChart'),
                    config
                );

            }
        });
    }

</script>