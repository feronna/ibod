<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss("
.thumbnail, .alert {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5);
    transition: 0.3s;
    min-width: 40%;
    border-radius: 5px;
}
.thumbnail:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 1);
}

.thumbnail:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 1);
}

.thumbnail a:hover{
    text-decoration: none;
}
");
?>
<?= $this->render('_inquiry') ?>
<div class="col-md-12 col-xs-12">
    <div class="x-panel">
        <div class="x-content">
            <h2><strong><i class="fa fa-book"></i> Dokumen Sistem Pengurusan Kualiti (ISMS)</strong></h2>
            <div class="clearfix"></div>
            <p>
                <?= Html::a(
                    '<i class="fa fa-search" aria-hidden="true"></i> Carian Manual/Prosedur/Dokumen',
                    ['carian'],
                    ['class' => 'btn btn-success']
                )
                ?>
            </p>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-3 col-md-offset-1">
            <div class="thumbnail" style="height:auto">
                <a href="<?= Url::toRoute(['kualiti/manual']) ?>">
                    <div class="caption text-center" style="background-color: rgb(56,134,202)">
                        <div class="row">

                            <div class="col-sm-4">
                                <?= Html::img('@web/images/kualiti-1.png', [
                                    'alt' => 'pic not found',
                                    'width' => '100px',
                                    'height' => '100px'
                                ]);
                                ?>
                            </div>
                            <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #000000;"><br><br>1. Manual Kualiti</h4>
                                <!-- <div class="thumbnail-description smaller"><p>Kakitangan UMS </p></div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="thumbnail" style="height:auto">
                <a href="<?= Url::toRoute(['kualiti/prosedur-khusus']) ?>">
                    <div class="caption text-center" style="background-color: rgb(234,144,128)">
                        <div class="row">
                            <div class="col-sm-4">
                                <?= Html::img('@web/images/kualiti-3.png', [
                                    'alt' => 'pic not found',
                                    'width' => 'auto',
                                    'height' => '100px'
                                ]); ?>
                                <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                            </div>
                            <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #000000;"><br><br>2. Prosedur Khusus</h4>
                                <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="thumbnail" style="height:auto">
                <a href="<?= Url::toRoute(['kualiti/prosedur-umum']) ?>">
                    <div class="caption text-center" style="background-color: rgb(123,212,137)">
                        <div class="row">
                            <div class="col-sm-4">
                                <?= Html::img('@web/images/kualiti-2.png', [
                                    'alt' => 'pic not found',
                                    'width' => '100px',
                                    'height' => '100px'
                                ]); ?>
                                <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                            </div>
                            <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #000000;"><br><br>3. Prosedur Umum</h4>
                                <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-3 col-md-offset-2">
            <div class="thumbnail" style="height:auto">
                <a href="<?= Url::toRoute(['kualiti/dokumen-rujukan']) ?>">
                    <div class="caption text-center" style="background-color: rgb(194, 136, 0)">
                        <div class="row">
                            <div class="col-sm-4">
                                <?= Html::img('@web/images/kualiti-5.png', [
                                    'alt' => 'pic not found',
                                    'width' => '100px',
                                    'height' => '100px'
                                ]); ?>
                                <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                            </div>
                            <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #000000;"><br><br>4. Dokumen Rujukan</h4>
                                <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class=" thumbnail" style="height:auto">
                <a href="<?= Url::toRoute(['kualiti/audit-kit']) ?>">
                    <div class="caption text-center" style="background-color: rgb(175,57,213)">
                        <div class="row">
                            <div class="col-sm-4">
                                <?= Html::img('@web/images/kualiti-4.png', [
                                    'alt' => 'pic not found',
                                    'width' => '100px',
                                    'height' => '100px'
                                ]); ?>
                                <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                            </div>
                            <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #000000;"><br><br>5. Borang</h4>
                                <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                        </div>
                        <br>
                    </div>
                </a>
            </div>
        </div>      
    </div>
</div>