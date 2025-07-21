document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar-holder');
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
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventClick: function (info) {
            if (info.event.url) {
                info.jsEvent.preventDefault();
                window.location.href = info.event.url;
            }
        }
    });

    calendar.render();

    document.getElementById('salle-selector').addEventListener('change', function () {
        calendar.refetchEvents();
    });

    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');
    const nomInput = document.getElementById('nom_event');

    let currentEvent = null; // will store our event object

    function previewEvent() {
        const dateDebut = dateDebutInput.value;
        const dateFin = dateFinInput.value;
        const nom = nomInput.value;

        if (dateDebut && dateFin) {
            if (currentEvent) {
                // Update existing event dates
                currentEvent.setStart(dateDebut);
                currentEvent.setEnd(dateFin);
            } else {
                // Add new event and keep reference
                currentEvent = calendar.addEvent({
                    title: nom,
                    start: dateDebut,
                    end: dateFin,
                    backgroundColor: '#bbbbbb',
                    borderColor: '#bbbbbb'
                });
            }
        }
    }

    dateDebutInput.addEventListener('change', previewEvent);
    dateFinInput.addEventListener('change', previewEvent);

    document.getElementById('create_event').addEventListener('submit', function(e) {
        e.preventDefault();

        const nom = document.getElementById('nom_event').value;
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        const salleId = document.getElementById('salle-selector').value;

        if (!nom || !dateDebut || !dateFin) {
            alert('Merci de remplir tous les champs.');
            return;
        }

        const data = {
            nom: nom,
            date_debut: dateDebut,
            date_fin: dateFin,
            salle_id: salleId
        };

        fetch('/create-event', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token("create_event") }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur lors de la création de l\'événement.');
            return response.json();
        })
        .then(result => {
            alert('Événement créé avec succès !');
            nomInput.value = '';
            dateDebutInput.value = '';
            dateFinInput.value = '';
            if (currentEvent) {
                currentEvent.remove();
                currentEvent = null;
            }
            currentEvent = null;
            calendar.refetchEvents();
        })
        .catch(error => {
            alert(error.message);
        });
    });
});
