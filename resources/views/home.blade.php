@extends('layouts.header')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div id='loadDashboard'></div>
<script type="text/javascript">

    $(document).ready(function () {
        loadDashboard();
    });

    function loadDashboard() {
        $.ajax({
            type: "GET",
            url: "{{ url('dashboard/getDashboard')}}",
            data: {},
            success: function(response) {
                $("#loadDashboard").html(response);
            }
        });
    }
</script>
@endsection