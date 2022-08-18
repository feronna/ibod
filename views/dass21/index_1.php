<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengenalan / Introduction</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p>
                DASS adalah penilaian klinikal yang mengukur tiga keadaan yang berkaitan dengan kemurungan, kecemasan dan tekanan. Ia mempunyai 21 soalan dan mengambil masa kira-kira 3 minit untuk diselesaikan. <br><br>
                
                <i>The DASS is a clinical assessment that measures the three related states of depression, anxiety and stress. It has 21 questions and takes about 3 minutes to complete.</i>
                
            </p>
            <div class="ln_solid"></div>
            <div align="center">
                <?= Html::a('Seterusnya / Next', ['/dass21/assessment'], ['class'=>'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>