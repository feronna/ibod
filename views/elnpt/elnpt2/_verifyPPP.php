<?php

use yii\helpers\Html;
use yii\helpers\Url;

if ($lpp->PPP == Yii::$app->user->identity->ICNO ? (!$check && !empty($file_hash)) : false) {
    if (!empty($ver_by)) {
        $model = app\models\elnpt\elnpt2\TblDocuments::find()->where(['lpp_id' => $lppid, 'filehash' => $file_hash])->one();
    } else {
        $model = new app\models\elnpt\elnpt2\TblDocuments();
    }

    kartik\popover\PopoverX::begin([
        'placement' => kartik\popover\PopoverX::ALIGN_LEFT_TOP,
        'toggleButton' => ['label' => 'Verify', 'class' => 'btn btn-default'],
        'header' => '<i class="glyphicon glyphicon-check"></i> Verify Document',
        'footer' => Html::button('Submit', [
            'class' => 'btn btn-sm btn-primary',
            'onclick' => "
                var check = $('#ver_checkbox_" . $ind . "').val();
                var text = $('#ver_ulasan_" . $ind . "').val();
                $.ajax(
                    
                    {
                        type: 'POST',
                        url: '" . Url::to(['elnpt2/verify-document', 'lppid' => $lppid, 'filehash' => $file_hash]) . "',
                        data: {
                            check: check,
                            ulasan: text
                        },
                        success: function(result) {
                            if(result == 1) {
                                    setTimeout(function(){
                                    location.reload(); // then reload the page.(3)
                                }, 1); 
                            } else {
                            }
                        }, 
                        error: function(result) {
                            console.log(\"Ada Error\");
                        }
                    }
                )
                ",
        ]) . Html::button('Reset', [
            'class' => 'btn btn-sm btn-default',
            'onclick' => "
                    $('#ver_checkbox_" . $ind . "').val(0);
                    $('#ver_ulasan_" . $ind . "').val('');
                "
        ]),

    ]);
    echo '<div class="row">';
    echo kartik\checkbox\CheckboxX::widget([
        'name' => 'ver',
        'value' => is_null($model->verified_by) ? 0 : 1,
        'options' => ['id' => 'ver_checkbox_' . $ind],
        'pluginOptions' => ['threeState' => false]
    ]);
    echo '<label class="cbx-label" for="ver" class="text-muted">Verify</label>';
    echo '<br>';
    echo '<label class="cbx-label" for="content">Ulasan</label>';
    echo Html::textarea('content', $model->ulasan ?? '',  ['rows' => 5, 'required' => true, 'id' => 'ver_ulasan_' . $ind, 'style' => "resize: none;", 'class' => 'form-control col-md-7 col-xs-12', 'placeholder' => 'Ulasan', 'maxlength' => 500]);
    echo '<br>';
    echo '</div>';
    kartik\popover\PopoverX::end();
} else echo '';
