<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

?>

<?php

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [                      // the owner name of the model
            'label' => 'Pengadu',
            'value' => $model->staffBio->CONm,
        ],
        'title',               // title attribute (in plain text)
        'detail:html',               // title attribute (in plain text)
        [
            'attribute' => 'file',
            'label' => 'Bukti gambar / Dokumen',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->doc_name) {
                    return Html::a($model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'class' => 'btn btn-sm btn-success']);
                } else {
                    return 'Not Available';
                }
            }

        ],
        'status:html',    // description attribute in HTML
        'create_dt:datetime', // creation date formatted as datetime
        'update_dt:datetime', // creation date formatted as datetime
        'bhgnRel.bahagian',
        'kriteriaRel.kriteria_label',
        'kriteriaRel.kriteria',
    ],
]);

?>

<h3></h3>
<hr>
<?php

echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'ulasan:html',
        'syor:html',
        'bio.CONm',
        'create_dt:datetime',
    ],
]) ?>