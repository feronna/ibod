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
<div>
    <?php echo $this->render('_topmenu'); ?>
</div>
<div class="col-md-12 col-xs-12"> 
<div class="x-panel">
        <div class="row">
                <div class="col-sm-4 col-md-offset-2">
                    <div class="thumbnail" style="height:auto" >
                        <a href="<?= Url::toRoute(['data/pemurnian'])?>">
                            <div class="caption text-center" style="background-color: rgb(42,63,84)">
                                <div class="row">
                                   
                                <div class="col-sm-4"> 
                                     <?= Html::img('@web/images/staf.png', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);
                                     ?>
                                </div>
                                    <div class="col-sm-8">
                                <h4 id="thumbnail-label" style="color: #FFFFFF;"><br>Pemurniaan Data Sumber Manusia</h4>
                                <!-- <div class="thumbnail-description smaller"><p>Kakitangan UMS </p></div> -->
                                    </div>
                                    </div>
                                <br>
                            </div>
                        </a>
                    </div>
                </div>
            <div class="col-sm-4">
                <div class="thumbnail" style="height:auto">
                    <a href="<?= Url::toRoute(['data/laporan-statistik']) ?>">
                        <div class="caption text-center" style="background-color: rgb(123,212,137)">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= Html::img('@web/images/statistic.png', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);?>
                                    <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                                </div>
                            <div class="col-sm-8">
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Laporan dan Statistik</h4>
                            <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                            </div>
                            <br>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-4 col-md-offset-2">
                <div class="thumbnail" style="height:auto">
                    <a href="<?= Url::toRoute(['data/maklumat-eksekutif']) ?>">
                        <div class="caption text-center" style="background-color: rgb(234,144,128)">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= Html::img('@web/images/executive.png', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);?>
                                    <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                                </div>
                            <div class="col-sm-8">
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Maklumat Eksekutif</h4>
                            <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                            </div>
                            <br>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail" style="height:auto">
                    <a href="<?= Url::toRoute(['data/hrmis']) ?>">
                        <div class="caption text-center" style="background-color: rgb(255,255,255)">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= Html::img('@web/images/hrmis.jpg', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);?>
                                    <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                                </div>
                            <div class="col-sm-8">
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Pengemaskinian Data HRMIS</h4>
                            <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                            </div>
                            <br>
                        </div>
                    </a>
                </div>
            </div>
            
                  <div class="col-sm-4 col-md-offset-2">

                <div class="thumbnail" style="height:auto">
                    <a href="<?= Url::toRoute(['data/search']) ?>">
                        <div class="caption text-center" style="background-color: rgb(247, 207, 111)">
                            <div class="row">
                                <div class="col-sm-4">
                                     <?= Html::img('@web/images/staf.png', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);?>
                                    <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                                </div>
                            <div class="col-sm-8">
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Data Profiling</h4>
                            <!-- <div class="thumbnail-description smaller"><p> Tanggungan Kakitangan UMS </p></div> -->
                            </div>
                            </div>
                            <br>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="thumbnail" style="height:auto">
                    <a href="<?= Url::toRoute(['data/glosari']) ?>">
                        <div class="caption text-center" style="background-color: rgb(30,115,190)">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?= Html::img('@web/images/glossary.png', [
                                         'alt' => 'pic not found',
                                         'width' => '100px',
                                         'height' => '100px']);?>
                                    <!--<img src="images/family.png" class="img-rounded" alt="tanggungan" width="100" height="100">-->
                                </div>
                            <div class="col-sm-8">
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Glosari</h4>
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
</div>