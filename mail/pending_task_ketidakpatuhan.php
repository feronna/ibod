
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<p>
    Anda mempunyai <?= $total ?> tindakan ketidakpatuhan staf seliaan anda. 
    <br>
    Berikut merupakan senarai yang menunggu tindakan anda:-
</p>

<table>
    <tr>
        <th>Bil</th>
        <th>Nama</th>
        <th>Tarikh</th>
        <th>Hari</th>
        <th>Masa Masuk</th>
        <th>Masa Keluar</th>
        <th>Jenis Ketidakpatuhan</th>
        <th>Alasan / Sebab</th>
    </tr>
    <?php foreach ($model as $v) { ?>
        <tr>
            <td><?= $bil++ ?></td>
            <td><?= $v->kakitangan->CONm ?></td>
            <td><?= $v->formatTarikh ?></td>
            <td><?= $v->day ?></td>
            <td><?= $v->formatTimeIn ?></td>
            <td><?= $v->formatTimeOut ?></td>
            <td><?= $v->statusAll ?></td>
            <td><?= $v->catatan ?></td>
        </tr>
    <?php } ?>
</table>

<p>Sila klik <a href="https://registrar.ums.edu.my/staff/web/kehadiran/senarai_tindakan">Senarai Tindakan</a> untuk tindakan selanjutnya. </p>
<br>
<br>