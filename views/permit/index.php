<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use app\models\myidp\Kategori;
use app\models\myidp\KlusterKursus;
use app\models\myidp\IdpRefPeringkat;
use app\models\hronline\Tblprcobiodata;

/* @var $this yii\web\View */
/* @var $model app\models\aduan\RptTblAduan */

$this->title = Yii::t('app', 'Borang Permohonan Permit Banner / Bunting / Poster');
$title_update = 'Borang Kemaskini Permohonan Permit Banner / Bunting / Poster';

//echo $this->render('/idp/_topmenu');
echo $this->render('/e-perkhidmatan/contact');
?>
<div class="rpt-tbl-aduan-create">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="panel">

                <div class="panel-heading">
                    <div class="x_title">
                        <h2><?php
                            if ($status == '1') {
                                echo $this->title;
                            } else {
                                echo $title_update;
                            }
                            ?></h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </br>

                <?= $this->render('_form', [
                    'model' => $model,
                    'model_event' => $model_event,
                    'status' => 1 //create new permohonan (event)

                ]) ?>
            </div>
        </div>
    </div>
</div>