import type { CalendarApi } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import type { DateClickArg } from '@fullcalendar/interaction';
import FullCalendar from '@fullcalendar/react';
import timeGridPlugin from '@fullcalendar/timegrid';
import { Head } from '@inertiajs/react';
import { useRef, useState } from 'react';

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import consultationRoutes from '@/routes/consultations';
import type { UserOption } from '@/types/models';

const { index, calendarData, create } = consultationRoutes;

interface Props {
    teachers: UserOption[];
}

export default function Calendar({ teachers }: Props) {
    const calendarRef = useRef<{ getApi: () => CalendarApi } | null>(null);
    const [teacherId, setTeacherId] = useState<string>('all');

    const handleDateClick = (info: DateClickArg) => {
        window.location.href = `${create().url}?date=${info.dateStr}`;
    };

    const handleTeacherChange = (value: string) => {
        setTeacherId(value);
        calendarRef.current?.getApi().refetchEvents();
    };

    const eventsUrl =
        teacherId === 'all'
            ? calendarData().url
            : calendarData({ query: { teacher_id: teacherId } }).url;

    return (
        <AppLayout
            breadcrumbs={[{ title: 'Календар консултации', href: index().url }]}
        >
            <Head title="Календар на консултациите" />

            <div className="p-6">
                <div className="mb-4 flex items-center gap-2">
                    <span className="text-sm text-muted-foreground">
                        Учител:
                    </span>
                    <Select
                        value={teacherId}
                        onValueChange={handleTeacherChange}
                    >
                        <SelectTrigger className="w-56">
                            <SelectValue placeholder="Всички учители" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">Всички учители</SelectItem>
                            {teachers.map((teacher) => (
                                <SelectItem
                                    key={teacher.id}
                                    value={String(teacher.id)}
                                >
                                    {teacher.name}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <div className="rounded-md border bg-card p-4 text-card-foreground [&_.fc]:text-foreground [&_.fc-button]:border-border [&_.fc-button]:bg-secondary [&_.fc-button]:text-secondary-foreground [&_.fc-button-active]:bg-primary [&_.fc-button-active]:text-primary-foreground [&_.fc-col-header-cell]:bg-muted [&_.fc-day-today]:bg-accent [&_.fc-theme-standard_td]:border-border [&_.fc-theme-standard_th]:border-border">
                    <FullCalendar
                         plugins={[
                            dayGridPlugin,
                            timeGridPlugin,
                            interactionPlugin,
                        ]}
                        initialView="dayGridMonth"
                        headerToolbar={{
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay',
                        }}
                        buttonText={{
                            today: 'днес',
                            month: 'месец',
                            week: 'седмица',
                            day: 'ден',
                        }}
                        events={eventsUrl}
                        dateClick={handleDateClick}
                        height="auto"
                    />
                </div>
            </div>
        </AppLayout>
    );
}
