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
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
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

    // Fatches the events for the calendar
    document.getElementById('salle-selector').addEventListener('change', function () {
        calendar.refetchEvents();
    });
    
    const dateDebutInput = document.getElementById('date_debut');
    const dateFinInput = document.getElementById('date_fin');
    const nomInput = document.getElementById('nom_event');
    let currentEvent = null;

    // Function that shows a preview of an event during it's creation
    function previewEvent() {
        const dateDebut = dateDebutInput.value;
        const dateFin = dateFinInput.value;
        const nom = nomInput.value;

        if (dateDebut && dateFin) {
            if (currentEvent) {
                currentEvent.setStart(dateDebut);
                currentEvent.setEnd(dateFin);
                currentEvent.setProp('title', nom);
            } else {
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

    // Shows the preview event when the inputs change
    dateDebutInput.addEventListener('change', previewEvent);
    dateFinInput.addEventListener('change', previewEvent);
    nomInput.addEventListener('change', previewEvent);

    // Attempt to create the event, part of it is handled by the controller
    document.getElementById('create_event').addEventListener('submit', function(e) {
        e.preventDefault();

        const nom = document.getElementById('nom_event').value;
        const dateDebut = document.getElementById('date_debut').value;
        const dateFin = document.getElementById('date_fin').value;
        const salleId = document.getElementById('salle-selector').value;
        const nomResp = document.getElementById('nom_resp').value;
        const nbrPart = document.getElementById('nbr_part').value;

        if (!nom || !dateDebut || !dateFin || !salleId || !nomResp || !nbrPart) {
            alert('Merci de remplir tous les champs.');
            return;
        }

        const data = {
            nom: nom,
            date_debut: dateDebut,
            date_fin: dateFin,
            salle_id: salleId,
            nom_resp: nomResp,
            nbr_part: parseInt(nbrPart)
        };

        fetch('/create-event/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token("create_event") }}'
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.error || 'Erreur lors de la création de l\'événement.');
            }
            return data;
        })
        .then(result => {
            alert('Événement créé avec succès !');

            document.getElementById('nom_event').value = '';
            document.getElementById('nom_resp').value = '';
            document.getElementById('nbr_part').value = '';
            document.getElementById('date_debut').value = '';
            document.getElementById('date_fin').value = '';

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
