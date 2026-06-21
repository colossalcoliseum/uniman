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

import institutionRoutes from '@/routes/institutions';
import {
    INSTITUTION_TYPE_LABELS



} from '@/types/models';
import type {Institution, UserOption, Country} from '@/types/models';

const { index, update } = institutionRoutes;

interface Props {
    institution: Institution;
    countries: Country[];
    users: UserOption[];
}

export default function Edit({ institution, countries, users }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        _method: 'put',
        name: institution.name,
        slug: institution.slug,
        type: institution.type as string,
        country_id: String(institution.country_id),
        description: institution.description ?? '',
        manager_id: String(institution.manager_id),
        logo: null as File | null,
    });

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        // PUT с файл не работи нативно - Inertia ползва _method spoofing + POST
        post(update(institution.id).url, { forceFormData: true });
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Институции', href: index().url }]}>
            <Head title={`Редакция: ${institution.name}`} />

            <div className="p-6">
                {institution.logo && (
                    <div className="mb-4">
                        <p className="mb-1 text-sm text-muted-foreground">
                            Текущо лого
                        </p>
                        <img
                            src={`/storage/${institution.logo}`}
                            alt={institution.name}
                            className="h-16"
                        />
                    </div>
                )}

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
                                {Object.entries(INSTITUTION_TYPE_LABELS).map(
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

                    {/* country_id */}
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

                    {/* manager_id */}
                    <div className="col-span-2">
                        <Label htmlFor="manager_id">Управител</Label>
                        <Select
                            value={data.manager_id}
                            onValueChange={(v) => setData('manager_id', v)}
                        >
                            <SelectTrigger id="manager_id">
                                <SelectValue placeholder="Избери управител" />
                            </SelectTrigger>
                            <SelectContent>
                                {users.map((user) => (
                                    <SelectItem
                                        key={user.id}
                                        value={String(user.id)}
                                    >
                                        {user.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {errors.manager_id && (
                            <p className="text-sm text-destructive">
                                {errors.manager_id}
                            </p>
                        )}
                    </div>

                    {/* description */}
                    <div className="col-span-2">
                        <Label htmlFor="description">Описание</Label>
                        <Textarea
                            id="description"
                            value={data.description}
                            onChange={(e) =>
                                setData('description', e.target.value)
                            }
                            rows={4}
                        />
                        {errors.description && (
                            <p className="text-sm text-destructive">
                                {errors.description}
                            </p>
                        )}
                    </div>

                    {/* logo */}
                    <div className="col-span-2">
                        <Label htmlFor="logo">
                            Ново лого (остави празно за да запазиш текущото)
                        </Label>
                        <Input
                            id="logo"
                            type="file"
                            accept="image/*"
                            onChange={(e) =>
                                setData('logo', e.target.files?.[0] ?? null)
                            }
                        />
                        {errors.logo && (
                            <p className="text-sm text-destructive">
                                {errors.logo}
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
