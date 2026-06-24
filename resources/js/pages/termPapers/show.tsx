import { Head, Link } from '@inertiajs/react';

import { router } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import TermPaperTimeline from '@/components/term-paper-timeline';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import termPaperRoutes from '@/routes/term-papers';
import type { Auth } from '@/types';
import { TERM_PAPER_STATUS_LABELS  } from '@/types/models';
import type {TermPaper} from '@/types/models';

const { index, edit } = termPaperRoutes;

interface Props {
    termPaper: TermPaper;
}

export default function Show({ termPaper }: Props) {
    const { auth } = usePage<{ auth: Auth }>().props;
    const { claim } = termPaperRoutes;

    const canClaim =
        auth.user?.type === 'student' &&
        termPaper.status === 'available' &&
        !termPaper.student;

    const handleClaim = () => {
        router.post(claim(termPaper.id).url);
    };
    return (
        <AppLayout
            breadcrumbs={[{ title: 'Курсови работи', href: index().url }]}
        >
            <Head title={termPaper.name} />

            <div className="p-6">
                <Card className="max-w-2xl">
                    <CardHeader>
                        <CardTitle>{termPaper.name}</CardTitle>
                    </CardHeader>
                    <CardContent className="grid grid-cols-2 gap-4">
                        {/* slug */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Slug
                            </p>
                            <p>{termPaper.slug}</p>
                        </div>

                        {/* status */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Статус
                            </p>
                            <Badge variant="secondary">
                                {TERM_PAPER_STATUS_LABELS[termPaper.status]}
                            </Badge>
                        </div>

                        {/* teacher */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Учител
                            </p>
                            <p>{termPaper.teacher?.name ?? '—'}</p>
                        </div>

                        {/* student */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Студент
                            </p>
                            <p>{termPaper.student?.name ?? '—'}</p>
                        </div>

                        {/* start_date */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Начална дата
                            </p>
                            <p>{termPaper.start_date}</p>
                        </div>

                        {/* end_date */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Крайна дата
                            </p>
                            <p>{termPaper.end_date}</p>
                        </div>

                        {/* remark */}
                        <div>
                            <p className="text-sm text-muted-foreground">
                                Оценка
                            </p>
                            <p>{termPaper.remark?.name ?? '—'}</p>
                        </div>
                    </CardContent>
                </Card>
                <Card className="mt-4 max-w-4xl">
                    <CardHeader>
                        <CardTitle>Напредък</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <TermPaperTimeline
                            histories={termPaper.status_histories ?? []}
                        />
                    </CardContent>
                </Card>
                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Назад към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(termPaper.id).url}>Редакция</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
