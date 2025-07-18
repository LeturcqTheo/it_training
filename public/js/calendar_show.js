document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar-holder');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        events: function(fetchInfo, successCallback, failureCallback) {
            const salleId = document.getElementById('salle-selector').value;
            // Mettre le start et le end pour pouvoir verifier avec fc-load-events
            // Exemple: http://127.0.0.1:8000/fc-load-events?start=0000-01-01&end=9999-12-31
            fetch('/fc-load-events?start=0000-01-01&end=9999-12-31&salle_id=' + salleId)
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(failureCallback);
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function(info) {
            if (info.event.url) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            }
        }
    });

    calendar.render();

    document.getElementById('salle-selector').addEventListener('change', function() {
        calendar.refetchEvents();
    });
});