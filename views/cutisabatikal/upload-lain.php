<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
$this->title = 'Muat Naik Dokumen';
$this->params['breadcrumbs'][] = $this->title;
error_reporting(0);
?>
<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cutibelajar/halaman-utama-pemohon']) ?></li>
         <li><?= Html::a('Muat Naik Dokumen', ['cutisabatikal/senarai-dokumen', 'id' => $iklan->id]) ?></li>
        <li>Muat Naik Justifikasi Permohonan</li>
    </ol>
</div>

<div class="body-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12 col-md-12">

            <!-- Start Summernote 5 WYSIWYG Editor -->
            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title"><span class="icon"><i class="glyphicon glyphicon-list-alt"></i></span>&nbsp;&nbsp;Muat Naik Pengesahan Dokumen</h3>
                    </div>

                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <?= $this->render('_lain',['model'=>$model, 'iklan'=>$iklan]);?>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <!--/ End Summernote 5 WYSIWYG Editor -->

        </div>
    </div><!-- /.row -->

</div>