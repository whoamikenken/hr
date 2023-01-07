<thead>
    <tr>
        <th class="text-center">Action</th>
        @foreach ($columns as $dt => $title)
            <th class="text-center" data-priority="1">{{$title['title']}}</th>
        @endforeach
    </tr>
</thead>
<tbody>
@foreach ($result as $key => $item)
    <tr class="align-center text-center">
        <td class="align-center">
            <a id="{{ $item->id }}" class="btn btn-primary editbtn" href="#modal-view"><i class="bi bi-pencil-square"></i> Edit</a>&nbsp;&nbsp;
            <a id="{{ $item->id }}" class="btn btn-danger delbtn"><i class="bi bi-trash"></i> Delete</a>
        </td>
        @foreach ($columns as $dt => $title)
        @php
            $col = $title['column'];
        @endphp
            <td>{{$item->$col}}</td>
        @endforeach
    </tr>
@endforeach
</tbody>

