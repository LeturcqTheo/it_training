        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar-holder');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                events: function(fetchInfo, successCallback, failureCallback) {
                    const salleId = document.getElementById('salle-selector').value;
                    const url = salleId ? '/fc-load-events?salle_id=' + salleId+ "&start=0000-01-01&end=9999-12-31" : '/fc-load-events';
                    fetch('/fc-load-events?salle_id=' + salleId + "&start=0000-01-01&end=9999-12-31")
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
                        info.jsEvent.preventDefault(); // prevent browser from following link
                        window.location.href = info.event.url;
                    }
                }
            });

            calendar.render();

            document.getElementById('salle-selector').addEventListener('change', function() {
                calendar.refetchEvents();
            });
        });