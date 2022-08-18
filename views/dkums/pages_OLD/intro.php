<?php echo $this->renderPartial('header'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Pengenalan</li>
    </ol>
</nav>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'main-form',
    'enableAjaxValidation' => false,
        ));
?>
<?php echo $form->errorSummary($model, '', '', array('class' => 'alert alert-danger' ,  'role' => 'alert')); ?>
<?php echo $form->hiddenField($model,'submit',array('value'=>0,'size'=>2,'maxlength'=>2)); ?>

<div class="card">
    <div class="card-header text-left">
        <h5 class="font-weight-bold">Pengenalan / <i>Introduction</i></h5>
    </div>
    <div class="card-body text-left">
        <p>
            Soal selidik ini mengandungi 47 pernyataan. 
            Baca dengan teliti dan jawab secara spontan dalam tempoh 5-10 minit. 
            Tiada jawapan yang betul atau salah. 
            Jawapan pertama yang terlintas di fikiran anda selalunya jawapan yang tepat untuk anda.
        </p>
        <p style="color: green">
            <i>
                This questionnaire contains 47 statements. 
                Read carefully and answer spontaneously within 5-10 minutes. 
                There is no correct or wrong answer. 
                The first answer that comes to your mind is always the right answer for you. 
            </i>
        </p>

        <p>
            Data anda adalah sulit dan tidak berkaitan dengan prestasi anda. 
            Soal selidik ini dibuat bertujuan untuk membantu pengurusan universiti meningkatkan kualiti perkhidmatan tadbir urus terutamanya berkaitan kebajikan kakitangan. 
            Oleh itu, maklum balas ikhlas anda sangat diperlukan. 
        </p>

        <p style="color: green">
            <i>
                Your data is confidential and is not related to your performance. 
                The questionnaire is aimed at helping the university’s management to improve the quality of governance services especially on the welfare of staff. 
                Therefore, your sincere feedback is needed. 
            </i>
        </p>

        <p>
            Mata IDP akan diberikan kepada setiap kakitangan yang telah melengkapkan soal selidik ini.
        </p>

        <p style="color: green">
            <i>
                IDP points will be given to each employee who has completed this questionnaire. 
            </i>
        <p>



        </p>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
         <?php echo CHtml::submitButton($model->isNewRecord ? 'Seterusnya / Next' : 'Seterusnya / Next', array('class' => 'btn btn-lg btn-success')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>