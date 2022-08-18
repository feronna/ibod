
<?php

use yii\widgets\DetailView;

?>

<?php

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [                      // the owner name of the model
            'label' => 'Nama Kakitangan',
            'value' => $model->staffBio->CONm,
        ],
        'title',               // title attribute (in plain text)
        'typeText',               // title attribute (in plain text)
        'favIcon:html',               // title attribute (in plain text)
        'detail:html',    // description attribute in HTML
        'due_date:html',    // description attribute in HTML
        'statusText:html',    // description attribute in HTML
        'create_dt:datetime', // creation date formatted as datetime
        'update_dt:datetime', // creation date formatted as datetime
    ],
]);
