import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import termPaperRoutes from '@/routes/term-papers';
import { TERM_PAPER_STATUS_LABELS } from '@/types/models';
import type { TermPaper, Paginated } from '@/types/models';

const { show } = termPaperRoutes;

interface Props {
    termPapers: Paginated<TermPaper>;
    filters?: { search?: string };
}

export default function Dashboard({ termPapers, filters }: Props) {
    const [search, setSearch] = useState(filters?.search ?? '');

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(
            '/dashboard',
            { search: value },
            { preserveState: true, replace: true },
        );
    };

    const goToPage = (page: number) => {
        router.get(
            '/dashboard',
            { page, search },
            { preserveState: true, replace: true },
        );
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'Табло', href: '/dashboard' }]}>
            <Head title="Табло" />

            <div className="p-6">
                <div className="mb-4">
                    <Input
                        placeholder="Търсене по заглавие"
                        value={search}
                        onChange={(e) => handleSearch(e.target.value)}
                        className="w-72"
                    />
                </div>

                <div className="grid grid-cols-3 gap-4">
                    {termPapers.data.map((termPaper) => (
                        <Link key={termPaper.id} href={show(termPaper.id).url}>
                            <div className="h-full rounded-lg border p-4 transition-colors hover:bg-muted/50">
                                <h3 className="mb-2 line-clamp-2 font-medium">
                                    {termPaper.name}
                                </h3>
                                <p className="text-sm text-muted-foreground">
                                    Задал: {termPaper.teacher?.name ?? '—'}
                                </p>
                                <p className="text-sm text-muted-foreground">
                                    Студент: {termPaper.student?.name ?? '—'}
                                    {termPaper.claimed_at && (
                                        <>
                                            {' '}
                                            на{' '}
                                            {new Date(
                                                termPaper.claimed_at,
                                            ).toLocaleDateString('bg-BG')}
                                        </>
                                    )}
                                </p>
                                <div className="mt-3">
                                    <Badge variant="secondary">
                                        {
                                            TERM_PAPER_STATUS_LABELS[
                                                termPaper.status
                                            ]
                                        }
                                    </Badge>
                                </div>
                            </div>
                        </Link>
                    ))}
                </div>

                {termPapers.data.length === 0 && (
                    <p className="text-center text-muted-foreground">
                        Няма намерени резултати.
                    </p>
                )}

                <div className="mt-6 flex items-center justify-between">
                    <span className="text-sm text-muted-foreground">
                        Страница {termPapers.current_page} от{' '}
                        {termPapers.last_page} ({termPapers.total} общо)
                    </span>
                    <div className="flex gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={termPapers.current_page <= 1}
                            onClick={() =>
                                goToPage(termPapers.current_page - 1)
                            }
                        >
                            Назад
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={
                                termPapers.current_page >= termPapers.last_page
                            }
                            onClick={() =>
                                goToPage(termPapers.current_page + 1)
                            }
                        >
                            Напред
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
