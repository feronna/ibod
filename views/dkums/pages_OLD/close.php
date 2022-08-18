<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengenalan', array('site/intro')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Penilaian Hidup', array('site/lifeEvaluation')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Pengukuran Afek', array('site/affectMeasures')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Kepuasan Kerja', array('site/jobSatisfaction')); ?></li>
        <li class="breadcrumb-item"><?php echo CHtml::link('Keterlibatan Kerja', array('site/jobEngagement')); ?></li>
        <li class="breadcrumb-item active" aria-current="page">Selesai</li>
    </ol>
</nav>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'main-form',
    'enableAjaxValidation' => false,
        ));
?>

<div class="card">
    <div class="card-header text-left">
        <h5 class="font-weight-bold">Tahniah! <i>Congratulations!</i></h5>
    </div>
    <div class="card-body">
        <p class="text-left">
            Anda telah melengkapkan soal selidik ini. Terima kasih atas sumbangan anda dalam meningkatkan kecemerlangan tadbir urus universiti.
            <br><i>You have completed this questionnaire. Thank you for your contribution in enhancing the excellence of the university’s governance. </i>
        </p>
        <br>
        <p class="text-left">
            Apakah komen anda mengenai soal selidik ini? 
            <br><i>What is your comment in regard to this questionnaire?</i>
            <br>
        <div class="form-group">
            <?php echo $form->textArea($model, 'komen', array('rows' => 6, 'class' => 'form-control')); ?>
        </div>
        </p>

        <p class="text-left">
            Apakah cadangan/komen anda berkaitan kegembiraan anda di Universiti Malaysia Sabah?
            <br><i>What is your suggestion/comment in regard to your happiness in Universiti Malaysia Sabah? </i>
            <br>
        <div class="form-group">
            <?php echo $form->textArea($model, 'cadangan', array('rows' => 6, 'class' => 'form-control')); ?>
        </div>
        </p>

    </div>
</div>
<br>
<div class="card">
    <div class="card-body">

        <?php echo CHtml::link('Sebelum / Previous', array('site/jobEngagement'), array('class' => 'btn btn-lg btn-primary')); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Selesai / Done' : 'Selesai / Done', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>