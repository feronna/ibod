<?php
use yii\helpers\Html;

use kartik\spinner\Spinner;
use yii\web\View;
use yii\helpers\Url;
use yii\web\JsExpression;

$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
    alert(calEvent.title);
    // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    // alert('View: ' + view.name);
    // change the border color just for fun
    $(this).css('border-color', 'red');
}
EOF;

?>
<div class="row">
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-book"></i> MyIDP</h2>
        <div class="clearfix"></div>
    </div>
<?= 

yii2fullcalendar\yii2fullcalendar::widget([
    'id' => 'eventFilterCalendar',
                    'options' => [
                        'lang' => 'en',
                        //... more options to be defined here!
                    ],
                    'events' => $events,
                    'clientOptions' => [
                        'selectable' => true,
                        'selectHelper' => true,
                        'droppable' => true,
                        'editable' => true,
                        'eventClick' => new JsExpression($JSEventClick),
                        'defaultDate' => date('Y-m-d')
                    ],

                ]);
?></div></div>
