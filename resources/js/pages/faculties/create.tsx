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
import AppLayout from '@/layouts/app-layout';

import facultyRoutes from '@/routes/faculties';
import type { UserOption, Country } from '@/types/models';

const { index, store } = facultyRoutes;

interface Props {
    institutions: UserOption[];
    countries: Country[];
    deans: UserOption[];
}

export default function Create({ institutions, countries, deans }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        slug: '',
        institution_id: '',
        country_id: '',
        dean_id: '',
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        post(store().url);
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Факултети', href: index().url }]}>
            <Head title="Нов факултет" />

            <div className="p-6">
                <form
                    onSubmit={handleSubmit}
                    className="grid max-w-2xl grid-cols-2 gap-4"
                >
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

                     <div>
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

                     <div>
                        <Label htmlFor="country_id">Държава</Label>
                        <Select
                            value={data.country_id}
                            onValueChange={(v) => setData('country_id', v)}
                        >
                            <SelectTrigger id="country_id">
                                <SelectValue placeholder="Избери държава" />
                            </SelectTrigger>
                            <SelectContent>
                                {countries.map((country) => (
                                    <SelectItem
                                        key={country.id}
                                        value={String(country.id)}
                                    >
                                        {country.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.country_id && (
                            <p className="text-sm text-destructive">
                                {errors.country_id}
                            </p>
                        )}
                    </div>

                     <div className="col-span-2">
                        <Label htmlFor="dean_id">Декан</Label>
                        <Select
                            value={data.dean_id}
                            onValueChange={(v) => setData('dean_id', v)}
                        >
                            <SelectTrigger id="dean_id">
                                <SelectValue placeholder="Избери декан" />
                            </SelectTrigger>
                            <SelectContent>
                                {deans.map((dean) => (
                                    <SelectItem
                                        key={dean.id}
                                        value={String(dean.id)}
                                    >
                                        {dean.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.dean_id && (
                            <p className="text-sm text-destructive">
                                {errors.dean_id}
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
