<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Bahagian/Seksyen/Unit</strong></h2>
                <?= Html::button('Tambah Bahagian/Seksyen/Unit Baru', ['value' =>  Url::to(['i-kalendar/create-bhg']), 'class' => 'pull-right btn-success btn-sm showModalButton', 'title' => 'Tambah Aktiviti']) ?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                Modal::begin([
                    'header' => '<span id="modalHeaderTitle"></span>',
                    'headerOptions' => ['id' => 'modalHeader'],
                    'id' => 'modal',
                    'size' => 'modal-lg',
                    //keeps from closing modal with esc key or by clicking out of the modal.
                    // user must click cancel or X to close
                    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
                ?>

                <div>
                    <ul>
                        <?php foreach ($tree as $ind => $t1) { ?>
                            <div class="form-group">
                                <li>
                                    <label class="control-label"><?= $t1['name'] . ' - ' . $t1['description']  ?>

                                    </label>
                                    <?= '&nbsp;&nbsp;' . Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['i-kalendar/update-bhg', 'id' => $t1['category_id']]), 'class' => 'btn btn-default btn-sm showModalButton', 'title' => 'Kemaskini Aktiviti']) . '&nbsp;' . Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['i-kalendar/delete-bhg', 'id' => $t1['category_id']]), ['class' => 'btn btn-default btn-sm', 'title' => 'Padam Bahagian', 'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ]]); ?>
                                </li>
                            </div>

                            <ul><?php foreach ($t1['sub_of'] as $ind2 => $t2) { ?>
                                    <div class="form-group">
                                        <li><label class="control-label"><?= $t2['name'] . ' - ' . $t2['description']; ?></label>
                                            <?= '&nbsp;&nbsp;' . Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['i-kalendar/update-bhg', 'id' => $t2['category_id']]), 'class' => 'btn btn-default btn-sm showModalButton', 'title' => 'Kemaskini Aktiviti']) . '&nbsp;' . Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['i-kalendar/delete-bhg', 'id' => $t2['category_id']]), ['class' => 'btn btn-default btn-sm', 'title' => 'Padam Bahagian', 'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ]]); ?>
                                        </li>
                                    </div>
                                    <ul><?php foreach ($t2['sub_of'] as $ind3 => $t3) { ?>
                                            <div class="form-group">
                                                <li><label class="control-label"><?= $t3['name'] . ' - ' . $t3['description']; ?></label>
                                                    <?= '&nbsp;&nbsp;' . Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['i-kalendar/update-bhg', 'id' => $t3['category_id']]), 'class' => 'btn btn-default btn-sm showModalButton', 'title' => 'Kemaskini Aktiviti']) . '&nbsp;' . Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['i-kalendar/delete-bhg', 'id' => $t3['category_id']]), ['class' => 'btn btn-default btn-sm', 'title' => 'Padam Bahagian', 'data' => [
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                        'method' => 'post',
                                                    ]]); ?>
                                                </li>
                                    <?php
                                            echo '</div>';
                                        }
                                        echo '</ul>';
                                    }
                                    echo '</ul>';
                                }
                                    ?>
                                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>