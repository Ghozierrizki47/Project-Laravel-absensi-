<?php

namespace App\DataTables;

use App\Models\Presence;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PresencesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('tgl', function ($query) {
                return date('d F Y', strtotime($query->tgl_kegiatan));
            })
            ->addColumn('waktu_mulai', function ($query) {
                return date('H:i', strtotime($query->tgl_kegiatan));
            })
            ->addColumn('action', function ($query) {
                $btnDetail = "<a href='" . route('presence.show', $query->id) . "' class='btn btn-secondary'>Detail</a>";
                $btnEdit = "<a href='" . route('presence.edit', $query->id) . "' class='btn btn-warning'>Edit</a>";
                $btnDelete = "<a href='" . route('presence.destroy', $query->id) . "' class='btn btn-delete btn-danger'>Hapus</a>";

                return "{$btnDetail} {$btnEdit} {$btnDelete}";
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Presence $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('presences-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(100),
            Column::make('nama_kegiatan'),
            Column::make('tgl'),
            Column::make('waktu_mulai'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(250)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Presences_' . date('YmdHis');
    }
}
