<?php

use app\models\cuti\Layak;
use app\models\keselamatan\RefPosKawalan;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use app\models\patrol\RefBit;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\DetailView;

?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">

        <div class="x_panel">
            <div class="x_title">


                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div class="table-responsive">

                </div>
            </div>

            <div class="clearfix">
                <?php foreach ($model as $model) { ?>
                    <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                        <tr class="headings">
                            <th class="column-title text-center">
                                <img height='60%' width="60%" src="<?= Yii::$app->FileManager->DisplayFile($model->file_hashcode); ?>"></span>
            </div>


            <br>
            <br>
            <br>
            <br>
            </th>

            </tr>
            <tr>

                <body>
                    <td style="padding-left: 310px;
                 padding-bottom: 3px;">
                        <strong style="font-size: 35px;"><?php echo RefBit::Name($model->bit_id, $model->type, $model->route_id) ?>
                    </td>
                </body>
            </tr>


            </table>
        <?php } ?>
        </div>

    </div>
</div>