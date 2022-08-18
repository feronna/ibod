<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblOpenpos;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;


/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */
?>
<?php echo $this->render('/openpos/_menu'); ?>

<div class="col-md-12"> 
    <div class="x_panel">

        <div class="x_title">
            <h2>Senarai Dokumen Untuk DiMuat Naik</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>  

        <div class="x_content">
            <label class="control-label col-md-1 col-md-5 col-sm-6 col-xs-12">1.
            </label>
            <a href="<?= Url::to(['openpos/creates']); ?>" class="btn btn-success btn-md rounded">    
                <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Latar Belakang J/F/P/I/U</strong></a>
            <br /><br />

            <label class="control-label col-md-1 col-md-5 col-sm-6 col-xs-12">2.
            </label>    
            <a href="<?= Url::to(['openpos/creates']); ?>" class="btn btn-success btn-md rounded">    
                <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Carta Organisasi Sedia Ada</strong></a>
            <br /><br />
            <label class="control-label col-md-1 col-md-5 col-sm-6 col-xs-12">3.
            </label>    
            <a href="<?= Url::to(['openpos/creates']); ?>" class="btn btn-success btn-md rounded">    
                <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Carta Fungsi Sedia Ada</strong></a>
            <br /><br />
            <label class="control-label col-md-1 col-md-5 col-sm-6 col-xs-12">4.
            </label>    
            <a href="<?= Url::to(['openpos/creates']); ?>" class="btn btn-success btn-md rounded">    
                <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Carta Fungsi Cadangan</strong></a>
            <br /><br />
            <label class="control-label col-md-1 col-md-5 col-sm-6 col-xs-12">5.
            </label>    
            <a href="<?= Url::to(['openpos/creates']); ?>" class="btn btn-success btn-md rounded">    
                <span class="icon"><i class="fa fa-plus"></i>&nbsp;</span><strong>Muat Naik Carta Organisasi Cadangan</strong></a>
            <br /><br />

        </div>
        <!--testing kartik-->


    </div>
</div>  <!-- end of xpanel-->
</div> <!-- end of md-->
