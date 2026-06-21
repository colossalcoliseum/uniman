import { Head, Link, router } from '@inertiajs/react';
import AddIcon from '@mui/icons-material/Add';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Chip from '@mui/material/Chip';
import TextField from '@mui/material/TextField';

import {
    DataGrid
} from '@mui/x-data-grid';
import type {GridColDef, GridPaginationModel} from '@mui/x-data-grid';

import { useState } from 'react';

import AppLayout from '@/layouts/app-layout';
import termPaperRoutes from '@/routes/term-papers';
import { TERM_PAPER_STATUS_LABELS   } from '@/types/models';
import type {TermPaper, Paginated} from '@/types/models';

const { index, create, edit, show } = termPaperRoutes;
interface Props {
    termPapers: Paginated<TermPaper>;
}

export default function Index({ termPapers }: Props) {
    const [search, setSearch] = useState('');

    const handleSearch = (value: string) => {
        setSearch(value);
        router.get(index().url, { search: value }, { preserveState: true, replace: true });
    };

    const handlePaginationChange = (model: GridPaginationModel) => {
        router.get(
            index().url,
            { page: model.page + 1, search },
            { preserveState: true, replace: true },
        );
    };

    const columns: GridColDef<TermPaper>[] = [
        { field: 'name', headerName: 'Заглавие', flex: 1.5 },
        {
            field: 'teacher',
            headerName: 'Учител',
            flex: 1,
            valueGetter: (_value, row) => row.teacher?.name ?? '—',
        },
        {
            field: 'student',
            headerName: 'Студент',
            flex: 1,
            valueGetter: (_value, row) => row.student?.name ?? '—',
        },
        {
            field: 'remark',
            headerName: 'Оценка',
            flex: 0.8,
            valueGetter: (_value, row) => row.remark?.name ?? '—',
        },
        {
            field: 'status',
            headerName: 'Статус',
            flex: 1,
            renderCell: (params) => (
                <Chip label={TERM_PAPER_STATUS_LABELS[params.value as TermPaper['status']]} size="small" />
            ),
        },
        {
            field: 'actions',
            headerName: '',
            flex: 1,
            sortable: false,
            renderCell: (params) => (
                <Box sx={{ display: 'flex', gap: 1 }}>
                    <Button size="small" component={Link} href={show(params.row.id).url}>
                        Преглед
                    </Button>
                    <Button size="small" component={Link} href={edit(params.row.id).url}>
                        Редакция
                    </Button>
                </Box>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={[{ title: 'Курсови работи', href: index().url }]}>
            <Head title="Курсови работи" />

            <Box sx={{ p: 3 }}>
                <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 2 }}>
                    <TextField
                        label="Търсене"
                        size="small"
                        value={search}
                        onChange={(e) => handleSearch(e.target.value)}
                        sx={{ width: 300 }}
                    />
                    <Button variant="contained" startIcon={<AddIcon />} component={Link} href={create().url}>
                        Нова курсова работа
                    </Button>
                </Box>

                <DataGrid
                    rows={termPapers.data}
                    columns={columns}
                    rowCount={termPapers.total}
                    paginationMode="server"
                    paginationModel={{
                        page: termPapers.current_page - 1,
                        pageSize: termPapers.per_page,
                    }}
                    onPaginationModelChange={handlePaginationChange}
                    pageSizeOptions={[termPapers.per_page]}
                    disableColumnMenu
                    autoHeight
                />
            </Box>
        </AppLayout>
    );
}
