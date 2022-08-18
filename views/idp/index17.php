<?php
use marekpetras\calendarview\CalendarView;
use yii\bootstrap\Alert;

echo $this->render('/idp/_topmenu');

echo Alert::widget([
    'options' => ['class' => 'alert-warning'],
    'body' => '<font color="black">
                    <strong>PERINGATAN</strong><br>
                    <p>
                        Sistem MyIDP ini berada di peringkat pembangunan.
                    </p>
                </font>',
]);

?>
<div class="clearfix"></div> 
<div class="row">
<div class="col-xs-12 col-md-12">
<div class="x_panel">
<div class="x_title">
<h5>Takwim Latihan</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<div class="row">
<?php    
echo CalendarView::widget(
    [
        // mandatory
        'dataProvider'  => $dataProvider,
        'dateField'     => 'tarikhMula',
        //'valueField' => 'kursusLatihanID',
        'valueField' => function ($data){
                            $that =& $this; // Assign by reference here!
                            return $result = function () use ($that, $data) // Don't forget to actually use $that
                            {
                                return ($that->sasaran3->tajukLatihan[$data]); //a float number
                            };
                            
                            echo "a";
                        },
                        
//                        echo "a";


        // optional params with their defaults
        'weekStart' => 1, // date('w') // which day to display first in the calendar
        'title'     => '',

        'views'     => [
            'calendar' => '@vendor/marekpetras/yii2-calendarview-widget/views/calendar',
            'month' => '@vendor/marekpetras/yii2-calendarview-widget/views/month',
            'day' => '@vendor/marekpetras/yii2-calendarview-widget/views/day',
        ],

        'startYear' => date('Y') - 1,
        'endYear' => date('Y') + 1,

        'link' => false,
        /* alternates to link , is called on every models valueField, used in Html::a( valueField , link )
        'link' => 'site/view',
        'link' => function($model,$calendar){
            return ['calendar/view','id'=>$model->id];
        },
        */

        'dayRender' => false,
        /* alternate to dayRender
        'dayRender' => function($model,$calendar) {
            return '<p>'.$model->id.'</p>';
        },
        */

    ]
);

?>
</div>
</div>
</div>
</div>
</div>