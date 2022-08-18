<?php

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });

    $('.modalButtonn').on('click', function () {
        $('#modall').modal('show')
                .find('#modalContentt')
                .load($(this).attr('value'));
    });

    $(document).on('click', '.showModalButton', function() {
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                .load($(this).attr('value'));
            //dynamiclly set the header for the modal via title tag
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            //dynamiclly set the header for the modal via title tag
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });

    $('.pjax-delete-link').on('click', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('delete-url');
        var pjaxContainer = $(this).attr('pjax-container');
        var result = confirm('Are you sure you want to delete this item?');                                
        if(result) {
            $.ajax({
                url: deleteUrl,
                type: 'post',
                error: function(xhr, status, error) {
                    alert('There was an error with your request.' + xhr.responseText);
                }
            }).done(function(data) {
                $.pjax.reload({container: '#' + $.trim(pjaxContainer), timeout: false});
            });
        }
    });

    $(document).on('ready pjax:success', function() {
        $('.pjax-delete-link').on('click', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url');
            var pjaxContainer = $(this).attr('pjax-container');
            var result = confirm('Are you sure you want to delete this item?');                                
            if(result) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function(xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function(data) {
                    $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
                });
            }
        });
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_searchAktiviti', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Kalendar Perancangan Aktiviti 2021</strong></h2>
                <?= Html::button('Tambah Aktiviti', ['value' =>  Url::to(['i-kalendar/create']), 'class' => 'pull-right btn-success btn-sm showModalButton', 'title' => 'Tambah Aktiviti']) ?>
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
                echo '<div class="modal-footer">';
                echo '    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                echo '</div>';
                Modal::end();
                ?>

                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'my_pjax']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        // 'filterModel' => $searchModel,
                        // 'layout' => '{items}\n{pager}',
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'BULAN',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->eventDate->date ?? '', 'php: M');
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'TARIKH',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->eventDate->date ?? '', 'php:d-m-Y');
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'NAMA AKTIVITI',
                                'headerOptions' => ['class' => 'text-center'],
                                // 'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    return $model->title;
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'PERINGKAT',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return 'Peringkat';
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'KATEGORI',
                                'headerOptions' => ['class' => 'text-center'],
                                // 'contentOptions' => ['class'=>'text-center'],
                                'value' => function ($model) {
                                    return $model->eventCat->name;
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'STATUS',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    $tmp = $model->eventStat->name == 'Selesai';
                                    return ($tmp ? '<font style="color:green">' : '<font style="color:#73879C">') . $model->eventStat->name . '</font>';
                                },
                                'format' => 'html'
                            ],
                            [
                                'label' => 'TARIKH SELESAI/TUNDA',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asDate($model->tarikh_tunda, 'php:d-m-Y');
                                },
                                'format' => 'html'
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'ACTION',
                                'headerOptions' => ['class' => 'text-center col-md-1'],
                                'contentOptions' => ['class' => 'text-center'],
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        $url = Url::to(['i-kalendar/update', 'id' => $model->event_id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm showModalButton', 'title' => 'Kemaskini Aktiviti']);
                                    },
                                    'delete' => function ($url, $model) {
                                        $url = Url::to(['i-kalendar/delete', 'id' => $model->event_id]);
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                            'class' => 'btn btn-default btn-sm pjax-delete-link',
                                            'delete-url' => $url,
                                            'pjax-container' => 'my_pjax',
                                            'title' => Yii::t('yii', 'Delete')
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>