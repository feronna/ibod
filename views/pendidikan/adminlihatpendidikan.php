<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Lihat Pendidikan';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="tblprcobiodata-view ">
                <p>
                    <?= Html::a('Kembali', ['adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['adminupdate', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
               </p>
               <div class="table-responsive">
    <?= $this->render('_lihatpendidikan',[
        'model'=>$model,
        ]) ?>
               </div>
          </div>   
        </div>
        <br><br>

    <div class="x_content">
            <div class="tblprcobiodata-view ">
                <?php 
        if($model->HighestEduLevelCd == 13 || $model->HighestEduLevelCd == 14 || $model->HighestEduLevelCd == 15){
          echo $this->render('adminview-subjek',[
            'Edu_id' => $model->id,
            'icno' => $model->ICNO,
            'subjek' => $subjek, 
            'level' => $level,]);
        }
        ?>
          </div>   
        </div>
    </div>
    
</div>

