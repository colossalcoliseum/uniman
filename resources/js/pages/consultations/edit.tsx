import { Head, Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';

import consultationRoutes from '@/routes/consultations';
import {
    CONSULTATION_STATUS_LABELS,
    CONSULTATION_TYPE_LABELS


} from '@/types/models';
import type {Consultation, UserOption} from '@/types/models';

const { index, update } = consultationRoutes;

interface Props {
    consultation: Consultation;
     students: UserOption[];
    termPapers: UserOption[];
}

export default function Edit({
    consultation,
     students,
    termPapers,
}: Props) {
    const { data, setData, put, processing, errors } = useForm({
        term_paper_id: String(consultation.term_paper_id),
         student_id: String(consultation.student_id),
        starts_at: consultation.starts_at ?? '',
        ends_at: consultation.ends_at ?? '',
        type: consultation.type as string,
        status: consultation.status as string,
        location: consultation.location ?? '',
        notes: consultation.notes ?? '',
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        put(update(consultation.id).url);
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Консултации', href: index().url }]}>
            <Head title="Редакция на консултация" />

            <div className="p-6">
                <form
                    onSubmit={handleSubmit}
                    className="grid max-w-2xl grid-cols-2 gap-4"
                >
                    {/* term_paper_id */}
                    <div className="col-span-2">
                        <Label htmlFor="term_paper_id">Курсова работа</Label>
                        <Select
                            value={data.term_paper_id}
                            onValueChange={(v) => setData('term_paper_id', v)}
                        >
                            <SelectTrigger id="term_paper_id">
                                <SelectValue placeholder="Избери курсова работа" />
                            </SelectTrigger>
                            <SelectContent>
                                {termPapers.map((termPaper) => (
                                    <SelectItem
                                        key={termPaper.id}
                                        value={String(termPaper.id)}
                                    >
                                        {termPaper.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.term_paper_id && (
                            <p className="text-sm text-destructive">
                                {errors.term_paper_id}
                            </p>
                        )}
                    </div>
                    {/* student_id */}
                    <div>
                        <Label htmlFor="student_id">Студент</Label>
                        <Select
                            value={data.student_id}
                            onValueChange={(v) => setData('student_id', v)}
                        >
                            <SelectTrigger id="student_id">
                                <SelectValue placeholder="Избери студент" />
                            </SelectTrigger>
                            <SelectContent>
                                {students.map((student) => (
                                    <SelectItem
                                        key={student.id}
                                        value={String(student.id)}
                                    >
                                        {student.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.student_id && (
                            <p className="text-sm text-destructive">
                                {errors.student_id}
                            </p>
                        )}
                    </div>

                    {/* starts_at */}
                    <div>
                        <Label htmlFor="starts_at">Начало</Label>
                        <Input
                            id="starts_at"
                            type="datetime-local"
                            value={data.starts_at}
                            onChange={(e) =>
                                setData('starts_at', e.target.value)
                            }
                        />
                        {errors.starts_at && (
                            <p className="text-sm text-destructive">
                                {errors.starts_at}
                            </p>
                        )}
                    </div>

                    {/* ends_at */}
                    <div>
                        <Label htmlFor="ends_at">Край</Label>
                        <Input
                            id="ends_at"
                            type="datetime-local"
                            value={data.ends_at}
                            onChange={(e) => setData('ends_at', e.target.value)}
                        />
                        {errors.ends_at && (
                            <p className="text-sm text-destructive">
                                {errors.ends_at}
                            </p>
                        )}
                    </div>

                    {/* type */}
                    <div>
                        <Label htmlFor="type">Тип</Label>
                        <Select
                            value={data.type}
                            onValueChange={(v) => setData('type', v)}
                        >
                            <SelectTrigger id="type">
                                <SelectValue placeholder="Избери тип" />
                            </SelectTrigger>
                            <SelectContent>
                                {Object.entries(CONSULTATION_TYPE_LABELS).map(
                                    ([value, label]) => (
                                        <SelectItem key={value} value={value}>
                                            {label}
                                        </SelectItem>
                                    ),
                                )}
                            </SelectContent>
                        </Select>
                        {errors.type && (
                            <p className="text-sm text-destructive">
                                {errors.type}
                            </p>
                        )}
                    </div>

                    {/* status */}
                    <div>
                        <Label htmlFor="status">Статус</Label>
                        <Select
                            value={data.status}
                            onValueChange={(v) => setData('status', v)}
                        >
                            <SelectTrigger id="status">
                                <SelectValue placeholder="Избери статус" />
                            </SelectTrigger>
                            <SelectContent>
                                {Object.entries(CONSULTATION_STATUS_LABELS).map(
                                    ([value, label]) => (
                                        <SelectItem key={value} value={value}>
                                            {label}
                                        </SelectItem>
                                    ),
                                )}
                            </SelectContent>
                        </Select>
                        {errors.status && (
                            <p className="text-sm text-destructive">
                                {errors.status}
                            </p>
                        )}
                    </div>

                    {/* location */}
                    <div className="col-span-2">
                        <Label htmlFor="location">Локация</Label>
                        <Input
                            id="location"
                            value={data.location}
                            onChange={(e) =>
                                setData('location', e.target.value)
                            }
                        />
                        {errors.location && (
                            <p className="text-sm text-destructive">
                                {errors.location}
                            </p>
                        )}
                    </div>

                    {/* notes */}
                    <div className="col-span-2">
                        <Label htmlFor="notes">Бележки</Label>
                        <Textarea
                            id="notes"
                            value={data.notes}
                            onChange={(e) => setData('notes', e.target.value)}
                            rows={4}
                        />
                        {errors.notes && (
                            <p className="text-sm text-destructive">
                                {errors.notes}
                            </p>
                        )}
                    </div>

                    <div className="col-span-2 flex justify-end gap-2">
                        <Button variant="outline" asChild>
                            <Link href={index().url}>Отказ</Link>
                        </Button>
                        <Button type="submit" disabled={processing}>
                            Запази промените
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
