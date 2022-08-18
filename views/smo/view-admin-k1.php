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
        'detail:html',
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
<table class="table table-striped table-sm jambo_table table-bordered">
    <thead>
        <tr class="headings">
            <th class="text-center">Bil</th>
            <th class="text-center">Ulasan</th>
            <th class="text-center">Tindakan</th>
        </tr>
    </thead>
    <?php if ($responList) { ?>
        <?php foreach ($responList as $v) { ?>
            <tr>
                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                <td><?= $v->ulasan ?></td>
                <td>
                    <?= $v->bio->CONm ?>
                    <br>
                    <?= $v->create_dt ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="3" class="text-center"><i>-- Tiada Respon setakat ini --</i></td>
        </tr>
    <?php } ?>
</table>