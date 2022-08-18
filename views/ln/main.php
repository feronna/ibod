<?php
use yii\helpers\Html; 
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
error_reporting(0);

?>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>  

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">      
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Bertugas Rasmi Di Luar Negara </strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?></p>      
            <div class="clearfix"></div>
        </div>
        
    <div class="x_content">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="startdate">Tarikh Pergi: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <?= $form->field($model, 'date_from')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'startDate'=>date('date_from'),
                        'minDate' => '0',
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'date_from',
                        'onchange' => 'javascript:
                        var selected = ($(this).val()).substr(3,2)+"/"+($(this).val()).substr(0,2)+"/"+($(this).val()).substr(6,4);
                        var t = new Date($(this).val());
                        var today = new Date();
                        today.setHours(0);
                        today.setMinutes(0);
                        today.setSeconds(0);
                        if (Date.parse(today)+1209600000 > Date.parse(t)) {
                            alert("Permohonan perjalanan adalah kurang daripada 14 hari, sila berhubung dengan urusetia dengan mengemukakan justifikasi permohonan lewat dan diemail kepada urusetia.");
                            $(this).val() = NULL;
                        }
//                         else {
//                           alert("");
//                        }'
                    ]
                ])->label(false);
                ?>
            </div>
    </div>

<!--    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="enddate">Tarikh Balik: <span class="required" style="color:red;">*</span>  
        </label>
            <div class="col-md-3 col-sm-3 col-xs-10"> 
            <= $form->field($model, 'date_to')->widget(DatePicker::className(),
                    ['clientOptions' => ['changeMonth' => true,
                        'yearRange' => '1996:2099',
                        'changeYear' => true, 
                        'format' => 'yyyy-mm-dd', 
                        'autoclose' => true],
                        'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                        'id' => 'date_to' 
                    ]
                ])->label(false);
                ?>
            </div>
    </div>-->

    <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
        <button class="btn btn-primary" type="reset">Reset</button>
        <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan tarikh permohonan adalah tepat. Permohonan yang dihantar hendaklah diterima sampai ke Pejabat Canselori tidak kurang dari tempoh 14 hari sebelum perjalanan. Teruskan?' ]]) ?>
    </div>
    </div>  

    <?php ActiveForm::end(); ?>
    
    </div> 
    </div>
    </div>
</div>