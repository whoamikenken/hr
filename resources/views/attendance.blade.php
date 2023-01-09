@extends('layouts.header')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Employee Attendance</h1>
</div>
<div class="card shadow animate__animated animate__fadeInRight">
    <div class="card-body">
        <div id='calendar'></div>
    </div> <!-- end card-body-->
</div>

<script>
    
    $(document).ready(function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            hiddenDays: [0],
            allDaySlot: false,
            selectOverlap:false,
            selectable: true,
            selectConstraint: 'businessHours',
            businessHours: {
            daysOfWeek: [ 1, 2, 3, 4,5,6], // Monday - Thursday
            startTime: '6:00', // a start time (10am in this example)
            endTime: '24:00', // an end time (6pm in this example)
            },
            editable: true,
            events: "{{ url('employee/attendance')}}",
            // contentHeight: 680,
            eventClick: function(calEvent, jsEvent, view) {
                console.log(calEvent);    
            },
            eventTimeFormat: { // like '14:30:00'
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            viewDidMount: function(event, element) {
                $('td[data-time]').each(function() {
                        // var time = $(this).attr("data-time");
                        // if(time < "07:00:00"){
                        //     $(this).parent().remove();
                        // }
                        // if(time > "24:00:00"){
                        //     $(this).parent().remove();
                        // }
                        // console.log($(this).parent());
                });
            },
            eventDidMount: function(event, element) {
                // To append if is assessment
                if(event.event.extendedProps.description != '' && typeof event.event.extendedProps.description  !== "undefined")
                {  
                    $(event.el).find(".fc-event-title").append("<br/><b>"+event.event.extendedProps.description+"</b>");
                    $(event.el).find(".fc-event-title").append("<br/><b>"+event.event.extendedProps.prof+"</b>");
                }
            }
            
        });
        calendar.render();
    });
    
    function formatDateToTime(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        hours = hours < 10 ? '0'+hours : hours;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
</script>
@endsection
