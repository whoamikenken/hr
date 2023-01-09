
<thead>
    <tr>
        <th class="text-center">Action</th>
        @foreach ($columns as $dt => $title)
            <th class="text-center" data-priority="1">{{$title['title']}}</th>
        @endforeach
        <th>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="selectall" >
                <label class="form-check-label" for="flexCheckDefault">
                    Mark All Read
                </label>
            </div>
        </th>
    </tr>
</thead>
<tbody>
@foreach ($result as $key => $item)
@php
    $isread = "";
    if($item->read_employee == 0){
        $isread = "#93e3e3";
    }

@endphp
    <tr class="align-center text-center" style='background-color:{{$isread}}'>
        <td class="align-center">
            
            @if ($item->claim_status == "PENDING")
                <a id="{{ $item->id }}" class="btn btn-primary editbtn" href="#modal-view"><i class="bi bi-pencil-square"></i> Edit</a>
            @else
                <a id="{{ $item->id }}" class="btn btn-info viewbtn" href="#modal-view"><i class="bi bi-eye"></i> View</a>
            @endif
            &nbsp;&nbsp;
            <a id="{{ $item->id }}" class="btn btn-danger delbtn"><i class="bi bi-trash"></i> Delete</a>
        </td>
        @foreach ($columns as $dt => $title)
        @php
            $col = $title['column'];
        @endphp
            <td>{{$item->$col}}</td>
        @endforeach
        <td>
            <div class="form-check">
                <input class="form-check-input checker" type="checkbox" value="" id="flexCheckDefault" uid="{{ $item->id }}" {{ ($item->read_finance == 1)? "checked disabled":""; }}>
                <label class="form-check-label" for="flexCheckDefault">
                    {{ ($item->read_finance == 1)? "Read":"Mark as read"; }}
                </label>
            </div>
        </td>
    </tr>
@endforeach
</tbody>

<script>
    $('#selectall').on('click', function() {
        if ($(this).is(':checked')){
            $(".checker").each(function(){
                if (!$(this).is(':checked')){
                    $(this).prop('checked', true);
                    $(this).prop('disabled', true);
                    var uid = $(this).attr("uid");
                    markAsRead(uid);
                }
            });
        }
    });

    $('.checker').on('change', function() {
        if ($(this).is(':checked')){
            $(this).prop('disabled', true);
            $(this).parents('tr').css("background-color", "transparent");
            var uid = $(this).attr("uid");
            markAsRead(uid);
        }
        
    });

    function markAsRead(uid) {
        
        $.ajax({
            url: "{{ url('claim/markAsRead') }}",
            type: "POST",
            data: {uid:uid},
            success: function(response) {
                var notifCount = $("a[menu_id='11']").find(".badge").text();
                var newNotifCount = Number(notifCount.trim()) - 1;
                if(newNotifCount == 0){
                    $("a[menu_id='11']").find(".badge").text("");
                }else{
                    $("a[menu_id='11']").find(".badge").text(newNotifCount);
                }
            }
        });
    }
</script>

