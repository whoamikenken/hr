
<thead>
    <tr>
        <th class="text-center">Action</th>
        <th class="text-center">Name</th>
        <th class="text-center">Employee ID</th>
        <th class="text-center">Date Time</th>
        <th class="text-center">IP</th>
        <th class="text-center">Device Type</th>
        <th class="text-center">Image</th>
    </tr>
</thead>
<tbody>
@foreach ($result as $key => $item)
    <tr class="align-center text-center">
        <td class="align-center">
           <a id="{{ $item->id }}" class="btn btn-info viewbtn" href="#modal-view"><i class="bi bi-eye"></i> View Location</a>
        </td>
        <td>{{$item->name}}</td>
        <td>{{$item->employee_id}}</td>
        <td>{{$item->log_time}}</td>
        <td>{{$item->ip}}</td>
        <td>{{$item->machine_type}}</td>
        <td>
            <img src="{{  Storage::disk("s3")->url($item->image)}}" class="img-fluid user_photo_list m-2" alt="..." style="height: -webkit-fill-available;">
        </td>
    </tr>
@endforeach
</tbody>