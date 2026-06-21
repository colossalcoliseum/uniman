import { Head, Link } from '@inertiajs/react';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';

import recensionRoutes from '@/routes/recensions';
import { RECENSION_STATUS_LABELS, type Recension } from '@/types/models';

const { index, edit } = recensionRoutes;

interface Props {
    recension: Recension;
}

export default function Show({ recension }: Props) {
    return (
        <AppLayout breadcrumbs={[{ title: 'Рецензии', href: index().url }]}>
            <Head title={recension.title} />

            <div className="p-6">
                <Card className="max-w-2xl">
                    <CardHeader>
                        <CardTitle>{recension.title}</CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                        {/* status */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Статус
                            </p>
                            <Badge variant="secondary">
                                {RECENSION_STATUS_LABELS[recension.status]}
                            </Badge>
                        </div>

                        {/* passed */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Издържана
                            </p>
                            <p>{recension.passed ? 'Да' : 'Не'}</p>
                        </div>

                        {/* term_paper */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Курсова работа
                            </p>
                            <p>{recension.term_paper?.name ?? '—'}</p>
                        </div>

                        {/* reviewer */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Рецензент
                            </p>
                            <p>{recension.reviewer?.name ?? '—'}</p>
                        </div>

                        {/* remark */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Оценка
                            </p>
                            <p>{recension.remark?.name ?? '—'}</p>
                        </div>

                        {/* final_verdict */}
                        <div className="col-span-2">
                            <p className="text-sm text-muted-foreground">
                                Заключение
                            </p>
                            <p className="whitespace-pre-wrap">
                                {recension.final_verdict}
                            </p>
                        </div>
                    </CardContent>
                </Card>

                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Назад към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(recension.id).url}>Редакция</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
