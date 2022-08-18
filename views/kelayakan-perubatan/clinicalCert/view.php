<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Lihat Keahlian';

?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblpraddress-view">
                <p>
                    <?= Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['update-cc', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Title',
                            'value' => $model->title,
                            'contentOptions' => ['style' => 'width:auto'],
                            'captionOptions' => ['style' => 'width:26%'],
                        ],
                        [
                            'label' => 'Type',
                            'value' => $model->certType ? $model->certType->certType : '<span style="background-color:yellow;color:black;">Sila kemaskini.</span>',
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Date Awarded',
                            'value' => Yii::$app->MP->Tarikh($model->dateAwd),
                            'format' => 'raw',
                        ],
                        [
                            'label' => 'Certificate No.',
                            'value' => $model->certNo,
                        ],
                        [
                            'label' => 'Start Date',
                            'value' => Yii::$app->MP->Tarikh($model->startDt),
                        ],
                        [
                            'label' => 'End Date',
                            'value' => Yii::$app->MP->Tarikh($model->endDt),
                        ],
                        [
                            'label' => 'Awarded By',
                            'value' => $model->awardBy,
                        ],
                        [
                            'label' => 'Proof',
                            'value' => $model->displayLink,
                            'format' => 'raw',
                        ],

                    ],
                ]) ?>


            </div>
        </div>
    </div>
</div>