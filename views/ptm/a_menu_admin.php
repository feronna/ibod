<?php

use app\assets\BoxAsset;
use app\models\User;
use yii\helpers\Url;

BoxAsset::register($this);

use yii\helpers\Html;

?>
<div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

        <div class="x_title">
            <h4><strong><i class='fa fa-clipboard'></i> PROGRAM TRANSFORMASI MINDA (PTM)</strong></h4>
            <div class="clearfix"></div>
        </div>


        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
            <ul class="to_do">
                <li style="background-color:#77DD77;color:white">
                    <p> </p>
                    <p>
                    </p>
                </li>
                <a href="gambar">
                    <li style="#3CB371">
                        <p><b> <?= Html::a(' Senarai Kakitangan <br>Layak Hadir', ['senarai-layak']) ?>
                            </b></p>
                        <p>
                        </p>
                    </li>
                </a>
            </ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
            <ul class="to_do">
                <li style="background-color:#77DD77;color:white">
                    <p> </p>
                    <p>
                    </p>
                </li>
                <a href="gambar">
                    <li style="#3CB371">
                        <p><b> <?= Html::a(' Tetapan <br>Jadual PTM', ['tetapan-jadual']) ?>
                            </b></p>
                        <p>
                        </p>
                    </li>
                </a>
            </ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
            <ul class="to_do">
                <li style="background-color:#77DD77;color:white">
                    <p> </p>
                    <p>
                    </p>
                </li>
                <a href="gambar">
                    <li style="#3CB371">
                        <p><b> <?= Html::a(' Notifikasi <br> Emel', ['senarai-layak']) ?>
                            </b></p>
                        <p>
                        </p>
                    </li>
                </a>
            </ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
            <ul class="to_do">
                <li style="background-color:#77DD77;color:white">
                    <p> </p>
                    <p>
                    </p>
                </li>
                <a href="gambar">
                    <li style="#3CB371">
                        <p><b> <?= Html::a(' Semak <br>Status Kehadiran', ['senarai-layak']) ?>
                            </b></p>
                        <p>
                        </p>
                    </li>
                </a>
            </ul>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 ">
            <ul class="to_do">
                <li style="background-color:#77DD77;color:white">
                    <p> </p>
                    <p>
                    </p>
                </li>
                <a href="gambar">
                    <li style="#3CB371">
                        <p><b> <?= Html::a(' Kemaskini <br>Markah PTM', ['senarai-layak']) ?>
                            </b></p>
                        <p>
                        </p>
                    </li>
                </a>
            </ul>
        </div>
    </div>
</div>