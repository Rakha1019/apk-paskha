<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cetak Laporan Barang</title>
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 10mm; /* Atur jarak margin pinggir kertas jika diperlukan */
            }
        }

        body {
            font-family: Arial, sans-serif;
            color: #000;
        }

        @page {
            size: A4;
            margin: 0mm;
        }

        body { 
            font-family: "Times New Roman", Times, serif; 
            font-size: 14px; 
            padding: 2cm;
        }
        .text-center { text-align: center; }
        
        .judul-laporan {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: bold;
        }
        .garis-tebal {
            border: 0;
            border-top: 3px solid black;
            margin-bottom: 20px;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">

    <?php 
    date_default_timezone_set('Asia/Jakarta');
    $bulan_indo = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $tanggal_sekarang = date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
    ?>

    <div class="judul-laporan">LAPORAN DATA INVENTARIS ALAT ELEKTRONIK</div>
    <hr class="garis-tebal">

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Merek / Tipe</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($list_barang as $brg) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $brg['kode_barang']; ?></td>
                <td><?= $brg['nama']; ?></td>
                <td class="text-center"><?= !empty($brg['merk']) ? $brg['merk'] : '-'; ?></td>
                <td class="text-center">
                    <?php 
                        if($brg['kondisi'] == 1) { 
                            echo 'Baik'; 
                        } elseif($brg['kondisi'] == 2) { 
                            echo 'Rusak Ringan'; 
                        } elseif($brg['kondisi'] == 3) { 
                            echo 'Rusak Berat'; 
                        } else {
                            echo '-';
                        }
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan Penanggung Jawab -->
    <div style="float: right; margin-top: 50px; text-align: center;">
        <p>Sukoharjo, <?= $tanggal_sekarang; ?></p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p><b>( ........................................ )</b></p>
    </div>

</body>
</html>