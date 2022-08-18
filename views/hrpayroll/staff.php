<?php
/* @var $this yii\web\View */

use kartik\tabs\TabsX;
use yii\web\UrlManager;
use yii\helpers\Html;
use yii\helpers\Url;

$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\widgets\DetailView;
use yii\bootstrap\Modal;

$items = [
    [
        'label' => 'Gaji',
        'content' =>  $this->render('staff/_gajiTab', ['dataProvider' => $gaji,]),
        'active' => true

    ],
    [
        'label' => 'Akaun',
        'content' =>  $this->render('staff/_akaunTab', ['dataProvider' => $akaun,]),
        //'url' =>  ['borangehsan/senaraitindakan'], 
    ],
    [
        'label' => 'LPG/KEW8',
        'content' =>  $this->render('staff/_lpgTab', ['dataProvider' => $lpg, 'staff_id'=>$bio->COOldID]),
        //'url' =>  ['borangehsan/senaraitindakan'], 
    ],
    [
        'label' => 'Pendapatan',
        'content' =>  $this->render('staff/_pendapatanTab', ['dataProvider' => $dataProvider4,]),
        //'url' =>  ['borangehsan/senaraitindakan'], 
    ],
    [
        'label' => 'Potongan',
        'content' =>  $this->render('staff/_potonganTab', ['dataProvider' => $dataProvider4,]),
        //'url' =>  ['borangehsan/senaraitindakan'], 
    ],
    [
        'label' => 'Kenaikan',
        'content' =>  $this->render('staff/_kenaikanTab', ['dataProvider' => $dataProvider4,]),
        //'url' =>  ['borangehsan/senaraitindakan'], 
    ],
];

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

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Staff</strong></h2>
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
                                'label' => '',
                                'value' => "https://hronline.ums.edu.my/picprofile/picstf/" . strtoupper(sha1(($bio->ICNO))).".jpeg",
                                'format' => ['image', ['width' => '100', 'height' => '100']],
                            ],
                            [                      // the owner name of the model
                                'label' => 'UMSPER',
                                'value' => $bio->COOldID
                            ],
                            [                      // the owner name of the model
                                'label' => 'Nama',
                                'value' => (is_null($bio->gelaran) ? '' : $bio->gelaran->Title . ' ') . $bio->CONm
                            ],
                            [                      // the owner name of the model
                                'label' => 'Jantina',
                                'value' => $bio->jantina->Gender
                            ],
                            [                      // the owner name of the model
                                'label' => 'Lokasi',
                                'value' => $bio->kampus->campus_name
                            ],
                            [                      // the owner name of the model
                                'label' => 'JFPIU',
                                'value' => $bio->department->fullname
                            ],
                            [                      // the owner name of the model
                                'label' => 'Jawatan',
                                'value' => $bio->jawatan->fname
                            ],
                            [                      // the owner name of the model
                                'label' => 'Tarikh Lantikan',
                                'value' => $bio->startDateLantik
                            ],
                            [                      // the owner name of the model
                                'label' => 'Status Perkhawinan',
                                'value' => $bio->DisplayTarafPerkahwinan
                            ],
                            [                      // the owner name of the model
                                'label' => 'Status',
                                'value' => $bio->DisplayServiceStatus
                            ],
                            //                            'created_at:datetime', // creation date formatted as datetime
                        ],
                    ]);

                    ?>
                </div>

                <div class="row">
                    <?=
                        TabsX::widget(['items' => $items, 
                                       'position' => TabsX::POS_ABOVE, 
                                       'bordered' => true, 
                                       'encodeLabels' => false, 
                                       'align' => TabsX::ALIGN_LEFT
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>