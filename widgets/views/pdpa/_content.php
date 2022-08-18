

<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
?>



<h4><strong>Notice and Privacy</strong></h4>
<p>
    By signing this Form you have admitted that you have been adequately notified of the Universiti Malaysia Sabah’s (“UMS”) Data Protection Notice (‘the said PDPA Notice’), for the following purposes in accordance with the Personal Data Protection Act 2010 ("the Act") and hereby gives your consent to UMS for use and processing the said personal data for the specified purposes as contained therein the said PDPA Notice. 
    Please visit our website at www.ums.edu.my for further details on our data protection policy, including how you may access or correct your personal data or withdraw consent to the collection, use or disclosure of your personal data.
    <br>Data protection policy - <strong><u><a target='_blank' href='http://www.ums.edu.my/v5/en/pdpa/data-protection-notice'>http://www.ums.edu.my/v5/en/pdpa/data-protection-notice</a></u></strong>. 
</p>
<br>
<h4><strong>Notis dan Privasi</strong></h4>
<p>
    Dengan menandatangani Borang ini anda telah mengakui bahawa anda telah dengan secukupnya diberikan Notis Perlindungan Data (‘Notis PDPA tersebut’) 
    oleh Universiti Malaysia Sabah (“UMS”) selaras dengan tujuan-tujuan yang selaras dengan Akta Perlindungan Data Peribadi 2010 ("Akta") dan 
    dengan ini memberikan kebenaran kepada UMS untuk pemprosesan dan menggunakan data peribadi anda untuk tujuan-tujuan yang berkenaan sebagaimana 
    yang dinyatakan di dalam Notis PDPA tersebut.
    Sila lawat web rasmi kami di www.ums.edu.my untuk untuk keterangan lanjut tentang polisi perlindungan data kami, termasuklah cara bagaimana anda boleh mengakses atau membetulkan data peribadi anda atau menarikbalik kebenaran untuk mengutip, menggunakan dan/atau menzahirkan data peribadi anda.
    <br>Polisi perlindungan data - <strong><u><a target='_blank' href='http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data'>http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data</a></u></strong>. 
</p>

<br>
<p>
    <strong>NAME : <?= $bio->CONm ?></strong>
    <br><strong>DATE : <?= $date ?></strong>
</p>

<div class="ln_solid"></div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


<div class="">
    <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Agree/Setuju', ['class' => 'btn btn-success', 'id' => 'agree-submit', 'name' => 'agree', 'value' => 1, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
    <?= Html::submitButton('<i class="fa fa-times"></i>&nbsp;Cancel/Batal', ['class' => 'btn btn-danger', 'id' => 'disagree-submit', 'name' => 'agree', 'value' => 0, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>