import { Head, Link, router } from '@inertiajs/react';
import {

    flexRender,
    getCoreRowModel,
    useReactTable
} from '@tanstack/react-table';
import type {ColumnDef} from '@tanstack/react-table';
import { useState } from 'react';

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
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';

import institutionRoutes from '@/routes/institutions';
import {
    INSTITUTION_TYPE_LABELS


} from '@/types/models';
import type {Institution, Paginated} from '@/types/models';

const { index, create, edit, show, destroy, restore } = institutionRoutes;

interface Props {
    institutions: Paginated<Institution>;
    filters?: { trashed?: boolean };
}

export default function Index({ institutions, filters }: Props) {
    const [search, setSearch] = useState('');
    const showTrashed = filters?.trashed ?? false;

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(
            index().url,
            { search: value, trashed: showTrashed ? 1 : undefined },
            { preserveState: true, replace: true },
        );
    };

    const toggleTrashed = () => {
        router.get(
            index().url,
            { search, trashed: showTrashed ? undefined : 1 },
            { preserveState: true, replace: true },
        );
    };

    const goToPage = (page: number) => {
        router.get(
            index().url,
            { page, search, trashed: showTrashed ? 1 : undefined },
            { preserveState: true, replace: true },
        );
    };

    const handleDelete = (id: number) => {
        router.delete(destroy(id).url);
    };

    const handleRestore = (id: number) => {
        router.post(restore(id).url);
    };

    const columns: ColumnDef<Institution>[] = [
        { accessorKey: 'name', header: 'Име' },
        {
            accessorKey: 'type',
            header: 'Тип',
            cell: ({ row }) => INSTITUTION_TYPE_LABELS[row.original.type],
        },
        {
            id: 'country',
            header: 'Държава',
            cell: ({ row }) => row.original.country?.name ?? '—',
        },
        {
            id: 'manager',
            header: 'Управител',
            cell: ({ row }) => row.original.manager?.name ?? '—',
        },
        {
            id: 'actions',
            header: '',
            cell: ({ row }) => (
                <div className="flex gap-2">
                    {showTrashed ? (
                        <Button
                            size="sm"
                            variant="outline"
                            onClick={() => handleRestore(row.original.id)}
                        >
                            Възстанови
                        </Button>
                    ) : (
                        <>
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
                                            Институцията "{row.original.name}"
                                            ще бъде преместена в кошчето. Може
                                            да я възстановиш по-късно.
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>
                                            Отказ
                                        </AlertDialogCancel>
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
                        </>
                    )}
                </div>
            ),
        },
    ];

    const table = useReactTable({
        data: institutions.data,
        columns,
        getCoreRowModel: getCoreRowModel(),
    });

    return (
        <AppLayout breadcrumbs={[{ title: 'Институции', href: index().url }]}>
            <Head title="Институции" />

            <div className="p-6">
                <div className="mb-4 flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        <Input
                            placeholder="Търсене"
                            value={search}
                            onChange={(e) => handleSearch(e.target.value)}
                            className="w-72"
                        />
                        <Button variant="outline" onClick={toggleTrashed}>
                            {showTrashed
                                ? 'Покажи активните'
                                : 'Покажи изтритите'}
                        </Button>
                    </div>
                    {!showTrashed && (
                        <Button asChild>
                            <Link href={create().url}>Нова институция</Link>
                        </Button>
                    )}
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
                        Страница {institutions.current_page} от{' '}
                        {institutions.last_page} ({institutions.total} общо)
                    </span>
                    <div className="flex gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={institutions.current_page <= 1}
                            onClick={() =>
                                goToPage(institutions.current_page - 1)
                            }
                        >
                            Назад
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={
                                institutions.current_page >=
                                institutions.last_page
                            }
                            onClick={() =>
                                goToPage(institutions.current_page + 1)
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
