<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengenalan', array('site/intro')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Penilaian Hidup', array('site/lifeEvaluation')); ?></li>
        <li class="breadcrumb-item active" aria-current="page">Pengukuran Afek</li>
    </ol>
</nav>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'affectMeasures-form',
    'enableAjaxValidation' => false,
        ));
?>
<div class="card">
    <div class="card-header text-left">
        <h5 class="font-weight-bold">B. Pengukuran Afek / <i>Affect Measures</i></h5>
    </div>
    <div class="card-body">
        <p class="text-left">Skala ini terdiri daripada beberapa perkataan yang menggambarkan perasaan dan emosi yang berbeza. 
            Nyatakan tahap persetujuan anda terhadap setiap pernyataan dengan menggunakan skala 1-5. 
            Sila berfikiran terbuka dan jujur dalam memberikan jawapan anda.
            <br>
            <i style="color: green">This scale consists of a number of words that describe different feelings and emotions. 
                Using the 1-5 scale below, indicate your agreement with each item. 
                Please be open and honest in your responding.
            </i>
        </p>
        <p class="text-left">
            Secara umumnya, bagaimana perasaan anda bekerja di Universiti Malaysia Sabah?
            <br>
            <i style="color: green">Generally, how do you feel working here in Universiti Malaysia Sabah?</i>
        </p>



        <table class="table table-sm table-bordered table-striped custom-matrix">
            <tr>
                <th class="align-center align-middle" rowspan="2" style="width: 5rem">Bil</i></th>
                <th class="align-center align-middle" rowspan="2" style="width: 15rem">Pernyataan / <i>Statement</i></th>
                <th class="align-center" colspan="5">Skala / <i>scale</i></th>
            </tr>
            <tr>
                <th class="align-center">Sangat sedikit atau tidak pernah / <i>Very Little or not at all</i></th>
                <th class="align-center">Sedikit / <i>a little</i></th>
                <th class="align-center">Sederhana / <i>Moderately</i></th>
                <th class="align-center">Tinggi / <i>Quite a bit</i></th>
                <th class="align-center">Sangat tinggi / <i>Extremely</i></th>
            </tr>
            <tr>
                <td class="align-middle align-center">1</td>
                <td class="align-middle text-left">Teruja / <i>Excited</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b1', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b1', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b1', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b1', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b1', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">2</td>
                <td class="align-middle text-left">Kecewa / <i>Upset</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b2', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b2', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b2', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b2', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b2', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">3</td>
                <td class="align-middle text-left">Gelisah / <i>Nervous</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b3', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b3', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b3', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b3', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b3', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">4</td>
                <td class="align-middle text-left">Bersalah / <i>Guilty</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b4', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b4', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b4', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b4', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b4', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">5</td>
                <td class="align-middle text-left">Penuh perhatian / <i>Attentive</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b5', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b5', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b5', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b5', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b5', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">6</td>
                <td class="align-middle text-left">Takut / <i>Scared</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b6', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b6', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b6', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b6', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b6', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">7</td>
                <td class="align-middle text-left">Bersemangat / <i>Enthusiastic</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b7', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b7', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b7', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b7', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b7', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">8</td>
                <td class="align-middle text-left">Aktif / <i>Active</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b8', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b8', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b8', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b8', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b8', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">9</td>
                <td class="align-middle text-left">Bermusuhan / <i>Hostile</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b9', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b9', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b9', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b9', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b9', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
            <tr>
                <td class="align-middle align-center">10</td>
                <td class="align-middle text-left">Bangga / <i>Proud</i></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="1"><?php echo $form->radioButton($model, 'b10', array('value' => 1, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="2"><?php echo $form->radioButton($model, 'b10', array('value' => 2, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="3"><?php echo $form->radioButton($model, 'b10', array('value' => 3, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="4"><?php echo $form->radioButton($model, 'b10', array('value' => 4, 'uncheckValue' => null)); ?></td>
                <td class="align-middle align-center" data-toggle="tooltip" data-placement="top" title="5"><?php echo $form->radioButton($model, 'b10', array('value' => 5, 'uncheckValue' => null)); ?></td>
            </tr>
        </table>
    </div>
</div>

<br>
<div class="card">
    <div class="card-body">

        <?php echo CHtml::link('Sebelum / Previous', array('site/lifeEvaluation'), array('class' => 'btn btn-lg btn-primary')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Seterusnya / Next' : 'Seterusnya / Next', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>