<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
?>

<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Menu Manager 0.0.2</strong><small>Changelog</small></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <ul>
                <li>
                    <strong>Pushed menu manager 0.0.2</strong>
                    <ol>
                        <li>Tambah sort function</li>
                        <li>Tkr pigi textarea</li>
                        <li>Add feature buli tmbh variable</li>
                    </ol>
                </li>
                <li><strong>Pushed menu manager 0.0.1</strong></li>
            </ul>
        </div>
    </div></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Cara Penggunaan</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <ol>
                <li style="margin: 10px 0;">
                    Tambah <?= Html::a('<b>side menu</b>', ['menu-manager/list-side-menu']) ?>
                    <ul>
                        <li>
                            Tekan <span class="glyphicon glyphicon-sort"></span> utk tukar order anak top menu
                        </li>
                    </ul>
                </li>
                <li style="margin: 10px 0;">Tambah <?= Html::a('<b>top menu</b>', ['menu-manager/list-top-menu']) ?></li>
                <ul>
                    <li>
                        Tekan <span class="glyphicon glyphicon-sort"></span> utk tukar order anak child menu
                    </li>
                </ul>
                <li style="margin: 10px 0;">Copy n paste <code>&lt;?= \app\widgets\TopMenuWidget::widget(['top_menu' => [], 'vars' => []]); ?&gt;</code> di dlm view kamu ikut kesesuaian rasa diri
                    <ul>
                        <li>
                            Contoh <code>'top_menu' => [1,2,3]</code> 1,2,3 tu bersamaan dgn id dlm tbl_menu_top yg kmu mo display
                        </li>
                        <li>
                            Contoh <pre>'vars' => 
                                [
                                    [
                                        'label' => $variable //variable kmu,

                                    ],
                                    [
                                        'label' => $variable //variable kmu,
                                        'items' => [
                                            [
                                                'label' => $variable //variable kmu,
                                            ],
                                        ],
                                    ],
                                ]</pre><br>
                            Klo teda variable mo di pass ltak ja null mcm <code>'vars' => null</code>  
                        </li>
                    </ul>
                </li>
            </ol>
        </div>
    </div></div>
</div>