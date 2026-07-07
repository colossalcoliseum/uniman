import { Head, Link } from '@inertiajs/react';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';

import consultationRoutes from '@/routes/consultations';
import {
    CONSULTATION_STATUS_LABELS,
    CONSULTATION_TYPE_LABELS

} from '@/types/models';
import type {Consultation} from '@/types/models';

const { index, edit } = consultationRoutes;

interface Props {
    consultation: Consultation;
}

export default function Show({ consultation }: Props) {
    return (
        <AppLayout breadcrumbs={[{ title: 'Консултации', href: index().url }]}>
            <Head title="Консултация" />

            <div className="p-6">
                <Card className="max-w-2xl">
                    <CardHeader>
                        <CardTitle>
                            {consultation.term_paper?.name ?? 'Консултация'}
                        </CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                         <div>
                            <p className="text-sm text-muted-foreground">
                                Учител
                            </p>
                            <p>{consultation.teacher?.name ?? '—'}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Студент
                            </p>
                            <p>{consultation.student?.name ?? '—'}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Начало
                            </p>
                            <p>{consultation.starts_at ?? '—'}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Край
                            </p>
                            <p>{consultation.ends_at ?? '—'}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">Тип</p>
                            <p>{CONSULTATION_TYPE_LABELS[consultation.type]}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Статус
                            </p>
                            <Badge variant="secondary">
                                {
                                    CONSULTATION_STATUS_LABELS[
                                        consultation.status
                                    ]
                                }
                            </Badge>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Локация
                            </p>
                            <p>{consultation.location ?? '—'}</p>
                        </div>

                         <div>
                            <p className="text-sm text-muted-foreground">
                                Присъствал
                            </p>
                            <p>
                                {consultation.attended === null
                                    ? '—'
                                    : consultation.attended
                                      ? 'Да'
                                      : 'Не'}
                            </p>
                        </div>

                         <div className="col-span-2">
                            <p className="text-sm text-muted-foreground">
                                Бележки
                            </p>
                            <p className="whitespace-pre-wrap">
                                {consultation.notes ?? '—'}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Назад към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(consultation.id).url}>Редакция</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
