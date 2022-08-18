<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\DepartmentSearch;
use app\models\hronline\Tblrscoadminpost;

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
// $this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="department-index"> -->

<!-- <h1><?= Html::encode($this->title) ?></h1> -->
<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian JFPIB</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>


                <?=
                $form->field($searchModel, 'fullname')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->all(), 'fullname', 'fullname'),
                    'options' => ['placeholder' => 'J / F / P / I / B', 'class' => 'form-control col-md-5 col-xs-5'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'isActive')->label(false)->widget(Select2::classname(), [
                    'data' => ["1" => "Aktif", "0" => "Tidak Aktif"],
                    'options' => ['placeholder' => 'Status', 'class' => 'form-control col-md-5 col-xs-5'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<!-- </div> -->

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <?=
            GridView::widget([
                'options' => [
                    'class' => 'table-responsive',
                ],
                'dataProvider' => $dataProvider,
                // 'rowOptions' => function ($model) {
                //     if ($model) {
                //         return ['class' => 'info'];
                //     }
                // },
                /*   'filterModel' => $searchModel, */ //to hide the search row
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => 'Tindakan',
                    //     'template' => '{update}',
                    //     'contentOptions' => ['style' => 'padding:0px 0px 0px 30px;vertical-align: middle;'],
                    // ],

                    [
                        'label' => 'Fullname',
                        'value' => 'fullname'
                    ],
                    [
                        'label' => 'Shortname',
                        'value' => 'shortname'
                    ],
                    [
                        'label' => 'Ketua Pentadbiran',
                        'value' => 'p_pendaftar.CONm'
                    ],

                    // [
                    //     'label' => 'Ketua Pentadbiran(Lantikan Pentadbiran)',
                    //     'value' => function ($data) {
                    //         $val = Tblrscoadminpost::comparepp($data->id, 25);;
                    //         return $val;
                    //     },
                    //     'contentOptions' => ['style' => 'width:150px; white-space: normal;','class' => 'text-center danger'],
                    //     'headerOptions' => [
                    //         'class' => 'text-center danger'
                    //     ],
                    // ],
                    [
                        'label' => 'Ketua Jabatan',
                        'value' => 'k_jabatan.CONm'
                    ],
                    // [
                    //     'label' => 'id',
                    //     'value' => 'chief',
                    // ],
                    // [
                    //     'label' => 'id',
                    //     'value' => 'id',
                    // ],
                    // [
                    //     'label' => 'Ketua Jabatan(Lantikan Pentadbiran)',
                    //     'value' => function ($data) {
                    //         $val = Tblrscoadminpost::comparekj($data->id, 12,$data->dept_cat_id,$data->category_id);

                    //         return $val;
                    //     },
                    //     'contentOptions' => ['style' => 'width:150px; white-space: normal;','class' => 'text-center success'],
                    //     'headerOptions' => [
                    //         'class' => 'text-center success'
                    //     ],
                    // ],
                    // [
                    //     'label' => 'Alamat',
                    //     'value' => 'address',
                    // ],
                    // [
                    //     'label' => 'Fax No',
                    //     'value' => 'fax_no',
                    // ],
                    // [
                    //     'label' => 'Telefon No',
                    //     'value' => 'tel_no',
                    // ],
                    [
                        'label' => 'PA Email',
                        'value' => 'pa_email',
                    ],
                    [
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => 'active',
                    ],
                    [
                        'label' => 'Kategori Department ',
                        'format' => 'raw',
                        'value' => 'deptCat.category',
                    ],
                    [
                        'label' => 'Sub Daripada Department',
                        'format' => 'raw',
                        'value' => 'deptSub.fullname',
                    ],



                ],
            ]);
            ?>
        </div>
    </div>
</div>