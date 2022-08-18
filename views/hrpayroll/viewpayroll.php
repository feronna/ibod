<?php

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;
use yii\helpers\Url;
?>

<div class="x_panel">
    <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_title">
                <h5><strong><i class="fa fa-user"></i> SARAAN</strong></h5>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3 col-sm-3  profile_left">
                <div class="profile_img">
                    <div id="crop-avatar"> <br /><br />
                        <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->ICNO)); ?>.jpeg" width="150" height="180"></center>
                    </div>
                </div>
                <br />
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">
                                    <h5><?= strtoupper($model->CONm); ?></h5>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center">
                                    <?= strtoupper($model->jawatan->fname); ?> |
                                    <?= strtoupper($model->department->fullname); ?> |
                                    <?= strtoupper($model->kampus->campus_name); ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:20%">No. KP / Paspot</th>
                                <td style="width:20%"><?= $model->ICNO; ?></td>
                                <th>UMSPER</th>
                                <td><?= $model->COOldID; ?></td>

                            </tr>
                            <tr>
                                <th style="width:20%">STATUS JAWATAN</th>
                                <td style="width:20%"><?= strtoupper($model->statusLantikan->ApmtStatusNm) ?></td>
                                <th width="20%">STATUS SANDANGAN: </th>
                                <td><?= strtoupper($model->statusSandangan->sandangan_name) ?></td>
                            </tr>
                            <tr>
                                <th style="width:20%">TARIKH MULA SANDANGAN</th>
                                <td style="width:20%"> <?= strtoupper($model->displayStartSandangan) ?></td>
                                <th style="width:20%">TEMPOH LANTIKAN</th>
                                <td style="width:20%"><?= strtoupper(Yii::$app->MP->Tarikh($model->tblrscoapmtstatus->ApmtStatusStDt)) ?> HINGGA <?= strtoupper(Yii::$app->MP->Tarikh($model->tblrscoapmtstatus->ApmtStatusEndDt))  ?></td>
                            </tr>
                            <tr>
                                <th>STATUS PEKERJA</th>
                                <td><?= strtoupper($model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set') ?></td>
                                <th style="width:20%">TARIKH MULA STATUS</th>
                                <td style="width:20%"><?= strtoupper($model->displayStartDateStatus) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br />
            </div>
        </div>


    </div>
</div>
</br>
<div class="row">
    <div class="col-xs-12 col-md-3">
        <?php
        $profile_gaji = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'address-card',
                'header' => 'Profil Gaji',
                'text' =>  'Maklumat Gaji Kakitangan',
                'number' => '1',
            ]
        );
        echo Html::a($profile_gaji, ['profile-gaji', 'umsper' => $model->COOldID]);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $elaunpotonganstaff = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'list-alt',
                'header' => 'Elaun & Potongan',
                'text' =>  'Gaji, Akaun, LPG etc..',
                'number' => '2',
            ]
        );
        // echo Html::a($elaunpotonganstaff, ['profile-gaji', 'ID' => $model->ICNO]);
        echo Html::a($elaunpotonganstaff, ['staff', 'umsper' => $model->COOldID]);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $kemasukan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'users',
                'header' => 'Kemasukan',
                'text' =>  'Admin, Elaun terkini etc...',
                'number' => '3',
            ]
        );
        echo Html::a($kemasukan, ['lpg', 'ID' => $model->ICNO]);
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?php
        $kemasukan = \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'users',
                'header' => 'Slip',
                'text' =>  'Slip Gaji Terkini',
                'number' => '4',
            ]
        );
        echo Html::a($kemasukan, ['view-slip', 'staff_id' => $model->COOldID]);
        ?>
    </div>
</div>