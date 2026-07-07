import { Head, Link, router } from '@inertiajs/react';
import {
    flexRender,
    getCoreRowModel,
    useReactTable,
} from '@tanstack/react-table';
import type { ColumnDef } from '@tanstack/react-table';
import { useState } from 'react';

import { Badge } from '@/components/ui/badge';
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
import { usePage } from '@inertiajs/react';
import userRoutes from '@/routes/users';
import type { Paginated } from '@/types/models';

const { students: studentsRoute, show, edit } = userRoutes;

interface StudentRow {
    id: number;
    name: string;
    email: string;
    role: string;
}

interface Props {
    users: Paginated<StudentRow>;
    filters?: { search?: string; trashed?: boolean };
}

export default function Students({ users, filters }: Props) {
    const [search, setSearch] = useState(filters?.search ?? '');
    const { can } = usePage().props;
    const canViewProfiles = can.users.viewIndividualProfiles;

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(
            studentsRoute().url,
            { search: value },
            { preserveState: true, replace: true },
        );
    };

    const goToPage = (page: number) => {
        router.get(
            studentsRoute().url,
            { page, search },
            { preserveState: true, replace: true },
        );
    };

    const columns: ColumnDef<StudentRow>[] = [
        { accessorKey: 'name', header: 'Име' },
        { accessorKey: 'email', header: 'Имейл' },
        {
            accessorKey: 'role',
            header: 'Роля',
            cell: ({ row }) => (
                <Badge variant="secondary">{row.original.role}</Badge>
            ),
        },
        {
            id: 'actions',
            header: '',
            cell: ({ row }) =>
                canViewProfiles ? (
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
                    </div>
                ) : null,
        },
    ];

    const table = useReactTable({
        data: users.data,
        columns,
        getCoreRowModel: getCoreRowModel(),
    });

    return (
        <AppLayout
            breadcrumbs={[{ title: 'Студенти', href: studentsRoute().url }]}
        >
            <Head title="Студенти" />

            <div className="p-6">
                <div className="mb-4">
                    <Input
                        placeholder="Търсене по име или имейл"
                        value={search}
                        onChange={(e) => handleSearch(e.target.value)}
                        className="w-72"
                    />
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
                        Страница {users.current_page} от {users.last_page} (
                        {users.total} общо)
                    </span>
                    <div className="flex gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={users.current_page <= 1}
                            onClick={() => goToPage(users.current_page - 1)}
                        >
                            Назад
                        </Button>
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={users.current_page >= users.last_page}
                            onClick={() => goToPage(users.current_page + 1)}
                        >
                            Напред
                        </Button>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
