import dayGridPlugin from '@fullcalendar/daygrid';
import FullCalendar from '@fullcalendar/react';


export default function Calendar() {
    return (
        <FullCalendar
            plugins={[dayGridPlugin]}
             weekends={false}
            events={[
                { title: 'event 1', date: '2019-04-01' },
                { title: 'event 2', date: '2019-04-02' },
            ]}
            initialView="dayGridMonth"
        />
    );
}
