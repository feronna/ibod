<?php
 
use yii\helpers\Html;
use yii\grid\GridView;
?>  
<?php echo $this->render('menu'); ?> 


<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">DICTIONARY</p>  
        <div class="clearfix"></div>
    </div>
<div class="table-responsive">   
    <?php
    $Columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Subject',
            'value' => function($model) {
                if ($model->level) {
                    return Html::a('<b>' . $model->subj . '</b>', ['view-subject', 'id' => $model->id], ['class' => 'btn btn-link btn-sm']);
                } else {
                    return '<span style="color: red;"><b>' . $model->subj . '</b></span>';
                }
            },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Description',
                    'value' => function($model) {
                        return $model->desc . Html::a('<b>View more...</b>', ['view-subject', 'id' => $model->id], ['class' => 'btn btn-link btn-sm']);
                    },
                            'format' => 'raw'
                        ],
                    ];


                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $Columns, 
                    ]);
                    ?> 
</div> 
</div>