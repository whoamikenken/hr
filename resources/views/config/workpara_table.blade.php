@foreach ($result as $item)
<tr class="align-center text-center">
    <td class="align-center">
        <a id="{{ $item->id }}" class="btn btn-primary editbtn" href="#modal-view"><i class="bi bi-pencil-square"></i> Edit</a>
        &nbsp;&nbsp;
        <a id="{{ $item->id }}" class="btn btn-danger delbtn"><i class="bi bi-trash"></i> Delete</a>
    </td>
    <td>{{$item->description}}</td>
    <td>{{$item->latitude}}</td>
    <td>{{$item->longitude}}</td>
    <td>{{$item->updated_at}}</td>
    <td>{{$item->created_at}}</td>
</tr>
@endforeach
