

function createDate(hours, minutes) {
    const now = new Date();
    now.setHours(hours);
    now.setMinutes(minutes);
    now.setSeconds(0);
    return now;
}



function getOverlappingEvents(event) {
    // select event has event.resource.id
    // eventDrop event has event.resourceIds
    if (!event.resource) return false
    const rId = event.resource ? event.resource.id : event.resourceIds[0];
    return ec.getEvents().filter(e => e.resourceIds[0] == rId && e.start < event.end && event.start < e.end);
}

function hasOverlappingEvents(event) {
    return getOverlappingEvents(event).length > 0;
}

function hasOtherOverlappingEvents(event) {
    return getOverlappingEvents(event).filter(e => e.id != event.id).length > 0
}





function addEvent(event) {
    if (event.id) {
        ec.updateEvent(event);
        return;
    }
    event.id = new Date().getTime();
    event.resourceIds = [ event.resource.id ];
    ec.addEvent(event);
    ec.unselect();
}

const dialog = document.querySelector('dialog');
const event_edit_dialog = document.querySelector('event_edit_dialog');



