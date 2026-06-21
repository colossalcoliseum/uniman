import { Head, Link, router } from '@inertiajs/react';
import {

    flexRender,
    getCoreRowModel,
    useReactTable
} from '@tanstack/react-table';
import type {ColumnDef} from '@tanstack/react-table';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';

import consultationRoutes from '@/routes/consultations';
import {
    CONSULTATION_STATUS_LABELS,
    CONSULTATION_TYPE_LABELS


} from '@/types/models';
import type {Consultation, Paginated} from '@/types/models';

const { index, create, edit, show, destroy } = consultationRoutes;

interface Props {
    consultations: Paginated<Consultation>;
}

export default function Index({ consultations }: Props) {
    const goToPage = (page: number) => {
        router.get(
            index().url,
            { page },
            { preserveState: true, replace: true },
        );
    };

    const handleDelete = (id: number) => {
        router.delete(destroy(id).url);
    };

    const columns: ColumnDef<Consultation>[] = [
        {
            id: 'term_paper',
            header: 'Курсова работа',
            cell: ({ row }) => row.original.term_paper?.name ?? '—',
        },
        {
            id: 'teacher',
            header: 'Учител',
            cell: ({ row }) => row.original.teacher?.name ?? '—',
        },
        {
            id: 'student',
            header: 'Студент',
            cell: ({ row }) => row.original.student?.name ?? '—',
        },
        {
            accessorKey: 'starts_at',
            header: 'Начало',
            cell: ({ row }) => row.original.starts_at ?? '—',
        },
        {
            accessorKey: 'type',
            header: 'Тип',
            cell: ({ row }) => CONSULTATION_TYPE_LABELS[row.original.type],
        },
        {
            accessorKey: 'status',
            header: 'Статус',
            cell: ({ row }) => (
                <Badge variant="secondary">
                    {CONSULTATION_STATUS_LABELS[row.original.status]}
                </Badge>
            ),
        },
        {
            id: 'actions',
            header: '',
            cell: ({ row }) => (
                <div className="flex gap-2">
                    <Link
                        href={show(row.original.id).url}
                        className="text-sm underline"
                    >
                        Преглед
                    </Link>
                    <Link
                        href={edit(row.original.id).url}
                        className="text-sm underline"
                    >
                        Редакция
                    </Link>
                    <AlertDialog>
                        <AlertDialogTrigger asChild>
                            <Button size="sm" variant="destructive">
                                Изтрий
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>
                                    Сигурен ли си?
                                </AlertDialogTitle>
                                <AlertDialogDescription>
                                    Това действие е необратимо. Консултацията ще
                                    бъде изтрита завинаги.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Отказ</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() =>
                                        handleDelete(row.original.id)
                                    }
                                >
                                    Изтрий
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
            ),
        },
    ];

    const table = useReactTable({
        data: consultations.data,
        columns,
        getCoreRowModel: getCoreRowModel(),
    });

    return (
        <AppLayout breadcrumbs={[{ title: 'Консултации', href: index().url }]}>
            <Head title="Консултации" />

            <div className="p-6">
                <div className="mb-4 flex items-center justify-end">
                    <Button asChild>
                        <Link href={create().url}>Нова консултация</Link>
                    </Button>
                </div>

                <div className="rounded-md border">
                    <Table>
                        <TableHeader>
                            {table.getHeaderGroups().map((headerGroup) => (
                                <TableRow key={headerGroup.id}>
                                    {headerGroup.headers.map((header) => (
                                        <TableHead key={header.id}>
                                            {header.isPlaceholder
                                                ? null
                                                : flexRender(
                                                      header.column.columnDef
                                                          .header,
                                                      header.getContext(),
                                                  )}
                                        </TableHead>
                                    ))}
                                </TableRow>
                            ))}
                        </TableHeader>
                        <TableBody>
                            {table.getRowModel().rows.length ? (
                                table.getRowModel().rows.map((row) => (
                                    <TableRow key={row.id}>
                                        {row.getVisibleCells().map((cell) => (
                                            <TableCell key={cell.id}>
                                                {flexRender(
                                                    cell.column.columnDef.cell,
                                                    cell.getContext(),
                                                )}
                                            </TableCell>
                                        ))}
                                    </TableRow>
                                ))
                            ) : (
                                <TableRow>
                                    <TableCell
                                        colSpan={columns.length}
                                        className="text-center"
                                    >
                                        Няма намерени резултати.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>

                <div className="mt-4 flex items-center justify-between">
                    <span className="text-sm text-muted-foreground">
                        Страница {consultations.current_page} от{' '}
                        {consultations.last_page} ({consultations.total} общо)
                    </span>
                    <div className="flex gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={consultations.current_page <= 1}
                            onClick={() =>
                                goToPage(consultations.current_page - 1)
                            }
                        >
                            Назад
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={
                                consultations.current_page >=
                                consultations.last_page
                            }
                            onClick={() =>
                                goToPage(consultations.current_page + 1)
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
