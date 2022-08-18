<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Lihat Kecacatan';
?>

<?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['label' => 'No. Fail Kebajikan',
                            'value' => $model->SocialWelfareNo,
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],],
                        ['label' => 'No. Laporan Doktor',
                            'value' => $model->DrRptNo],
                        ['label' => 'Jenis Kecacatan',
                            'value' => $model->jenkecacatan],
                        ['label' => 'Punca Kecacatan',
                            'value' => $model->punkecacatan],
                        ['label' => 'Tarikh Kecacatan',
                            'value' => $model->disabilityDt],
                        ['label' => 'Tarikh Sembuh',
                            'value' => $model->tarikhsembuh],
                        ['label' => 'File',
                            'value' => $model->displayLink,
                            'format' => ['raw'],],
                    ],
                ])
                ?>
