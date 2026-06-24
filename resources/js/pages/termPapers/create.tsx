import { Head, Link, useForm } from '@inertiajs/react';

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
import AppLayout from '@/layouts/app-layout';

import termPaperRoutes from '@/routes/term-papers';
import type { UserOption, Remark } from '@/types/models';
import { TERM_PAPER_STATUS_LABELS } from '@/types/models';

const { index, store } = termPaperRoutes;

interface Props {
    teachers: UserOption[];
    students: UserOption[];
    remarks: Remark[];
}

export default function Create({ teachers, students, remarks }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        slug: '',
        teacher_id: '',
        student_id: '',
        start_date: '',
        end_date: '',
        status: '',
        remark_id: '',
        // Файлът на дипломната работа. Полето е nullable - не е
        // задължително при създаване на темата, тъй като файлът
        // обикновено се прикача по-късно, при предаване на готовата работа.
        file: null as File | null,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // Inertia сериализира заявката като multipart/form-data
        // автоматично, щом в data присъства File обект - не е нужна
        // ръчна изработка на FormData тук.
        post(store().url, { forceFormData: true });
    };

    return (
        <AppLayout
            breadcrumbs={[{ title: 'Курсови работи', href: index().url }]}
        >
            <Head title="Нова курсова работа" />

            <div className="p-6">
                <form
                    onSubmit={handleSubmit}
                    className="grid max-w-2xl grid-cols-2 gap-4"
                >
                    {/* name */}
                    <div className="col-span-2">
                        <Label htmlFor="name">Заглавие</Label>
                        <Input
                            id="name"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                        />
                        {errors.name && (
                            <p className="text-sm text-destructive">
                                {errors.name}
                            </p>
                        )}
                    </div>

                    {/* slug */}
                    <div className="col-span-2">
                        <Label htmlFor="slug">Slug</Label>
                        <Input
                            id="slug"
                            value={data.slug}
                            onChange={(e) => setData('slug', e.target.value)}
                        />
                        {errors.slug && (
                            <p className="text-sm text-destructive">
                                {errors.slug}
                            </p>
                        )}
                    </div>

                    {/* teacher_id */}
                    <div>
                        <Label htmlFor="teacher_id">Учител</Label>
                        <Select
                            value={data.teacher_id}
                            onValueChange={(v) => setData('teacher_id', v)}
                        >
                            <SelectTrigger id="teacher_id">
                                <SelectValue placeholder="Избери учител" />
                            </SelectTrigger>
                            <SelectContent>
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
                        {errors.teacher_id && (
                            <p className="text-sm text-destructive">
                                {errors.teacher_id}
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

                    {/* start_date */}
                    <div>
                        <Label htmlFor="start_date">Начална дата</Label>
                        <Input
                            id="start_date"
                            type="date"
                            value={data.start_date}
                            onChange={(e) =>
                                setData('start_date', e.target.value)
                            }
                        />
                        {errors.start_date && (
                            <p className="text-sm text-destructive">
                                {errors.start_date}
                            </p>
                        )}
                    </div>

                    {/* end_date */}
                    <div>
                        <Label htmlFor="end_date">Крайна дата</Label>
                        <Input
                            id="end_date"
                            type="date"
                            value={data.end_date}
                            onChange={(e) =>
                                setData('end_date', e.target.value)
                            }
                        />
                        {errors.end_date && (
                            <p className="text-sm text-destructive">
                                {errors.end_date}
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
                                {Object.entries(TERM_PAPER_STATUS_LABELS).map(
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

                    {/* remark_id */}
                    <div>
                        <Label htmlFor="remark_id">Оценка</Label>
                        <Select
                            value={data.remark_id}
                            onValueChange={(v) => setData('remark_id', v)}
                        >
                            <SelectTrigger id="remark_id">
                                <SelectValue placeholder="Избери оценка" />
                            </SelectTrigger>
                            <SelectContent>
                                {remarks.map((remark) => (
                                    <SelectItem
                                        key={remark.id}
                                        value={String(remark.id)}
                                    >
                                        {remark.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.remark_id && (
                            <p className="text-sm text-destructive">
                                {errors.remark_id}
                            </p>
                        )}
                    </div>

                    {/* file */}
                    <div className="col-span-2">
                        <Label htmlFor="file">Файл на дипломната работа</Label>
                        <Input
                            id="file"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            onChange={(e) =>
                                setData('file', e.target.files?.[0] ?? null)
                            }
                        />
                        {errors.file && (
                            <p className="text-sm text-destructive">
                                {errors.file}
                            </p>
                        )}
                    </div>

                    <div className="col-span-2 flex justify-end gap-2">
                        <Button variant="outline" asChild>
                            <Link href={index().url}>Отказ</Link>
                        </Button>
                        <Button type="submit" disabled={processing}>
                            Запази
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
