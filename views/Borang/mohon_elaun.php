<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
//use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Negara;
use app\models\kemudahan\Reftujuanelaun;
use kartik\grid\GridView;

?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1303], 'vars' => []]); ?>

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
    <div class="x_panel">
        <div class="x_title">
        <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Kemudahan Elaun Pakaian Panas</strong></h2>
        <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
    <div class="clearfix"></div>
    </div> 
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
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
            </div>
                
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
            </div>
                
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
            </div>
                
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
             <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div> 
            </div>
                
             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ A/ F/ P/ I/ B <span class="required"></span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
            <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div> 
            </div>
                
            <div class="form-group"> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
            <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
             <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>
            </div>
                
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
            <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div> 
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
            <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            <?php // $form->field($model->rekod, 'destinasi')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
            </div>         
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COHPhoneNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                    
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. UC<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
                 
        </div>
                 
            </div>
        </div>
    </div>
</div>
    
    
        

<div class="row"> 
    <div class="x_panel"> 
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>REKOD PEMAKAIAN ELAUN PAKAIAN PANAS</strong></h2>
          <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 'Mesyuarat/ Seminar/ Lawatan/ Kursus'], 
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                
                                ],
            [
                'label' => 'Tarikh',
                'value' => 'entrydate'
            ],
//            [
//                'label' => 'Butiran',
//                'value' => 'butiran'
//            ],
            [
                'label' => 'Tujuan',
                 'value'=> 'tujuan',
            ], 
            [
                'label' => 'Destinasi',
                'value' => 'nama_tempat'
            ],
//             [
//                'label' => 'Jumlah',
//                'value' => 'jumlah'
//            ],
            
        ],
    ]); ?>
 
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
                        <td valign="5">Butiran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?php $form->field($model, 'butiran')->label(false)->widget(Select2::classname(), [
                                'data' => ['Tugas Rasmi' => 'Tugas Rasmi', 
                                'Kursus Pendek' => 'Kursus Pendek',
                                'Kursus Panjang (Cuti Belajar)' => 'Kursus Panjang (Cuti Belajar)',
                             ],
                                'options' => [
                                        'placeholder' => 'Sila Pilih'],

                            ]); ?> 

                        <?=
                           $form->field($model, 'butiran')->widget(Select2::classname(), [
                            'name' => 'butiran',
                            'data' => \yii\helpers\ArrayHelper::map(Reftujuanelaun::find()->all(),'id', 'tujuan'),
                             'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' => 'javascript:if ($(this).val() == "1"){
                                    $("#tugas-rasmi").show();
                                         }
                                    else{
                                    $("#kursus-pendek").hide();
                                    $("#tugas-rasmi").hide();
                                    }'
                                 ],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>

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
                        <td valign="2">Nama Tempat:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                            <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true]) ->label(false);?> 
                            </div>
                        </td>
                        <td valign="2">Negara:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?= $form->field($model, 'negara')->widget(Select2::classname(), 
                            ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'Country', 'Country'),
                            'options' => [
                            'placeholder' => 'Pilh Negara'],
                            ])->label(false); ?>
                        </td>
 
                 </div> 
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
        <th scope="col" colspan=4" width="15%" style="background-color:lightgrey;"> </th>

                <tr id="tugas-rasmi">
                    <td valign="2">Dokumen LN 1:<span class="required" style="color:red;">*</span></td>
                    <td colspan="2"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                </tr>
                <tr >
                    <td  valign="2">Surat Kelulusan:<span class="required" style="color:red;">*</span></td>
                    <td colspan="2"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td> 
                </tr>
        </thead>
             </table> 

        <div style="color: green; margin-top: 0px;">
                   <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div>
            <?= $form->field($model, 'jeniskemudahan')->hiddenInput(['value' =>  $id = Yii::$app->request->get('id')])->label(false)?>
        </div>
         
        </div>
        </div>  
       </div>
    </div> 

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PENGAKUAN PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
         <table>
             <tr>
            <td class="col-sm-2 text-right">
                  <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
            </td>

            <td> 
  
          <h5 style="color:black;" >Saya mengesahkan maklumat-maklumat yang dinyatakan dalam permohonan ini adalah benar dan betul.<br/> </h5>
 
            </td>
        </tr>
    </table> 
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
        </div> 
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
<script>
                 function checkTerms() {
                   // Get the checkbox
                   var checkBox = document.getElementById("checkbox1");
 
                   // If the checkbox is checked, display the output text
                   if (checkBox.checked === true){
                     document.getElementById("submitb").disabled = false;
                   } else {
                     document.getElementById("submitb").disabled = true;
                   }
                 }
                     </script>