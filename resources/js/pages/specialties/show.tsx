import { Head, Link } from '@inertiajs/react';

import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

import type { Specialty } from '@/types/models';
import specialtyRoutes from '@/routes/specialties';

const { index, edit } = specialtyRoutes;

interface Props {
    specialty: Specialty;
}

export default function Show({ specialty }: Props) {
    return (
        <AppLayout breadcrumbs={[{ title: 'Специалности', href: index().url }]}>
            <Head title={specialty.name} />

            <div className="p-6">
                <Card className="max-w-2xl">
                    <CardHeader>
                        <CardTitle>{specialty.name}</CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Slug
                            </p>
                            <p>{specialty.slug}</p>
                        </div>

                        <div>
                            <p className="text-sm text-muted-foreground">
                                Институция
                            </p>
                            <p>{specialty.institution?.name ?? '—'}</p>
                        </div>
                    </CardContent>
                </Card>

                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Назад към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(specialty.id).url}>Редакция</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
