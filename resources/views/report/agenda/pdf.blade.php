<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        h2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 40px;
        }
        h3 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 30px;
        }
        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            padding: 25px;
        }
        table td,
        table th {
            border: 1px solid #ddd;
            padding: 6px;
        }
        .p-5 {
            padding: 15px;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table th {
            padding-top: 6px;
            padding-bottom: 6px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
        }
        .center {
            justify-content: center;
            align-items: center;
        }
        table tbody tr {
            text-align: center;
        }
        .text-customer {
            background: darkgreen;
            text-align: left;
        }
		.text-uppercase{
			text-transform: uppercase;
		}
    </style>
	<title>Report Agenda</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 align="center" class="p-5 center">
					AGENDA KEGIATAN KEDEPUTIAN BIDANG PENGELOLAAN INFRASTRUKTUR KAWASAN PERBATASAN
					BULAN <span class="text-selected-month text-uppercase">{{ $selected_month }}</span>  <span class="text-selected-year">{{ $selected_year }}</span>
				</h5>
                <div class="row p-5">
                    <div class="col-12 table-responsive">
                        <table class="center p-5">
                            <thead>
                                <tr>
                                    <th>H/T</th>
                                    <th>Jam</th>
                                    <th>Kegiatan</th>
                                    <th>Tempat</th>
                                    <th>Hadir/Oposisi</th>
                                    <th>Pelaksana Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach ($agendas as $agenda)
									<tr>
										<td>{!! $agenda->tanggal_mulai->translatedFormat('l, d F Y') . ' <b>s.d</b> ' . $agenda->tanggal_selesai->translatedFormat('l, d F Y') !!}</td>
										<td>{{ \Carbon\Carbon::parse($agenda->jam_mulai)->format('H:i') . ' - ' . ($agenda->jam_selesai ?? 'Selesai') }}</td>
										<td>{{ $agenda->kegiatan }}</td>
										<td>{{ $agenda->tempat }}</td>
										<td>{{ $agenda->absens()->count() ? 'Hadir' : 'Diwakili' }}</td>
										<td>{{ $agenda->pelaksana_kegiatan }}</td>
									</tr>	
								@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
	window.onload = function () {  
		window.print();
	}
</script>
</html>