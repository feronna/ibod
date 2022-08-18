<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
//use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Negara; 

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
<div class="col-md-12 col-xs-12"> 
    
<!--        <div class="x_title">
        <h2><strong>Elaun Pakaian Panas</strong></h2>
         
    <div class="clearfix"></div>
    </div> -->
    <div class="row"> 
    <div class="x_panel">
    <div class="x_title">
        <h2><strong> NEGARA YANG TERLETAK DI ATAS GARISAN SARTAN (GS) ATAU DI BAWAH GARISAN JADI (GJ)</strong></h2> 
    <div class="clearfix"></div> 
    </div>
        
    <div class="x_content"> 
        <div align="justify"><strong> Negara yang layak: </strong>Afrika Selatan, Amerika Syarikat, Austria, Bangladesh, Belgium, Canada, Denmark, Finland, German,
        Iran, Iraq, Ireland, Itali, Jepun, Jordan, Korea Selatan, Libya, Maghribi, Mesir, Netherland, New Zealand, Pakistan, Perancis, 
        Rusia & Ukraine, Sepanyol, Sweeden, Switzerland, Syria, Turki, United Kingdom,<br>
        <div align="justify"><strong> Negara yang layak sebahagiannya: </strong>Australia, China, India, Arab Saudi<br>
        <strong>Negara Yang tidak layak:</strong> Indonesia, Brunei, Filipina, Singapura, Thailand, Taiwan, Hong Kong, Republik Of Yemen, Sudan, Sri Lanka.</div>
        <strong>Perhatian: Kakitangan hanya layak memohon elaun ini sekali sahaja dalam tempoh 3 tahun.</strong>
        </div>
    </div>
    </div>
    </div>
        
    
    <div class="row">  
        <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> BUTIR-BUTIR TEMPAT BERTUGAS / PERJALANAN / KURSUS DI LUAR NEGARA</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PEMAKAIAN ELAUN PAKAIAN PANAS</center></th>
                <tr>
                        <td valign="5">Nama Pegawai:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-8 col-sm-8 col-xs-10"> 
                             <?= $form->field($model, 'icno')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                            </div>
                        </td>
                </tr>
                <tr>
                        <td valign="5">Butiran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?= $form->field($model, 'butiran')->label(false)->widget(Select2::classname(), [
                                'data' => ['Tugas Rasmi' => 'Tugas Rasmi', 
                                'Kursus Pendek' => 'Kursus Pendek',
                                'Kursus Panjang' => 'Kursus Panjang',
                             ],
                                'options' => [
                                        'placeholder' => 'Sila Pilih'],

                            ]); ?> 
                            </div>
                        </td>
                </tr>

                <tr>
                        <td valign="5">Tujuan:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                            <?= $form->field($model, 'tujuan')->textInput(['maxlength' => true, 'placeholder' => 'Mesyuarat/Seminar/Lawatan/Kursus yang dihadiri']) ->label(false);?>
                            </div>
                        </td>

                </tr> 
                 <tr>
                        <td valign="5">Nama Tempat:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                            <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true]) ->label(false);?> 
                            </div>
                        </td>

                </tr> 
             <tr>
                        <td valign="5">Negara:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?= $form->field($model, 'negara')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'Country', 'Country'),
                            'options' => [
                            'placeholder' => 'Pilh Negara'],
                            ])->label(false); ?>
                            </div>
                        </td>

                </tr> 
                 
                
                <tr>
                        <td valign="1">Dari:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1"><?= $form->field($model, 'date_from')->widget(DatePicker::className(),
                                ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'startDate'=>date('date_from'), 'minDate'=>'0','format' => 'yyyy-mm-dd', 'autoclose' => true],
                                'options' => [ 'placeholder' => 'Select Date ', 'onchange' => 'cal()', 'id' => 'date_from' ]])
                        ->label(false);?> </td>
                        <td valign="1">Hingga:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1"><?= $form->field($model, 'date_to')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true,'startDate'=>date('date_from'), 'minDate'=>'0', 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  'options' => [ 'placeholder' => 'Select Date ', 'onchange' => 'cal()', 'id' => 'date_to' ]])
                         ->label(false);?>  </td>
                        <td valign="1">Tempoh:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1">
                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                             <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>
                            </div>
                        </td>
 
                 </div> 
                </tr>
                
                 
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Dokumen LN 1:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                    <td valign="4">Dokumen Kelulusan:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td> 
                </tr>
        </thead>
             </table> 

        <div style="color: green; margin-top: 0px;">
                   <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div>
            <?php // $form->field($model, 'jeniskemudahan')->hiddenInput(['value' =>  $id = Yii::$app->request->get('id')])->label(false)?>
        </div>
         
        </div>
        </div>  
       </div>
    </div> 
        </div>  
     <div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Kelulusan Ketua BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $form->field($model, 'ver_date')->hiddenInput()->label(false)?>
            <div class="col-md-10 col-sm-10 col-xs-12">
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua BSM : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
               <?= $form->field($model, 'pelulus_by')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(app\models\elnpt\Tblprcobiodata::find()->all(), 'ICNO', 'CONm'),
                            'options' => [
                            'placeholder' => 'Name'],
                            ])->label(false); 
                    ?>
                </div>
            </div>
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diluluskan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_date')->widget(DatePicker::className(),
                                ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true,   'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                'options' => [ 'placeholder' => 'Select Date ',   ]])
                        ->label(false);?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                <?= $form->field($model, 'status_kj')->label(false)->widget(Select2::classname(), [
                    'data' => [
                        
                        'DILULUSKAN' => 'DILULUSKAN', 
//                        'TIDAK DILULUSKAN' => 'TIDAK DILULUSKAN',
                        ],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div> 
             
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_kj')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
            </div>
             
                
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?> 
            <button class="btn btn-primary" type="reset">Reset</button>
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
