<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\db\Expression;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\ikalendar\RefHrCategories;
use app\models\ikalendar\RefHrGroups;
use app\models\ikalendar\TblHrStatus;
use kartik\widgets\DateTimePicker;
use yii\web\View;
// return \yii\helpers\VarDumper::dump($result, $depth = 10, $highlight = true);

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php yii\widgets\Pjax::begin(['id' => 'user-frm']) ?>
<?php $form = ActiveForm::begin(['id' => 'user-form', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

<?php if (!$model->isNewRecord) { ?>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'USER ID',
                'value' => function ($model) {
                    return $model->user_id;
                },
                'captionOptions' => ['style' => 'width:20%'],
            ],
            [
                'label' => 'NAMA',
                'value' => function ($model) {
                    return $model->staf->CONm;
                },
                'captionOptions' => ['style' => 'width:20%'],
            ],
            [
                'label' => 'ICNO',
                'value' => function ($model) {
                    return $model->staf->ICNO;
                },
                'captionOptions' => ['style' => 'width:20%'],
            ],
            [
                'label' => 'JFPIB',
                'value' => function ($model) {
                    return $model->staf->department->fullname;
                },
                'captionOptions' => ['style' => 'width:20%'],
            ],
        ],
    ]);
    ?>

    <hr style="border-top: dotted 1px;" />
<?php } else { ?>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">STAF</label>
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?=
            $form->field($model, 'email')->label(false)->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['!=', 'Status', '6'])->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                'options' => [
                    'placeholder' => 'Carian Staf ...',
                    'class' => 'form-control col-md-7 col-xs-12',
                    //'selected'    => 2,
                    //'id' => 'senarai',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
<?php } ?>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'view')->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'labelSettings' => [
                'label' => 'View Calendar',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'pluginOptions' => ['threeState' => false]
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'post')->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'labelSettings' => [
                'label' => 'Post Events',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'pluginOptions' => ['threeState' => false]
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'add_categories')->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'labelSettings' => [
                'label' => 'Edit Categories',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'pluginOptions' => ['threeState' => false]
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'add_groups')->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'labelSettings' => [
                'label' => 'Edit Groups',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'pluginOptions' => ['threeState' => false]
        ])->label(false);
        ?>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
    <div class="col-md-8 col-sm-8 col-xs-12">
        <?=
        $form->field($model, 'add_users')->widget(CheckboxX::classname(), [
            'autoLabel' => true,
            'labelSettings' => [
                'label' => 'Edit Users',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'pluginOptions' => ['threeState' => false]
        ])->label(false);
        ?>
    </div>
</div>

<hr style="border-top: dotted 1px;" />
<h4>Category Access</h4>
<div>
    <ul>
        <?php foreach ($tree as $ind => $t1) { ?>
            <div class="form-group">
                <li>
                    <label class="control-label"><?= $t1['name'] . ' - <i>' . $t1['description'] . '</i>' ?></label>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <?=
                        Select2::widget([
                            'name' => "TblHrUsers[moderate][" . $t1['category_id'] . "]",
                            'data' => [
                                '1' => 'VIEW',
                                '2' => 'POST',
                                '3' => 'MODERATE',
                            ],
                            'value' => $t1['moderate'],
                            'hideSearch' => true,
                            'options' => [
                                'id' => $t1['category_id'],
                                'placeholder' => '...',
                                'multiple' => false
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </li>
            </div>

            <ul><?php foreach ($t1['sub_of'] as $ind2 => $t2) { ?>
                    <div class="form-group">
                        <li><label class="control-label"><?= $t2['name'] . ' - <i>' . $t2['description'] . '</i>'; ?></label>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <?=
                                Select2::widget([
                                    'name' => "TblHrUsers[moderate][" . $t2['category_id'] . "]",
                                    'data' => [
                                        '1' => 'VIEW',
                                        '2' => 'POST',
                                        '3' => 'MODERATE',
                                    ],
                                    'value' => $t2['moderate'],
                                    'hideSearch' => true,
                                    'options' => [
                                        'id' => $t2['category_id'],
                                        'placeholder' => '...',
                                        'multiple' => false
                                    ], 'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                        </li>
                    </div>
                    <ul><?php foreach ($t2['sub_of'] as $ind3 => $t3) { ?>
                            <div class="form-group">
                                <li><label class="control-label"><?= $t3['name'] . ' - <i>' . $t3['description'] . '</i>'; ?></label>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <?=
                                        Select2::widget([
                                            'name' => "TblHrUsers[moderate][" . $t3['category_id'] . "]",
                                            'data' => [
                                                '1' => 'VIEW',
                                                '2' => 'POST',
                                                '3' => 'MODERATE',
                                            ],
                                            'value' => $t3['moderate'],
                                            'hideSearch' => true,
                                            'options' => [
                                                'id' => $t3['category_id'],
                                                'placeholder' => '...',
                                                'multiple' => false
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
                                    </div>
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

<hr style="border-top: dotted 1px;" />

<?php if ((!$model->isNewRecord) && ($model->groupAccess)) { ?>
    <h4>Group Access</h4>
    <ul>

        <div class="form-group">
            <li>
                <label class="control-label"><?= $model->groupAccess->group->name; ?></label>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <?=
                    Select2::widget([
                        'name' => "TblHrUsers[modGroup]",
                        'data' => [
                            '1' => 'VIEW',
                            '2' => 'PROPOSE',
                            '3' => 'FULL ACCESS',
                        ],
                        'value' => $model->groupAccess->moderate,
                        'hideSearch' => true,
                        'options' => [
                            // 'id' => $t3['category_id'],
                            'placeholder' => '...',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </li>
        </div>


        <div class="form-group">
            <li>
                <label class="control-label col-md-1 col-sm-2 col-xs-1">subscribe</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <?=
                    CheckboxX::widget([
                        'name' => "TblHrUsers[subsGroup]",
                        'value' => $model->groupAccess->subscribe,
                        // 'options' => ['id' => 's_1'],
                        'pluginOptions' => ['threeState' => false]
                    ]);
                    ?>
                </div>
            </li>
        </div>

    </ul>

    <hr style="border-top: dotted 1px;" />
<?php } ?>

<div class="form-group">
    <div class="col-md-push-3 col-sm-6 col-xs-12">
        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
<br />