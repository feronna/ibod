<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Stat Tree';
?>

<div class="well">
    <h2>Start</h2>
    <div class="row ">
        <?=
            \yiister\gentelella\widgets\Timeline::widget(
                [
                    'items' => $tree,
                ]
            )
        ?>
    </div>
    <h2>End</h2>
</div>