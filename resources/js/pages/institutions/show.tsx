import { Head, Link } from '@inertiajs/react';

import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';

import institutionRoutes from '@/routes/institutions';
import { INSTITUTION_TYPE_LABELS  } from '@/types/models';
import type {Institution} from '@/types/models';

const { index, edit } = institutionRoutes;

interface Props {
    institution: Institution;
}

export default function Show({ institution }: Props) {
    return (
        <AppLayout breadcrumbs={[{ title: 'Институции', href: index().url }]}>
            <Head title={institution.name} />

            <div className="p-6">
                <Card className="max-w-2xl">
                    <CardHeader>
                        <CardTitle>{institution.name}</CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                        {institution.logo && (
                            <div className="col-span-2">
                                <img
                                    src={`/storage/${institution.logo}`}
                                    alt={institution.name}
                                    className="h-20"
                                />
                            </div>
                        )}

                        <div>
                            <p className="text-sm text-muted-foreground">
                                Slug
                            </p>
                            <p>{institution.slug}</p>
                        </div>

                        <div>
                            <p className="text-sm text-muted-foreground">Тип</p>
                            <p>{INSTITUTION_TYPE_LABELS[institution.type]}</p>
                        </div>

                        <div>
                            <p className="text-sm text-muted-foreground">
                                Държава
                            </p>
                            <p>{institution.country?.name ?? '—'}</p>
                        </div>

                        <div>
                            <p className="text-sm text-muted-foreground">
                                Управител
                            </p>
                            <p>{institution.manager?.name ?? '—'}</p>
                        </div>

                        <div className="col-span-2">
                            <p className="text-sm text-muted-foreground">
                                Описание
                            </p>
                            <p className="whitespace-pre-wrap">
                                {institution.description ?? '—'}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Назад към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(institution.id).url}>Редакция</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
