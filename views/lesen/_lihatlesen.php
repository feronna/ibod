<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Lesen';
?>

<?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        ['label' => 'No. Lesen',
                            'value' => $model->LicNo,
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                            ],
                        ['label' => 'Nama Pemilik Lesen',
                            'value' => $model->Name],
                        ['label' => 'Jenis Lesen',
                            'value' => $model->jenlesen],
                        ['label' => 'Kelas Lesen',
                            'value' => $model->kellesen],
                        ['label' => 'Tarikh Dikeluarkan',
                            'value' => $model->firstLicIssuedDt],
                        ['label' => 'Tarikh Luput',
                            'value' => $model->licExpiryDt],
                        ['label' => 'Yuran Pembaharuan',
                            'value' =>'RM '. $model->LicRnwlFee],
                        ['label' => 'File',
                            'value' => $model->displayLink,
                            'format' => 'raw',],
                    ],
                ])
                ?>
