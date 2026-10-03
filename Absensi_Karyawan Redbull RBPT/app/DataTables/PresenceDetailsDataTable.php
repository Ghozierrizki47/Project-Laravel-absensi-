<?php

namespace App\DataTables;

use App\Models\PresenceDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Storage; // <-- TAMBAH INI
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PresenceDetailsDataTable extends DataTable
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
                if ($query->tanda_tangan) {
                    $url = Storage::url($query->tanda_tangan);
                    return "<img class='signature-img' src='" . $url . "' alt='Tanda Tangan' style='max-width: 150px; height: auto; border-radius: 8px; border: 2px solid #FCD700;'>";
                }
                return "<span style='color: rgba(255,255,255,0.5);'>Tidak ada</span>";
            })
            ->addColumn('action', function ($query) {
                // Debug: pastikan ini ID presence_detail, bukan presence_id
                $detailId = $query->id; // ID dari presence_details table
                
                // Log untuk debugging
                \Log::info('DataTable Action Button', [
                    'detail_id' => $detailId,
                    'getKey' => $query->getKey(),
                    'presence_id' => $query->presence_id,
                    'nama' => $query->nama
                ]);
                
                $btnDelete = "<a href='" . route('presence-detail.destroy', $detailId) . "' 
                              class='btn-delete' 
                              data-id='" . $detailId . "' 
                              data-name='" . htmlspecialchars($query->nama) . "'
                              style='background: linear-gradient(135deg, #DC0000, #990000); 
                                     border: none; 
                                     color: white; 
                                     padding: 6px 16px; 
                                     border-radius: 6px; 
                                     font-weight: 600; 
                                     font-size: 13px; 
                                     text-decoration: none; 
                                     display: inline-block; 
                                     cursor: pointer;'>
                              <i class='bi bi-trash-fill'></i> Hapus
                              </a>";

                return $btnDelete;
            })
            ->rawColumns(['tanda_tangan', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PresenceDetail $model): QueryBuilder
    {
        // Gunakan select eksplisit untuk menghindari konflik kolom
        return $model
            ->select('presence_details.*') // Ambil semua kolom dari presence_details
            ->with('presence')
            ->where('presence_details.presence_id', request()->segment(2))
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('presencedetails-table')
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
            Column::make('presence.nama_kegiatan')
                ->title('Nama Kegiatan'),
            Column::make('waktu_absen'),
            Column::make('nama'),
            Column::make('jabatan'),
            Column::make('asal_instansi'),
            Column::make('tanda_tangan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PresenceDetails_' . date('YmdHis');
    }
}
