<div class="row animate__animated animate__fadeInUp" id="pagination_data">
    @unless (count($result) == 0)
    @foreach ($result as $item)
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card mb-3 shadow-sm" >
            <div class="row g-0">
                <div class="col-4">
                    @if ($item->user_profile)
                    <img src="{{  Storage::disk("s3")->url($item->user_profile)}}" id="{{$item->employee_id}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s m-2" alt="..." style="height: -webkit-fill-available;">
                    @else
                    <img src="{{ asset('images/user.png')}}" class="img-fluid user_photo_list rounded animate__animated animate__fadeIn animate__delay-1s" alt="...">
                    @endif
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->fname." ".$item->lname}}</h5>
                        <p>Department: {{$item->department}}<br>
                            Office: {{$item->office}}<br>
                            Email: {{$item->email}}<br>
                            Status: <span style="color:{{ ($item->isactive == "Active") ? "green":"red"  }}">{{$item->isactive}}</span><br>
                            Contact #: <span>{{$item->contact}}</span></p>
                            <button class="btn btn-info text-white employeeView" uid="{{$item->employee_id}}"><i class="bi bi-eye"></i>&nbsp;&nbsp;View</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <h2 class="text-center">No Employee</h2>
        @endunless
    </div>
    
    <div id="paginationEmployee" class="justify-content-center">
        {{ $result->links() }}
    </div>
    