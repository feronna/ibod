<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\fontawesome\FA;
/* @var $this yii\web\View */
/* @var $model app\models\Tblstaff */

?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div>

    <div class="form-group text-center">
        <span style="alignment-baseline: bottom;"><img class="img-rounded" height='120px' width="100px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span>
    </div>

    <div class="card" style="width: 100%; border: 0px;">
        <div class="card-header text-center">
        </div>
        <div class="row">
            <?php
            echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //                           
                    [
                        'label' => 'Nama',
                        'value' => (is_null($model->gelaran) ? '' : $model->gelaran->Title . ' ') . $model->CONm
                    ],
                    [
                        'label' => 'KP / Pasport',
                        'value' => $model->ICNO
                    ],
                    [
                        'label' => 'UMSPER',
                        'value' => $model->COOldID 
                    ],
                    [
                        'label' => 'Jawatan',
                        'value' => $model->jawatan->fname
                    ],
                    [
                        'label' => 'JFPIU',
                        'value' => $model->department->fullname
                    ],
                    [
                        'label' => 'Emel',
                        'value' => $model->COEmail
                    ],
                    [
                        'label' => 'Status Lantikan',
                        'value' => $model->displayStatusLantikan
                    ],
                    [
                        'label' => 'Status',
                        'value' => $model->displayServiceStatus,
                    ],
                ],
            ]);

            ?>
        <div class="text-center">
            <?php if(Yii::$app->MP->adminRP() == '2'){
            echo $model->resetpassword;
            echo '</br>';
            echo '<span style="color:red">Semua katalaluan baru adalah nombor IC/KP pengguna.</span>';
            }else{
                echo '<span style="color:red">Anda tidak mempunyai akses untuk set semula katalaluan.</span>';
            }
            
            ?>
        
        </div>
        </div>

    </div>

</div>
