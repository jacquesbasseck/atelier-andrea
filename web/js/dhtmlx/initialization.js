//scheduler.config.multi_day = true;
scheduler.config.xml_date = "%d-%m-%Y %H:%i";
scheduler.config.first_hour = 9;
scheduler.config.last_hour = 18;
// affichage des boutons quand on clique une fois sur un rdv
scheduler.config.icons_select = ["icon_details","icon_delete"];

scheduler.config.limit_time_select = true;
scheduler.config.details_on_create = true;

scheduler.config.details_on_dblclick = true;
scheduler.config.max_month_events = 5;
// la taille entre les heures en px
scheduler.config.hour_size_px = 70;

scheduler.templates.tooltip_date_format = scheduler.date.date_to_str("%j %M %Y %H:%i");
afficherHeureFunc = scheduler.date.date_to_str("%H:%i");
afficherDateFunc = scheduler.date.date_to_str("%j %M %Y");
// permettre de choisir un soin sur une journee entiere
scheduler.config.full_day = false;

window.users = [];

// Définir les jours de repose
scheduler.addMarkedTimespan({ // blocks each Sunday, Monday
    days:  [0, 1],
    zones: "fullday",
    type:  "dhx_time_block",
    css:   "blue_section" // the name of applied CSS class
});

scheduler.templates.tooltip_text = function (start, end, event) {
    getUserDataAjax(event);
    return getRdvInfos(start, end,event);
};

function getUserDataAjax(event) {
    if (typeof window.users[event.id] === 'undefined') {
        $.ajax({
            url: Routing.generate('emploi_du_temps.rendez_vous.user'),
            data: {rdvId : event.id},
            dataType: "json",
            type: "POST",
            async: false,
            success: function(response){
                window.users[event.id] = response.userJson;
            }
        });
    }
}

function getRdvInfos(start, end, event) {
    var html = '<table class="table table-striped">' +
        '<tr><td><b>Titre: </b></td>'+ '<td>' + event.titre + '</td></tr>'+
        '<tr><td><b>Description: </b></td>'+ '<td>' + event.infos + '</td></tr>' +
        '<tr><td><b>Soin: </b></td>'+ '<td>' + scheduler.getLabel('soin', event.soin)+"</td></tr>" +
        '<tr><td><b>Date:</b></td>'+ '<td>' + afficherDateFunc(start) + 'de ' + afficherHeureFunc(start) +
        " à " + afficherHeureFunc(end) + "</td></tr>";

    if (typeof window.users[event.id] !== "undefined") {
        var user = JSON.parse(window.users[event.id]);
        html += '<tr><td><b>Prénom:</b></td>' + '<td>' + user.prenom + "</td></tr>"+
            '<tr><td><b>Nom:</b></td>' + '<td>' + user.nom + "</td></tr>"+
            '<tr><td><b>Sexe:</b></td>' + '<td>' + user.sexe + '</td></tr>'+
            '<tr><td><b>Téléphone:</b></td>' + '<td>' + user.tel + '</td></tr>'+
            '<tr><td><b>E-mail:</b></td>' + '<td>' + user.email + '</td></tr>';
    }
    return html + '</table>';
}

function getRdvTextInfos(start, end,event) {
    var userData = '';
    if (typeof  window.users[event.id] !== "undefined") {
        var user = JSON.parse(window.users[event.id]);
        userData += '<tr><td  align="left">' + user.prenom+ " " + user.nom + "</td></tr>";
    }
    return '<table class="table">' +
        '<tr><td  align="left">' + scheduler.getLabel('soin', event.soin)+"</td></tr>" +
        userData +
        '<tr><td  align="left">' + event.titre + '</td></tr>'+
        '<tr><td align="left">' + event.infos + '</td></tr>' +
    '</table>';
}

// LE TEXTE A AFFICHER SUR LE CALENDRIER
//scheduler.templates.event_bar_text = function (start, end, event) {
//    return "<div class='event-bar-text'>Nouveau rendez-vous</div>";
//};
scheduler.templates.event_text = function (start, end, event) {
    getUserDataAjax(event);
    return getRdvTextInfos(start, end, event);
};

var selectSoinFunc = function (event) {
    var soinData = this.value.split(',');
    var duree = parseInt(soinData[1]);
    scheduler.config.auto_end_date = true;
    scheduler.config.event_duration = duree;
};

scheduler.blockTime({
    start_date: new Date(2000, 1, 1),
    end_date: new Date(),
    days: "fullday"
});

scheduler.config.lightbox.sections = [
    {name: 'Titre', map_to: 'titre', height: 30, type: 'textarea', length: 10, focus: true},
    {name: "Besoin spécifique", height: 100, map_to: "infos", type: "textarea"},
    {name: "Soin", options: window.GLOBAL_SOINS, map_to: "soin", type: "select", height: 30, onchange: selectSoinFunc},
    {name: "time", height: 72, type: "calendar_time", map_to: "auto"}
];

scheduler.templates.event_class = function(start, end, event){
    return getSoinCouleur(event.soin); // default return
};

// Afficher le formulaire de creation plus large
//scheduler.config.wide_form = true;

scheduler.init('scheduler_here', new Date(), 'week');
scheduler.parse(window.GLOBAL_RENDEZVOUS, "json");//takes the name and format of the data source

scheduler.attachEvent("onEventSave", function (id, ev) {
    if (!ev.titre) {
        dhtmlx.alert("Le titre du rendez-vous ne doit etre vide.");
        return false;
    }

    if (ev.titre.length < 5) {
        dhtmlx.alert("Le titre du rendez-vous doit avoir plus de 5 caractères.");
        return false;
    }

    if (ev.titre.length > 150) {
        dhtmlx.alert("Le titre du rendez-vous est trop long. 150 caractères au maximum.");
        return false;
    }

    var soinData = ev.soin.split(',');
    var soinId = parseInt(soinData[0]);
    if (soinId === 0) {
        dhtmlx.alert("Faut choisir un soin");
        return false;
    }
    return true;
});

function updateEndDate(event, soinData) {
    var duree = parseInt(soinData[1]);
    event.end_date = new Date(event.start_date.getTime() + duree*60000);
    scheduler.updateEvent(event.id);
}

function setUserData(eventId, user) {
    scheduler.setUserData(eventId, "nom", user.nom);
    scheduler.setUserData(eventId, "prenom", user.prenom);
    scheduler.setUserData(eventId, "email", user.email);
    scheduler.setUserData(eventId, "tel", user.tel);
    scheduler.setUserData(eventId, "dateNaissance", user.dateNaissance);
    scheduler.setUserData(eventId, "sexe", user.sexe);
    scheduler.setUserData(eventId, "userId", user.id);
}

function beforeUpdate(id, is_new) {
    if (is_new || typeof window.users[id] === 'undefined' || typeof window.GLOBAL_USER === 'undefined') {
        return true;
    }
    return window.GLOBAL_USER.id === JSON.parse(window.users[id]).id;
}

scheduler.attachEvent("onEventCollision", function (ev, evs) {
    if (evs.length) {
        dhtmlx.message({
            type: "error",
            text: "Il y a déjà un rendez-vous pris à cette période."
        });
    }
    return true;
});

scheduler.attachEvent("onEventLoading", function(ev){
    return scheduler.checkCollision(ev);
});

/**
 * Handle the UPDATE event of the scheduler on all possible cases (drag and drop, resize etc..)
 *
 */
scheduler.attachEvent("onEventChanged", function(id,event){
    $.ajax({
        url: Routing.generate('emploi_du_temps.update'),
        data: getFormatedEvent(event, true),
        dataType: "json",
        type: "POST",
        success: function(response){
            updateEndDate(event, event.soin.split(','));
            dhtmlx.message(response.status);
        },
        error: function(responseError){
            var message = [];
            if (typeof responseError.error !== "undefined") {
                message['title'] = responseError.responseJSON.error;
                message['error_message'] = responseError.responseJSON.error_message;
            }
            else {
                message['title'] = 'Erreur';
                message['error_message'] = 'Erreur est survenue.';
            }
            dhtmlx.alert({
                title: message.title,
                type: "alert-error",
                text: message.error_message
            });
            scheduler.updateEvent(id);
        }
    });

    return true;
});

function  getSoinId(selectValue) {
    var soinData = selectValue.split(',');
    return (typeof soinData[0] !== "undefined")? parseInt(soinData[0]):0;
}

function  getSoinCouleur(selectValue) {
    var soinData = [];
    if (typeof selectValue !== 'undefined') {
        soinData = selectValue.split(',');
    }
    return (typeof soinData[2] !== 'undefined')? soinData[2] : 'bleu';
}

// verifier si l'utilisateur a le droit de déplacer un rendez-vous
scheduler.attachEvent("onBeforeEventChanged", function(ev, e, is_new, original){
    return beforeUpdate(ev.id, is_new);
});
// verifier avant d'afficher le formulaire de modification
scheduler.attachEvent("onBeforeLightbox", function (id){
    //any custom logic here
    return beforeUpdate(id, false);
});
scheduler.attachEvent("onBeforeEventDelete", function(id,e){
    //any custom logic here
    return beforeUpdate(id, false);
});

scheduler.attachEvent("onBeforeEventCreated", function (event){
    console.log('====================>', event);
    return true;
});

scheduler.attachEvent('onEventAdded', function (id, event) {
    $.ajax({
        url: Routing.generate('emploi_du_temps.create'),
        data: getFormatedEvent(event),
        dataType: 'json',
        type: 'POST',
        success: function (response) {
            setUserData(id, window.GLOBAL_USER);
            scheduler.changeEventId(event.id, response.id);
            updateEndDate(event, event.soin.split(','));
            dhtmlx.message(response.status);
        },
        error: function (responseError) {
            var message = [];
            if (responseError.hasOwnProperty('error') && responseError.hasOwnProperty('error_message')) {
                message['title'] = responseError.error;
                message['error_message'] = responseError.error_message;
            }
            else {
                message['title'] = 'Erreur';
                message['error_message'] = 'Erreur est survenue.';
            }
            dhtmlx.alert({
                title: message.title,
                type: "alert-error",
                text: message.error_message
            });
            scheduler.deleteEvent(event.id);
        }
    });
});

/**
 * Handle the DELETE appointment event
 */
scheduler.attachEvent("onConfirmedBeforeEventDelete", function (id,ev) {
    $.ajax({
        url: Routing.generate('emploi_du_temps.delete'),
        data: {id:id},
        dataType: "json",
        type: "DELETE",
        success: function (response) {
            if (response.status === "success") {
                if (!ev.willDeleted) {
                    dhtmlx.message("Le rendez-vous a été supprimé.");
                }
            } else {
                dhtmlx.alert({
                    title: 'Erreur',
                    type: 'alert-error',
                    text: "Error: Cannot delete appointment: " + ev.text
                });
            }
        },
        error: function (error) {
            dhtmlx.alert({
                title: 'Erreur',
                type: 'alert-error',
                text: "Error: Cannot delete appointment: " + ev.text
            });
            console.log(error);
        }
    });
    return true;
});

scheduler.attachEvent("onContextMenu", function (id, e){
    scheduler.showLightbox(id);
    e.preventDefault();
});


function getFormatedEvent(id, update) {
    var event;
    // If id is already an event object, use it and don't search for it
    if (typeof(id) === "object") {
        event = id;
    } else {
        event = scheduler.getEvent(id);
    }

    if (!event) {
        console.log("Ce rendez-vous n'existe pas : " + id);
        return false;
    }

    var start, end;
    var eventId = (update) ? event.id : 0;

    var formatDateFunc = scheduler.date.date_to_str("%Y-%m-%d %H:%i:%s");
    start = formatDateFunc(event.start_date);
    end = formatDateFunc(event.end_date);

    return {
        id: eventId,
        debut: start,
        fin: end,
        infos: event.infos,
        titre: event.titre,
        soin: event.soin
    };
}
