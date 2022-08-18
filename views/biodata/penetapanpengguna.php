<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Kemaskini Tetapan Pengguna';
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
                    <?= Html::a('Kembali', ['adminview', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?php 
                    switch (Yii::$app->user->identity->accessLevel) {
                        case '3':
                            $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                            if (['IN', $secondaccess, ['8', '9']]) {
                                echo '<span style="color:red">Hanya boleh tetap semula katalaluan kakitangan. (Tekan butang "Reset")</span>';
                            }
                            break;
                        default:
                            echo Html::a('Kemaskini', ['kemaskinipenetapanpengguna', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ;
                            break;

                    }                   
                    ?>
                </p>

                <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Jawatan Pentadbiran',
                                'value' => ' ',
                                'contentOptions' => ['style' => 'width:auto'],
                                'captionOptions' => ['style' => 'width:26%'],
                            ],
                            [
                                'label' => 'Status Rekod Peribadi',
                                'value' => 'Baru'
                            ],
                            [
                                'label' => 'Peringkat Capaian',
                                'value' => $model->displayaccesslevel
                            ],
                            [
                                'label' => 'Peringkat Capaian Kedua',
                                'value' => $model->displayaccesslevelkedua
                            ],
                            [
                                'label' => 'Kata Laluan',
                                'value' => '******' . ' ' . ' ' . $model->resetpassword,
                                'format' => 'raw'
                            ],
                            [
                                'label' => 'Sync To Active Directory',
                                'value' => $model->syncad,
                                'format' => 'raw'
                            ],
                        ],
                    ])
                ?>

            </div>



        </div>
    </div>
</div>