<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
?>

<div>
    <p>
        Dengan menandatangani Borang ini anda telah mengakui bahawa anda telah dengan secukupnya diberikan Notis Perlindungan Data (‘Notis PDPA tersebut’) 
        oleh Universiti Malaysia Sabah (“UMS”) selaras dengan tujuan-tujuan yang selaras dengan Akta Perlindungan Data Peribadi 2010 ("Akta") dan 
        dengan ini memberikan kebenaran kepada UMS untuk pemprosesan dan menggunakan data peribadi anda untuk tujuan-tujuan yang berkenaan sebagaimana 
        yang dinyatakan di dalam Notis PDPA tersebut. 
        Polisi perlindungan data kami boleh didapatkan di web rasmi kami di <strong><u><a href='http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data'>www.ums.edu.my</a></u>. 
    </p>

    <p>
        Sila lawat web rasmi kami di <strong><u><a href='http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data'>www.ums.edu.my</a></u></strong> untuk untuk keterangan lanjut tentang polisi perlindungan data kami, termasuklah cara bagaimana anda boleh mengakses atau membetulkan data peribadi anda atau menarikbalik kebenaran untuk mengutip, menggunakan dan/atau menzahirkan data peribadi anda.
    </p>
    <br>
    <p><strong>NAMA : <?=$bio->CONm ?></strong>
        <br>
        <strong>TARIKH : <?=$date?></strong></p>
    <br>
    <p>
        <strong>*NOTA</strong> : Anda boleh menandatangan samada versi Bahasa Malaysia atau Bahasa Inggeris Borang Kebenaran ini atau kedua-duanya sekali di mana tandatangan salah satu versi adalah dianggap sebagai memadai untuk memberikan persetujuan anda kepada UMS.
    </p>

</div>

<div class="ln_solid"></div>


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


<div class="pull-right">
    <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Setuju', ['class' => 'btn btn-success', 'id' => 'agree-submit', 'name' => 'agree', 'value' => 1, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
    <?= Html::submitButton('<i class="fa fa-times"></i>&nbsp;Tidak Setuju', ['class' => 'btn btn-danger', 'id' => 'disagree-submit', 'name' => 'agree', 'value' => 0, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>