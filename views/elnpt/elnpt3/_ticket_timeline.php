<?php

use yiister\gentelella\widgets\Timeline;

foreach ($timeline as $ind => $t) {
    $timeline[$ind]['content'] = $t['content'] . (isset($t['filehash']) ? (' ' . yii\helpers\Html::a(
        "<sub>View Attachment</sub> <i class='fa fa-file' aria-hidden='true'></i>",
        yii\helpers\Url::to(['elnpt3/view-file', 'hashfile' => $t['filehash'], 'lppid' => $lppid]),
        ['data-pjax' => 0, 'target' => '_blank']
    )) : '');
}
?>
<?=
Timeline::widget(['items' => $timeline]);
?>