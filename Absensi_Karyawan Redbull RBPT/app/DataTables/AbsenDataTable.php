<?php

namespace App\DataTables;

use App\Models\Presence;
use App\Models\PresenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AbsenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('waktu_absen', function ($query) {
                return date('d-m-Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('tanda_tangan', function ($query) {
                if ($query->tanda_tangan && \Storage::disk('public')->exists($query->tanda_tangan)) {
                    return "<img width='100' style='border-radius:6px;' src='" . \Storage::url($query->tanda_tangan) . "'>";
                }
                return '<span style="color: rgba(255,255,255,0.5);">-</span>';
            })
            ->rawColumns(['tanda_tangan'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PresenceDetail $model): QueryBuilder
    {
        $slug = request()->segment(2);
        $presence = Presence::where('slug', $slug)->first();
        return $model->where('presence_id', $presence->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('absen-table')
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
                ->width(60),
            Column::make('waktu_absen')
                ->title('Waktu Absen'),
            Column::make('nama')
                ->title('Nama'),
            Column::make('jabatan')
                ->title('Jabatan'),
            Column::make('asal_instansi')
                ->title('Asal Instansi'),
            Column::make('tanda_tangan')
                ->title('Tanda Tangan')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Absen_' . date('YmdHis');
    }
}
