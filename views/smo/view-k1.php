
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>

<?php

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Fungsi Operasi',
            'attribute' =>  'fungsiRel.numDetail',
        ],
        [
            'label' => 'Pemberi Maklumbalas ',
            'attribute' =>  'staffBio.CONm',
        ],
        'detail:html',               // title attribute (in plain text)
        [
            'attribute' => 'file',
            'label' => 'Lampiran',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->doc_name) {
                    return Html::a('<i class="fa fa-search">&nbsp;</i>'  . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'class' => 'btn btn-sm btn-success']);
                } else {
                    return 'Not Available';
                }
            }

        ],
        'statusRel.detail:html',    // description attribute in HTML
        'create_dt:datetime', // creation date formatted as datetime
        'update_dt:datetime', // creation date formatted as datetime
    ],
]);

?>