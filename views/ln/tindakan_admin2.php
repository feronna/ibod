<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
//use app\models\hronline\Negara;
use dosamigos\datepicker\DatePicker;
use kartik\number\NumberControl;
/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("date_to").value);
                var pickdt = new Date(document.getElementById("date_from").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }
        function cal(){
        if(document.getElementById("date_to")){
            document.getElementById("days").value=GetDays();
        }  
    }
</script>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> LAMPIRAN A</strong></h2>
            <p align="right"> 
                <?php 
                echo Html::a('<i class="fa far fa-hand-point-up"></i> Cetak Borang', ['cetak-lampiran', 'id' => $model->id,
                    'target'=>'_blank'], [
                    'class'=>'btn btn-primary btn-sm', 
                    'target'=>'_self', 
                    'data-toggle'=>'tooltip', 
                    'title'=>'Lampiran A'
                ]);
                ?>
                <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>
            </p> 
            <div class="clearfix"></div>
        </div>
    <div class="col-md-12 col-xs-12">

    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon / Ketua Rombongan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. IC</label>  
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Pekerja</label>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Hakiki</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                     <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>                 
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan/Fakulti/Pusat/Institut</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan Pentadbiran</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">       
                        <?php if($model->kakitangan->adminpos->adminpos != NULL){?>                   
                        <?= $model->kakitangan->adminpos->adminpos->position_name . " (" . $model->kakitangan->adminpos->dept->fullname . ")"; ?>                    
                        <?php }else{
                        echo "Tidak Berkaitan";
                        }?>     
                    </div>                 
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Dokumen Sokongan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Lampiran A:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php if($model->lampiran_a!= NULL){?> 
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->lampiran_a), true); ?>" target="_blank" ><i></i><u>Lampiran A.pdf</u></a><br>
                        <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        
    
    </div>  
    </div>
    <?php ActiveForm::end(); ?>
        
    </div>   
    </div>
</div>
</div>
