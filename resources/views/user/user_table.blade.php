@foreach ($result as $item)
<tr class="align-center text-center">
    <td class="align-center">
        <a id="{{ $item->id }}" class="btn btn-primary editbtn" href="#modal-view"><i class="bi bi-pencil-square"></i> Edit</a>&nbsp;&nbsp;
        <a id="{{ $item->id }}" class="btn btn-danger delbtn"><i class="bi bi-trash"></i> Delete</a>
    </td>
    <td>{{$item->username}}</td>
    <td>{{$item->name}}</td>
    <td>{{$item->user_type}}</td>
    <td>{{ strtoupper($item->status) }}</td>
    <td>{{$item->email}}</td>
    <td>{{$item->created_at}}</td>
</tr>
@endforeach
