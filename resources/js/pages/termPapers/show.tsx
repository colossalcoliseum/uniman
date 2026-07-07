import { Head, Link } from '@inertiajs/react';

 import TermPaperTimeline from '@/components/term-paper-timeline';
import { Badge } from '@/components/ui/badge';
 import { Button } from '@/components/ui/button';
  import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import AppLayout from '@/layouts/app-layout';
import termPaperRoutes from '@/routes/term-papers';
 import { TERM_PAPER_STATUS_LABELS  } from '@/types/models';
import type {TermPaper} from '@/types/models';
const { index, edit } = termPaperRoutes;
interface Props {
    termPaper: TermPaper;
    termPaperTextContent: string;
}

export default function Show({ termPaper, termPaperTextContent }: Props) {


    return (
        <AppLayout
            breadcrumbs={[{ title: 'Дипломни работи', href: index().url }]}
        >
            <Head title={termPaper.name} />
            <h1 className="scroll-m-20 text-center text-3xl font-bold text-balance">
                Дипломна Работа "{termPaper.name}"
            </h1>
            <div className="p-6">
                <div className="flex flex-col justify-center gap-1 md:flex-row md:items-start md:gap-4">
                    <Card className="max-w-2xl">
                        <CardHeader>
                            <CardTitle>Информация</CardTitle>
                        </CardHeader>
                        <CardContent className="grid grid-cols-2 gap-4">
                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Slug
                                </p>
                                <p>{termPaper.slug}</p>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Статус
                                </p>
                                <Badge variant="secondary">
                                    {TERM_PAPER_STATUS_LABELS[termPaper.status]}
                                </Badge>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Учител
                                </p>
                                <p>{termPaper.teacher?.name ?? '—'}</p>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Студент
                                </p>
                                <p>{termPaper.student?.name ?? '—'}</p>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Начална дата
                                </p>
                                <p>{termPaper.start_date}</p>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Крайна дата
                                </p>
                                <p>{termPaper.end_date}</p>
                            </div>

                            <div>
                                <p className="text-sm text-muted-foreground">
                                    Оценка
                                </p>
                                <p>{termPaper.remark?.name ?? '—'}</p>
                            </div>
                        </CardContent>
                    </Card>
                    <Card className="max-w-2xl">
                        <CardHeader>
                            <CardTitle>
                                Дипломна Работа Текстово Съдържание
                            </CardTitle>
                            <CardContent>
                                <Dialog>
                                    <DialogTrigger asChild>
                                        <Button>Виж</Button>
                                    </DialogTrigger>
                                    <DialogContent>
                                        <DialogHeader>
                                            <DialogTitle>
                                                Тема "{termPaper.name}" <br />
                                                Дипломант{' '}
                                                {termPaper.student?.name}
                                            </DialogTitle>
                                            <DialogDescription>
                                                Отличен с(ъс) оценка
                                                <Badge variant="secondary">
                                                    {termPaper.remark?.name}
                                                </Badge>
                                            </DialogDescription>
                                        </DialogHeader>
                                        <div className="no-scrollbar -mx-4 max-h-[50vh] overflow-y-auto px-4">
                                            {Array.from({ length: 10 }).map(
                                                (_, index) => (
                                                    <p
                                                        key={index}
                                                        className="mb-4 leading-normal"
                                                    >
                                                        {termPaperTextContent}
                                                    </p>
                                                ),
                                            )}
                                        </div>
                                    </DialogContent>
                                </Dialog>
                            </CardContent>
                        </CardHeader>
                    </Card>
                </div>
                <div className="flex flex-col flex-row items-start justify-center gap-1">
                    <Card className="mt-4 max-w-4xl justify-center">
                        <CardHeader>
                            <CardTitle>Прогрес</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <TermPaperTimeline
                                histories={termPaper.status_histories ?? []}
                            />
                        </CardContent>
                    </Card>
                </div>
                <div className="mt-4 flex gap-2">
                    <Button variant="outline" asChild>
                        <Link href={index().url}>Към списъка</Link>
                    </Button>
                    <Button asChild>
                        <Link href={edit(termPaper.id).url}>Редактирай</Link>
                    </Button>
                </div>
            </div>
        </AppLayout>
    );
}
