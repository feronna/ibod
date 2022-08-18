<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\number\NumberControl;

?>

<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="col-md-12 col-xs-12"> 
<!--    <div class="x_panel">
<div class="row"> 
         <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Staf Secara Atas Talian(On-line): Pembelian Alat Komunikasi</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 ">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
             <option value="" disabled selected>Pembelian Alat Komunikasi</option>
            <option value=" ../boranglesen/form_lesen " id="8">Lesen Memandu</option>
            <option value=" ../borangpasport/form_pasport ">Pasport</option>
            <option value="../pakaian-istiadat/form_pakaian">Pakaian Istiadat</option>
            <option value="../borangehsan/form_pemohon">Tambang Belas Ehsan</option> 
            <option value="../borang-alat/maklumat-pembelian">Pembelian Alat Komunikasi</option>
            <option value="../borangyuran/maklumat-yuran">Yuran / Badan Ikhtisas</option>
            <option value="../boranguniform/maklumat-seragam">Pakaian Seragam</option>

            </select>
            </div>
            </div>
         
        </div> 
           
        </div>
    </div>
    </div>-->
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        
    <div class="row"> 
    <div class="x_panel">
    <div class="x_title">
        <h2><strong> SYARAT PEMBERIAN ALAT KOMUNIKASI MUDAH ALIH</strong></h2> 
       <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
    <div class="clearfix"></div> 
    </div>
        
    <div class="x_content"> 
        <div align="justify">a) &nbsp;Layak dipohon <strong> setiap empat (4) tahun</strong>, permohonan baru hanya boleh diluluskan selepas tempoh tersebut; <br>
            <div align="justify">b) &nbsp;Pegawai yang memegang lebih daripada satu jawatan hanya layak mendapat<strong> satu kemudahan sahaja, mengikut kadar kelayakan atau jawatan yang tertinggi; </strong><br>
                <div align="justify">c) Kemudahan pembelian set alat komunikasi mudah alih (termasuk aksesori) hanya diluluskan sekiranya resit asal pembelian disertakan <strong>(salinan resit tidak akan &nbsp;&nbsp;&nbsp;dipertimbangkan); </strong><br> 
                    <div align="justify">d) Bayaran caj bulanan diberikan sebagai <strong> Elaun Alat Komunikasi Mudah Alih </strong>dan dimasukkan terus ke dalam gaji pegawai berkenaan;<br> 
                        <div align="justify">e) Kelulusan kemudahan hendaklah dicatatkan dalam <strong> Buku Rekod Perkhidmatan </strong>pegawai; <br>
                            <div align="justify">f) Kemudahan adalah <strong> milik pegawai berkenaan </strong>dan tidak perlu direkodkan dalam Daftar Harta Modal atau Daftar Inventori Universiti;<br>    
                                <div align="justify">g) Pegawai bertanggungjawab sepenuhnya ke atas kemudahan tersebut dan <strong> tidak layak menuntut</strong> semula pembelian kemudahan baru dalam tempoh empat (4) tahun;<br>   
                                    <div align="justify">h) <strong> Universiti tidak akan bertanggungjawab </strong>atas sebarang kehilangan atau kerosakan alat komunikasi milik pegawai berkenaan.<br>   
                                    </div>
                                </div>
    </div></div></div></div></div></div></div>
    </div>
    </div>
        
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>-->
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
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
           
            </div>         
            </div>
                 
            </div>
        </div>
    </div>
</div> 

        <div class="row">  
        <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> PERMOHONAN PEGAWAI</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PEMBELIAN ALAT KOMUNIKASI</center></th>
 
                <tr>
                        <td valign="2">Jenama/Model:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model, 'jenama')->textInput(['maxlength' => true]) ->label(false);?> 
                        </td>
                        
                        <td valign="2">No.Siri:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model, 'siri')->textInput(['maxlength' => true]) ->label(false);?>  
                        </td> 
                   
                </tr>
                
                <tr>
                        <td valign="2">Harga Belian:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                         <?=
                            $form->field($model, 'jumlah_beli')->widget(NumberControl::classname(), [
                                 'name' => 'jumlah_beli',
                                   'pluginOptions'=>[
                                   'initialize' => true,
                                                            ],
                                       'maskedInputOptions' => [
                                        'prefix' => 'RM',
                                     'rightAlign' => false
                                   ],

                                 'displayOptions' => [
                                  //  'placeholder' => 'Contoh: RM223437.04'
                                          ],
                                        ])->label(false);
                            ?>
                        </td>
                        
                        <td valign="2">No.Resit:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ->label(false);?>  
                        </td> 
                   
                </tr>
                
                <tr>
                        <td valign="2">Jumlah Tuntutan(RM):<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?=
                            $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                                 'name' => 'jumlah_tuntutan',
                                   'pluginOptions'=>[
                                   'initialize' => true,
                                                            ],
                                       'maskedInputOptions' => [
                                        'prefix' => 'RM',
                                     'rightAlign' => false
                                   ],

                                 'displayOptions' => [
                                  //  'placeholder' => 'Contoh: RM223437.04'
                                          ],
                                        ])->label(false);
                            ?>
                        </td>
                        
                        <td valign="2">Tarikh Dibeli:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model, 'used_dt')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                        </td> 
                   
                </tr>
                
                 
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Resit Bayaran :<span class="required" style="color:red;">*</span></td>
                    <td colspan="4">
                     <?= $form->field($model, 'file')->fileInput()->label(false);?> 
                    </td>
                    
                    <td valign="4">Dokumen Sokongan:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4">
                    <?= $form->field($model, 'file2')->fileInput()->label(false);?> 
                    </td> 
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
    </div>
        
        <div class ="row">
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
                <td class="col-sm-3 text-right">
                  <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
                </td>

                <td class="col-sm-4 text-justify">
                    <div style="width: 920px; height: 130px;border:2px solid burlywood">
                        <h5 style="color:black;"><p>&nbsp;Saya mengakui bahawa maklumat dan resit yang dikemukakan bersama dengan permohonan ini</p>
                        <p>&nbsp;adalah benar serta memenuhi syarat yang ditetapkan di bawah Pekeliling Bendahari Bil.3 Tahun 2011 dan UMS berhak</p>
                        <p>&nbsp;melulus atau menolak sebahagian atau sepenuhnya tuntutan saya ini. </h5>
                        <strong><p style="color:black;"><center>Tarikh Mohon: <?php echo $model->entrydate;?></p><br/> </strong></center>

                </div>
                </td>
            </tr>
        </table> 
            
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2"> 
                    <br>
                    
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
        </div>
        </div>
        </div>

        </div>
        <?php ActiveForm::end(); ?>
        </div> 

<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>

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