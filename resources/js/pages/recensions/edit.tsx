import { Head, Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
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

import recensionRoutes from '@/routes/recensions';
import {
    RECENSION_STATUS_LABELS



} from '@/types/models';
import type {Recension, UserOption, Remark} from '@/types/models';

const { index, update } = recensionRoutes;

interface Props {
    recension: Recension;
    reviewers: UserOption[];
    remarks: Remark[];
    termPapers: UserOption[];
}

export default function Edit({
    recension,
    reviewers,
    remarks,
    termPapers,
}: Props) {
    const { data, setData, put, processing, errors } = useForm({
        title: recension.title,
        term_paper_id: String(recension.term_paper_id),
        remark_id: recension.remark_id ? String(recension.remark_id) : '',
        reviewer_id: String(recension.reviewer_id),
        status: recension.status as string,
        final_verdict: recension.final_verdict,
        passed: recension.passed,
        plagiarism_percentage:
            recension.plagiarism_percentage !== null
                ? String(recension.plagiarism_percentage)
                : '',
        genai_status: recension.genai_status as string,
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        put(update(recension.id).url);
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Рецензии', href: index().url }]}>
            <Head title={`Редакция: ${recension.title}`} />

            <div className="p-6">
                <form
                    onSubmit={handleSubmit}
                    className="grid max-w-2xl grid-cols-2 gap-4"
                >
                     <div className="col-span-2">
                        <Label htmlFor="title">Заглавие</Label>
                        <Input
                            id="title"
                            value={data.title}
                            onChange={(e) => setData('title', e.target.value)}
                        />
                        {errors.title && (
                            <p className="text-sm text-destructive">
                                {errors.title}
                            </p>
                        )}
                    </div>

                     <div>
                        <Label htmlFor="term_paper_id">Дипломна работа</Label>
                        <Select
                            value={data.term_paper_id}
                            onValueChange={(v) => setData('term_paper_id', v)}
                        >
                            <SelectTrigger id="term_paper_id">
                                <SelectValue placeholder="Избери дипломна работа" />
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

                     <div>
                        <Label htmlFor="reviewer_id">Рецензент</Label>
                        <Select
                            value={data.reviewer_id}
                            onValueChange={(v) => setData('reviewer_id', v)}
                        >
                            <SelectTrigger id="reviewer_id">
                                <SelectValue placeholder="Избери рецензент" />
                            </SelectTrigger>
                            <SelectContent>
                                {reviewers.map((reviewer) => (
                                    <SelectItem
                                        key={reviewer.id}
                                        value={String(reviewer.id)}
                                    >
                                        {reviewer.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.reviewer_id && (
                            <p className="text-sm text-destructive">
                                {errors.reviewer_id}
                            </p>
                        )}
                    </div>

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
                                {Object.entries(RECENSION_STATUS_LABELS).map(
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

                    {/* final_verdict */}
                    <div className="col-span-2">
                        <Label htmlFor="final_verdict">Заключение</Label>
                        <Textarea
                            id="final_verdict"
                            value={data.final_verdict}
                            onChange={(e) =>
                                setData('final_verdict', e.target.value)
                            }
                            rows={6}
                        />
                        {errors.final_verdict && (
                            <p className="text-sm text-destructive">
                                {errors.final_verdict}
                            </p>
                        )}
                    </div>

                     <div className="col-span-2 flex items-center gap-2">
                        <Checkbox
                            id="passed"
                            checked={data.passed}
                            onCheckedChange={(checked) =>
                                setData('passed', checked === true)
                            }
                        />
                        <Label htmlFor="passed">Издържана</Label>
                        {errors.passed && (
                            <p className="text-sm text-destructive">
                                {errors.passed}
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
