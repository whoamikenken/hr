@foreach ($result as $item)
<tr class="align-center text-center">
    <td class="align-center">
        <a id="{{ $item->id }}" class="btn btn-primary editbtn" href="#modal-view"><i class="bi bi-pencil-square"></i> Edit</a>
        @if ($item->code == "Admin" || $item->code == "Sales")
            
        @else
            &nbsp;&nbsp;
            <a id="{{ $item->id }}" class="btn btn-danger delbtn"><i class="bi bi-trash"></i> Delete</a>
        @endif
    </td>
    <td>{{$item->code}}</td>
    <td>{{$item->description}}</td>
    <td>{{$item->updated_at}}</td>
    <td>{{$item->modified_by}}</td>
    <td>{{$item->created_at}}</td>
    <td>{{$item->created_by}}</td>
</tr>
@endforeach
