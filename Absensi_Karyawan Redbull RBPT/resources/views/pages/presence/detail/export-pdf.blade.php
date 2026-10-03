<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
</head>

<style>
    .text-center {
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .mb-2 {
        margin-bottom: 20px;
    }

    .table table,
    .table th,
    .table td {
        border: 1px solid black;
        padding: 10px 4px;
    }
</style>

<body>

    <h1 class="text-center">{{ env('APP_NAME') }}</h1>

    <table class="mb-2">
        <tr>
            <td width="150">Nama Kegiatan</td>
            <td width="20">:</td>
            <td>{{ $presence->nama_kegiatan }}</td>
        </tr>
        <tr>
            <td>Tanggal Kegiatan</td>
            <td>:</td>
            <td>{{ date('d F Y', strtotime($presence->tgl_kegiatan)) }}</td>
        </tr>
        <tr>
            <td>Waktu Mulai</td>
            <td>:</td>
            <td>{{ date('H:i', strtotime($presence->tgl_kegiatan)) }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="50">No.</th>
                <th width="120">Tanggal</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Asal Instansi</th>
                <th width="120">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($presenceDetails->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endif
            @foreach ($presenceDetails as $detail)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{ date('d/m/Y H:i', strtotime($presence->created_at)) }}
                    </td>
                    <td>{{ $detail->nama }}</td>
                    <td>{{ $detail->jabatan }}</td>
                    <td>{{ $detail->asal_instansi }}</td>
                    <td class="text-center">
                        @if ($detail->tanda_tangan)
                            @php
                                $path = storage_path('app/public/' . $detail->tanda_tangan);
                                if (file_exists($path)) {
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $img = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                } else {
                                    $img = null;
                                }
                            @endphp
                            @if ($img)
                                <img src="{{ $img }}" alt="Tanda Tangan" style="max-width: 100%;max-height:40px;">
                            @else
                                <span style="color: #999; font-size: 11px;">Tidak ada gambar</span>
                            @endif
                        @else
                            <span style="color: #999; font-size: 11px;">Tidak ada tanda tangan</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
