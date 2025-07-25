document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar-holder');
    // Creates the calendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        events: function (fetchInfo, successCallback, failureCallback) {
            const salleId = document.getElementById('salle-selector').value;
            fetch('/fc-load-events?start=0000-01-01&end=9999-12-31&salle_id=' + salleId)
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(failureCallback);
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridYear,dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function (info) {
            if (info.event.url) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            }
        }
    });

    // Renders the calendar
    calendar.render();

    // Fetches the events for the calendar
    document.getElementById('salle-selector').addEventListener('change', function () {
        calendar.refetchEvents();
    });
    document.getElementById('centre-selector').addEventListener('change', function () {
        document.getElementById('salle-selector').selectedIndex = 0;
        calendar.refetchEvents();
    });
});
