<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Lihat Pendidikan';
$mustadd = [13,14,15,23];
?>
<?php 
        if(in_array($model->HighestEduLevelCd, $mustadd)){ ?>
          <div class="col-md-12 col-sm-12 col-xs-12" > 
    <div class="x_panel" style="background-color:royalblue;color:black;">
        <div class="x_title">
            <h2><?= 'Nota Penting!' ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p style="font-size:15px;">: Sila skrol ke bawah dan tekan "tambah mata pelajaran" untuk menambah subjek bagi <?= $level ?> anda.</p>
              <p style="font-size:15px;">: Tekan "kemaskini" untuk mengemaskini <?= $level ?> anda.</p>
             

        </div>
    </div>
</div>
 <?php       }
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
                    <?= Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Kemaskini', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                
        if(in_array($model->HighestEduLevelCd, $mustadd)){
          echo $this->render('view-subjek',[
            'Edu_id' => $model->id,
            'subjek' => $subjek, 
            'level' => $level,]);
        }
        ?>
          </div>   
        </div>
    </div>
</div>

