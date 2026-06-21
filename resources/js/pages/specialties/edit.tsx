import { Head, Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

import AppLayout from '@/layouts/app-layout';
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

import type { Specialty, UserOption } from '@/types/models';
import specialtyRoutes from '@/routes/specialties';

const { index, update } = specialtyRoutes;

interface Props {
    specialty: Specialty;
    institutions: UserOption[];
}

export default function Edit({ specialty, institutions }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        name: specialty.name,
        slug: specialty.slug,
        institution_id: String(specialty.institution_id),
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        put(update(specialty.id).url);
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Специалности', href: index().url }]}>
            <Head title={`Редакция: ${specialty.name}`} />

            <div className="p-6">
                <form
                    onSubmit={handleSubmit}
                    className="grid max-w-2xl grid-cols-2 gap-4"
                >
                    {/* name */}
                    <div className="col-span-2">
                        <Label htmlFor="name">Име</Label>
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

                    {/* institution_id */}
                    <div className="col-span-2">
                        <Label htmlFor="institution_id">Институция</Label>
                        <Select
                            value={data.institution_id}
                            onValueChange={(v) => setData('institution_id', v)}
                        >
                            <SelectTrigger id="institution_id">
                                <SelectValue placeholder="Избери институция" />
                            </SelectTrigger>
                            <SelectContent>
                                {institutions.map((institution) => (
                                    <SelectItem
                                        key={institution.id}
                                        value={String(institution.id)}
                                    >
                                        {institution.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.institution_id && (
                            <p className="text-sm text-destructive">
                                {errors.institution_id}
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
