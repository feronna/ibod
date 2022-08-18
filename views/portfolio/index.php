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
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_portfolio'); ?> 
</div>
<div class="col-md-12 col-xs-12"> 
<div class="x-panel">
        <div class="row">
                <div class="col-sm-4 col-md-offset-2">
                    <div class="thumbnail" style="height:auto" >
                        <a href="<?= Url::toRoute(['portfolio/halaman-utama'])?>">
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
                                <h4 id="thumbnail-label" style="color: #FFFFFF;"><br><br>myPortfolio</h4>
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
                    <a href="<?= Url::toRoute(['portfolio/tambah-section']) ?>">
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
                            <h4 id="thumbnail-label" style="color: #000000;"><br><br>Tindakan Penyelia</h4>
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
</div>