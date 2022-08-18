<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
?>
<?php if (!$model) { ?>
<?php //\yii\helpers\VarDumper::dump($model,true,10)?>
    <?php

//    $items = [
//        [
//            'label' => '<i class="fa fa-language"></i>&nbsp;Bahasa Malaysia',
//            'content' => $this->render('_content_bm', ['model' => $model, 'bio'=>$bio, 'date'=>$date]),
//            'active' => true
//        ], [
//            'label' => '<i class="fa fa-language"></i>&nbsp;English',
//            'content' => $this->render('_content_bi', ['model' => $model, 'bio'=>$bio, 'date'=>$date]),
//        ],
//    ];
//    $content = TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
    
    $content = $this->render('_content', ['model' => $model, 'bio'=>$bio, 'date'=>$date])
    ?>


    <?php

    Modal::begin([
        'header' => '<h2>PDPA CONSENT AND AGREEMENT</h2>',
        'id' => 'modal',
        'size' => 'modal-lg',
        'closeButton' => false,
        'clientOptions' => [
            'backdrop' => 'static',
            'keyboard' => false
        ],
    ]);
    echo "<div id='modalContent'>" . $content . "</div>";
    Modal::end();
    ?>


    <?php

    $js = <<<js

        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));

js;
    $this->registerJs($js);
    ?>
<?php } ?>