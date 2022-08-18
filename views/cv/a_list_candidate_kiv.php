<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\cv\TblAccess;

$request = Yii::$app->request;
if (TblAccess::isAdminPanel() || TblAccess::isAdminPanelTapisan() || TblAccess::isAdminPanelPemilih() || TblAccess::isExternalUner()) {
    $url = 'jawatankuasa';
}
if (TblAccess::isAdminAcademic() || TblAccess::isAdminNonAcademic()) {
    $url = 'applications';
}
?> 
<?= $this->render('menu') ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">APPLICATION <b><i>(Additional)</i></b> - <?= $gred; ?></p>
        <p align="right">
            <?php if (TblAccess::isAdminAcademic() || TblAccess::isAdminPanel()) { ?>
                <button style="float: right" class="btn btn-default" onclick="test()"><i class="fa fa-download"></i></button>
            <?php } ?>
<?= Html::a('Back', [$url], ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <div class="table-responsive">

            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'UMSPER',
                    'value' => function($model) {
                        return $model->user->COOldID;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Name',
                    'value' => function($model) {
                        return ucwords(strtolower($model->user->CONm));
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Current Position',
                    'value' => function($model) {
                        return $model->user->jawatan->fname;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => 'Department',
                    'value' => function($model) {
                        return $model->user->penempatan ? $model->user->penempatan->department->fullname : ' ';
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'label' => '',
                    'value' => function($model) {
                        return Html::a('Resume', ['view-cv', 'id' => sha1($model->user->ICNO), 'title' => 'personal'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                    },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'text-center', 'width' => '30px'],
                        ],
                        [
                            'label' => '',
                            'value' => function($model) {

                                return Html::a('Criteria', ['criteria-check', 'gred' => $model->jawatan->id, 'icno' => sha1($model->user->ICNO)], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                            },
                                    'format' => 'raw',
                                    'contentOptions' => ['class' => 'text-center', 'width' => '30px'],
                                ],
                                [
                                    'class' => 'yii\grid\CheckboxColumn',
                                    'checkboxOptions' => function ($model) {

                                        return ['value' => $model->ICNO, 'id' => $model->ICNO, 'onclick' => 'check(this.value, this.checked)'];
                                    }
                                        ],
                                    ];



                                    echo GridView::widget([
                                        'options' => ['id' => 'cvs'],
                                        'dataProvider' => $Verify,
                                        'columns' => $gridColumns,
                                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                        'beforeHeader' => [
                                            [
                                                'columns' => [],
                                                'options' => ['class' => 'skip-export'] // remove this row from export
                                            ]
                                        ],
                                        'toolbar' => [
                                        ],
                                        'bordered' => true,
                                        'striped' => false,
                                        'condensed' => false,
                                        'responsive' => true,
                                        'hover' => true,
                                    ]);
                                    ?> 
                                </div> 
                            </div>
                        </div>  


                        <?php
                        $icno = '';
                        foreach ($Verify->query->all() as $d) {
                            $icno = $icno . ',' . $d->ICNO;
                        }
                        ?>
                        <script>
                            document.getElementsByClassName("select-on-check-all")[0].setAttribute("onclick", "selectall(this.checked)");
                            var inputs = document.getElementsByTagName('input');
                            var is_checked = false;
                            var t = '';
                            document.getElementsByClassName("select-on-check-all")[0].checked = true;
                            for (var x = 0; x < inputs.length; x++) {
                                if (inputs[x].type == 'checkbox' && inputs[x].name == 'selection[]') {
                                    is_checked = inputs[x].checked;
                                    if (is_checked == false) {
                                        document.getElementsByClassName("select-on-check-all")[0].checked = false;
                                    }
                                }
                            }
                            var data = sessionStorage.getItem('checkedcv');
                            var icno = data.split(',');
                            for (i = 0; i < icno.length; i++) {
                                var element = document.getElementById(icno[i]);
                                if (typeof (element) != 'undefined' && element != null)
                                {
                                    element.checked = true;
                                }
                            }
                            function selectall(c) {
                                var icno = "<?= $icno ?>";
                                var icno1 = icno.split(',');
                                var data = sessionStorage.getItem('checkedcv');
                                if (data == null) {
                                    data = '';
                                }
                                if (c === true) {
                                    for (i = 0; i < icno1.length; i++) {

                                        if (data.includes(icno1[i])) {
                                        }
                                        else {
                                            data = data + ',' + icno1[i];
                                        }
                                    }
                                }
                                else {
                                    for (i = 0; i < icno1.length; i++) {
                                        if (data.includes(icno1[i])) {
                                            data = data.replace(',' + icno1[i], '');
                                            data = data.replace(icno1[i], '');
                                        }
                                    }

                                }
                                sessionStorage.setItem('checkedcv', data);
                            }

                            function check(val, c) {
                                var data = sessionStorage.getItem('checkedcv');
                                if (c === true) {
                                    data = data + ',' + val;
                                }
                                else {
                                    data = data.replace(',' + val, '');
                                    data = data.replace(val, '');
                                }
                                sessionStorage.setItem('checkedcv', data);
                            }

                            function test() {
        var gred = "<?= $request->get('id') ?>"; 
        var status = "<?= $request->get('status') ?>"; 
        var data = sessionStorage.getItem('checkedcv');
        var keys = $('#cvs').yiiGridView('getSelectedRows');
        window.open("laporan?gred="+gred+"&&status="+status, '_blank');
    }

</script>


