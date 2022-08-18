

<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
?>
<div>

    <p>
        By signing this Form you have admitted that you have been adequately notified of the Universiti Malaysia Sabah’s (“UMS”) Data Protection Notice (‘the said PDPA Notice’), for the following purposes in accordance with the Personal Data Protection Act 2010 ("the Act") and hereby gives your consent to UMS for use and processing the said personal data for the specified purposes as contained therein the said PDPA Notice. 
        Our data protection policy is available at our website <strong><u><a href='http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data'>www.ums.edu.my</a></u></strong>. 
    </p>

    <p>
        Please visit our website at <strong><u><a href='http://www.ums.edu.my/v5/ms/pdpa/notis-perlindungan-data'>www.ums.edu.my</a></u></strong> for further details on our data protection policy, including how you may access or correct your personal data or withdraw consent to the collection, use or disclosure of your personal data.
    </p>
    <br>
    <p><strong>NAME : <?=$bio->CONm ?></strong>
        <br><strong>DATE : <?=$date?></strong></p>
    <br>
    <p>
        <strong>*NOTE</strong> : You may execute either Bahasa Malaysia version or English version or both versions of this Consent Form  whereby execution of either one of the same is sufficient to be treated as your consent thereto UMS
    </p>



</div>
<div class="ln_solid"></div>


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>


<div class="pull-right">
    <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Agree', ['class' => 'btn btn-success', 'id' => 'agree-submit', 'name' => 'agree', 'value' => 1, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
    <?= Html::submitButton('<i class="fa fa-times"></i>&nbsp;Disagree', ['class' => 'btn btn-danger', 'id' => 'disagree-submit', 'name' => 'agree', 'value' => 0, 'data' => ['disabled-text' => 'Please Wait..']]) ?>
</div>

<?php ActiveForm::end(); ?>