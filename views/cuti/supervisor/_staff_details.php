<?php 
use yii\widgets\DetailView;


?>
<div class="x_content">

<div class="table-responsive">
    <?=
        DetailView::widget([
            'model' => $biodata,
            'attributes' => [
                [
                    'label' => 'Nama / Name',
                    'attribute' => 'CONm',
                ],
                [
                    'label' => 'ICNO/Passport',
                    'attribute' => 'ICNO',
                ],
                [
                    'label' => 'UMSPER',
                    'attribute' => 'COOldID',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],
                [
                    'label' => 'Jawatan / Position',
                    'attribute' => 'jawatan.fname',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],
                [
                    'label' => 'JFPIB',
                    'attribute' => 'department.fullname',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],
                [
                    'label' => 'Jenis Lantikan / Appointment Type',
                    'attribute' => 'displaystatuslantikan',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],
                [
                    'label' => 'Tarikh Lantikan / Appointment Date',
                    'attribute' => 'displaystarttoendlantik',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],
                [
                    'label' => 'Status',
                    'attribute' => 'displayservicestatus',
                    'contentOptions' => ['style' => 'width:auto'],
                    'captionOptions' => ['style' => 'width:26%'],
                ],

            ],
        ])
    ?>
</div>
</div>
