<?php
/* @var $this yii\web\View */

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\bootstrap\Alert;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php
    Modal::begin([
        'header' => '',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Rekod LPG</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    echo DetailView::widget([
                        'model' => $bio,
                        'attributes' => [
//                            'title',               // title attribute (in plain text)
//                            'description:html',    // description attribute in HTML
                            [                      // the owner name of the model
                                'label' => 'Nama',
                                'value' => (is_null($bio->gelaran) ? '' : $bio->gelaran->Title.' ').$bio->CONm
                            ],
                            [                      // the owner name of the model
                                'label' => 'KP / Pasport',
                                'value' => $bio->ICNO
                            ], 
                            [                      // the owner name of the model
                                'label' => 'Jawatan',
                                'value' => $bio->jawatan->fname
                            ],
                            [                      // the owner name of the model
                                'label' => 'JSPIU',
                                'value' => $bio->department->fullname
                            ],
                            [                      // the owner name of the model
                                'label' => 'Jenis Lantikan',
                                'value' => $bio->statusLantikan->ApmtStatusNm
                            ],
//                            'created_at:datetime', // creation date formatted as datetime
                        ],
                    ]);
                    
                    ?>
                </div>
                
                <div class="row">
                
                <?= Html::button('Tambah Rekod LPG', ['value' => Url::to(['saraan/tambah-lpg', 'icno' => $bio->ICNO]), 'class' => 'btn-success btn-sm modalButton']); ?>
                
                </div>    
                    
                <div class="row">
                    <div class="table-responsive">
                    <?=
                            GridView::widget([
                                //'tableOptions' => [
                                  //  'class' => 'table table-striped jambo_table',
                                //],
                                'emptyText' => 'Tiada Rekod',
//                                'pager' => [
//                                    'class' => \kop\y2sp\ScrollPager::className(),
//                                    'container' => '.grid-view tbody',
//                                    'triggerOffset' => 10,
//                                    'item' => 'tr',
//                                    'paginationSelector' => '.grid-view .pagination',
//                                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
//                                 ],
                                'summary' => '',
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'BIL',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                    ], 
                                    [
//                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'TARIKH KUATKUASA',
                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model){
                                            return $model->t_lpg_date_start;
                                        }
                                    ],
//                                    [
//                                        'class' => 'kartik\grid\ExpandRowColumn',
//                                        'value' => function($model, $key, $index, $column) {
//                                            return GridView::ROW_EXPANDED;
//                                        },
//                                        'detail' => function($model, $key, $index, $column) {
//                                            $searchModel = new app\models\gaji\Tblrscoelaun();
//                                            $searchModel->el_lpg_id = $model->t_lpg_id;
//                                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                                            
//                                            return Yii::$app->controller->renderPartial('_elaun', [
//                                                'searchModel' => $searchModel,
//                                                'dataProvider' => $dataProvider,
//                                            ]);
//                                        },
//                                        'headerOptions' => ['class' => 'text-center'], 
//                                        'contentOptions' => ['class' => 'text-center'],         
//                                        'expandOneOnly' => true
//                                    ],
                                    [
//                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'JENIS LPG',
                                        'headerOptions' => ['class'=>'text-center'],
//                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model){
//                                            return '<dl class="dl-horizontal">
//                                            <dt>No. Siri</dt>
//                                            <dd>'.$model->t_lpg_id.'</dd>
//                                            <dt>Jawatan</dt>
//                                            <dd>'.$model->jawatan->fname.'</dd>
//                                            <dt>Jenis</dt>
//                                            <dd>'.($model->jenisLpg->lpgNm).'</dd>    
//                                            <dt>Catatan</dt>
//                                            <dd>'.$model->t_lpg_remark.'</dd>
//                                            <dt>Pegawai Pengesah</dt>
//                                            <dd>'.$model->pengesah->CONm.'</dd>
//                                            <dt>Tarikh Sah</dt>
//                                            <dd>'.$model->t_lpg_ver_by_datetime.'</dd>       
//                                          </dl>';
                                            
                                            return '<table class="table table-sm table-bordered">'
                                                    . '<tr><th>No. Siri</th><td>'.$model->t_lpg_id.'</td></tr>'
                                                    . '<tr><th>Jawatan</th><td>'.$model->jawatan->fname.'</td></tr>'
                                                    . '<tr><th>Jenis</th><td>'.($model->jenisLpg->lpgNm).'</td></tr>'
                                                    . '<tr><th>Catatan</th><td>'.$model->t_lpg_remark.'</td></tr>'
                                                    . '<tr><th>Pegawai Pengesah</th><td>'.(is_null($model->pengesah) ? '' : $model->pengesah->CONm).'</td></tr>'
                                                    . '<tr><th>Tarikh Sah</th><td>'.$model->t_lpg_ver_by_datetime.'</td></tr>'
                                                    . '</table>';
                                        },
                                        'format' => 'raw',
                                    ],
                                    [
//                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'MAKLUMAT GAJI POKOK / ELAUN',
                                        'headerOptions' => ['class'=>'text-center'],
//                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model){
                                            $list = array();
                                            
                                            $sum = 0;
                                            
                                            $list[] = '<tr>'
                                                            . '<th>GAJI POKOK</th>'
                                                            . '<td>'.Yii::$app->formatter->asDecimal($model->t_lpg_amount).'</td>'
                                                            . '</tr>';
                                            
                                            $sum += $model->t_lpg_amount;
                                            
                                            if(!is_null($model->elaun)) {
                                                foreach($model->elaun as $el){
                                                    $list[] = '<tr>'
                                                            . '<th>'.$el->elaunName->nama_ringkas.'</th>'
                                                            . '<td>'.Yii::$app->formatter->asDecimal($el->el_amount).'</td>'
                                                            . '</tr>';
                                                    
                                                    $sum += $el->el_amount;
                                                }
                                            }
                                            
                                            $list[] = '<tr>'
                                                            . '<th>JUMLAH</th>'
                                                            . '<td>'.Yii::$app->formatter->asDecimal($sum).'</td>'
                                                            . '</tr>'; 
                                            
                                            $row = implode("", $list);
                                            
                                            return '<table class="table table-sm table-bordered">'.
                                                    $row
                                                    . '</table>';
                                        },
                                                'format' => 'html',
                                    ],
                                    [
//                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'PERAKUAN (STATUS)',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model){
                                            return ($model->t_lpg_app_status == 'approve' ? 'Disahkan' : '');
                                        }
                                    ],            
                                    [
//                                        'class' => 'yii\grid\SerialColumn',
                                        'header' => 'PENGESAHAN (STATUS)',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model){
                                            return ($model->t_lpg_ver_status == 'approve' ? 'Disahkan' : '');
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'TINDAKAN',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'template' => '{view} {update} {delete}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                $url = Url::to(['saraan/lpg-report-2', 'lpg_id' => $model->t_lpg_id]);
                                                return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [
                                                    'title' => 'lpg', 'target' => '_blank', 'class' => 'btn btn-default btn-sm',
                                                ]);
                                            },
                                            'update' => function ($url, $model) {
                                                $url1 = Url::to(['saraan/kemaskini-lpg', 'icno' => $model->t_lpg_ICNO, 'lpg_id' => $model->t_lpg_id]);
                                                return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url1, 'class' => 'btn btn-default btn-sm modalButton']);
                                            },
                                            'delete' => function ($url, $model) {
                                                $url2 = Url::to(['saraan/padam-lpg', 'lpg_id' => $model->t_lpg_id]);
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, [
                                                    'class' => 'btn btn-default btn-sm',
                                                    'data' => [
                                                                'confirm' => 'Adakah anda ingin membuang rekod ini?',
                                                                'method' => 'post',
                                                            ],
                                                    ]);
                                                //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                                            },       
                                        ],        
                                    ],          
                                ],
                            ]);
                        ?>
               </div>
                </div>
            </div>
        </div>
    </div>
</div>