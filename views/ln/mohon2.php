<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>

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

<script>  
        function addNumber(){
            var a = document.getElementById("tambang3").value;
            var b = document.getElementById("elaun_makan3").value;
            var c = document.getElementById("elaun_hotel3").value;
            var d = document.getElementById("yuran3").value;
            var e = document.getElementById("transport3").value;
            var f = document.getElementById("dll3").value;
            var x = Number(a) + Number(b) + Number(c) + Number(d) + Number(e) + Number(f);;
            return document.getElementById("jumlah3").value = " " + x;
        }
         function call() {
             if(document.getElementById("tambang3")){
            document.getElementById("jumlah3").value=addNumber();
        }
        }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip4"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik dokumen sokongan yang berkaitan.</li></p>",
            html : true
        });
    });
</script>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<!--    <div class="x_panel">-->
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> LAPORAN BERTUGAS RASMI DI LUAR NEGARA (LN-2)</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['senarai-mohon2'], ['class' => 'btn btn-primary']) ?></p>      
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
            <h2><strong><i class="fa fa-user"></i> Maklumat Mengenai Lawatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tujuan</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model2, 'tujuan')->textArea(['disabled'=>'disabled', 'maxlength' => true, 'placeholder' => 'Nama seminar yang dihadiri']) ->label(false);?>
                    </div>
                </div>    
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tempat</label>  
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= $form->field($model2, 'nama_tempat')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'placeholder' => 'Tempat seminar yang dihadiri']) ->label(false);?>
                    </div>
                </div>
<!--                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Negara</label>  
                    <div class="col-md-8 col-sm-8 col-xs-10">  
                            <= $form->field($model, 'negara')->widget(Select2::classname(), 
                                ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'Country', 'Country'),
                                'options' => ['disabled'=>'disabled',
                                    'placeholder' => 'Pilh Negara'],
                            ])->label(false); ?>
                    </div>
                </div>-->
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Pergi</label>  
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model2, 'date_from')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'disabled'=>'disabled', 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_from' ]])->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Balik</label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                      <?= $form->field($model2, 'date_to')->widget(DatePicker::className(),
                              ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                              'options' => [ 'disabled'=>'disabled', 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_to' ]])->label(false);?>   
                    </div>
                    <label class="control-label col-md-1 col-sm-1 col-xs-4">Tempoh</label>
                    <div class="col-md-1 col-sm-1 col-xs-10"> 
                      <?= $form->field($model2, 'days')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
                    </div>  
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Justifikasi</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model2, 'justifikasi')->textArea(['disabled'=>'disabled', 'maxlength' => true, 'placeholder' => 'Justifikasi/alasan permohonan yang lewat']) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Bil. Peserta</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model2, 'bil_peserta')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'placeholder' => 'Bilangan peserta yang hadir']) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Maklumat Peserta</label>        
                    <div class="col-md-10 col-sm-10 col-xs-10"> 
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                        <tr class="headings">
                            <th class="text-center">Bil.</th>
                            <th class="text-center">Nama Peserta</th>
                            <th class="text-center">Jawatan Hakiki</th>
                            <th class="text-center">Jabatan Hakiki</th>
                            <th class="text-center">Jawatan Pentadbiran</th>
                            <th class="text-center">Jabatan Pentadbiran</th>
                            <th class="text-center">Peranan</th>

                        </tr>
                        </thead>
                            <?php if($peserta) { 
                               foreach ($peserta as $pesertakakitangan) { 
                            ?>

                            <tr>
                                <td class="text-center"><?= $bil++ ?></th>
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->CONm; ?></td>
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->jawatan->fname; ?></td>
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->department->fullname; ?></td>
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->adminpos->adminpos->position_name; ?></td>
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->adminpos->dept->fullname; ?></td>
                                <td class="text-center"><?= $pesertakakitangan->role->peranan; ?></td>
                            </tr>

                               <?php } 

                            } else{
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tiada Rekod</td>                     
                                </tr>
                              <?php  
                            } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div> 
        
    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Tujuan Lawatan Kerja</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tujuan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'tujuan_lawatan')->textArea(['maxlength' => true, 'placeholder' => 'Program lawatan kerja yang dihadiri']) ->label(false);?>
                    </div>
                </div>    
            </div> 
            </div>
        </div>
        </div>
    </div>
        
    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Program Lawatan Kerja</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Program:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'program_lawatan')->textArea(['maxlength' => true, 'placeholder' => 'Program lawatan kerja yang dihadiri']) ->label(false);?>
                    </div>
                </div>    
            </div> 
            </div>
        </div>
        </div>
    </div>
        
    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Implikasi dan Faedah Lawatan kepada Universiti Malaysia Sabah</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Implikasi:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'implikasi_lawatan')->textArea(['maxlength' => true, 'placeholder' => 'Implikasi dan faedah lawatan yang dihadiri kepada Universiti Malaysia Sabah']) ->label(false);?>
                    </div>
                </div>    
            </div> 
            </div>
        </div>
        </div>
    </div>
        
    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Cadangan / Perancangan yang akan Dilaksanakan di Universiti Malaysia Sabah</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Cadangan/ Perancangan :<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'cadangan')->textArea(['maxlength' => true, 'placeholder' => 'Cadangan / perancangan yang akan dilaksanakan di Universiti Malaysia Sabah berdasarkan hasil lawatan']) ->label(false);?>
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
            <h2><strong><i class="fa fa-user"></i> Perbelanjaan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                <thead>
                    <tr class="headings" >
                        <td class="text-center" width ="2%"> 
                        <th class="text-left" width ="60%">PERBELANJAAN ( Sila tanda √ di ruangan yang berkaitan )</th>
                        <td width ="10%">  </td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Perbelanjaan ditanggung oleh pihak penganjur</td>
                        <td class="text-center"><br> <?= $form->field($model2, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 1, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Memerlukan bantuan kewangan dari pihak Universiti</td>
                        <td class="text-center">  <?= $form->field($model2, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 2, 'uncheck' => null])->label(false)  ?>   </td>

                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Tidak memerlukan bantuan Universiti/Tanpa biaya</td>                        
                        <td class="text-center"> <?= $form->field($model2, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 3, 'uncheck' => null])->label(false) ?>  </td>
                    </tr> 
            </table> 
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Kos Perbelanjaan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                <thead>
                    <tr class="headings" >
                        <td class="text-center" width ="2%"> 
                        <th class="text-left" width ="60%">PERBELANJAAN ( Sila isi jumlah (RM) di ruangan yang berkaitan )</th>
                        <td class="text-center" width ="10%">Jumlah Dipohon (RM)</td>
                        <td class="text-center" width ="10%">Jumlah Diperuntukan (RM)</td>
                        <td class="text-center" width ="10%">Jumlah Sebenar (RM)</td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Tambang pergi-balik </td>
                        <td class="text-center"><?= $form->field($model2, 'tambang')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'tambang2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'tambang3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'tambang3', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Elaun Makan </td>
                        <td class="text-center"><?= $form->field($model2, 'elaun_makan')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'elaun_makan2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_makan3', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Elaun Sewa Hotel </td>                        
                        <td class="text-center"><?= $form->field($model2, 'elaun_hotel')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'elaun_hotel2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_hotel3', 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"> iv) </td>
                        <td class="text-left" >Yuran Pendaftaran </td>
                        <td class="text-center"><?= $form->field($model2, 'yuran')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'yuran2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'yuran3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'yuran3', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> v) </td>
                        <td class="text-left" >Lain-lain: Pengangkutan </td>
                        <td class="text-center"><?= $form->field($model2, 'transport')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'transport2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'transport3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'transport3', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> vi) </td>
                        <td class="text-left" >Lain-lain: Pertukaran Wang/Dobi/dll </td>                        
                        <td class="text-center"><?= $form->field($model2, 'dll')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'dll2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'dll3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'dll3', 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"></td>
                        <td class="text-left" >Jumlah </td>                        
                        <td class="text-center"><?= $form->field($model2, 'jumlah')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model2, 'jumlah2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'jumlah3')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'jumlah3','rows' => 2])->label(false); ?></td>
                    </tr> 
            </table> <br><br>
            
             <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-money"></i><strong> Perincian Perbelanjaan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="headings">
                        <tr class="odd"><td><strong>Jumlah Dipohon </strong></td>
                            <td><strong>
                                <?php if($model2->jumlah!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model2->jumlah, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td> 
                        </tr>     
                        <tr class="odd"><td><strong>Jumlah Diperuntukan </strong></td>
                            <td><strong>
                                <?php if($model2->jumlah2!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model2->jumlah2, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td> 
                        </tr>         
                    </thead>
                </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Catatan Umum dan Pandangan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Catatan/Pandangan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'placeholder' => 'Catatan umum dan pandangan lawatan kerja yang dihadiri']) ->label(false);?>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen Sokongan: <span class="required" style="color:red;">*</span></label>        
                    <span data-toggle="tooltip4" ><i class="fa fa-info-circle fa-lg"></i></span>
                    <div class="col-md-3">
                        <?= $form->field($model, 'dokumen_ln2')->fileInput()->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Status Penyelarasan Pendahuluan Diri / Pelbagai </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Catatan Penyelarasan:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'catatan_penyelarasan')->textArea(['maxlength' => true, 'placeholder' => 'Catatan penyelarasan pendahuluan diri/pelbagai']) ->label(false);?>
                    </div>
                </div>    
            </div> 
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;" width ="100%">
                <thead>
                    <tr class="headings" >
                        <td class="text-center" width ="2%"> 
                        <th class="text-left" width ="60%">Status Penyelarasan Pendahuluan Diri / Pelbagai ( Sila tanda √ di ruangan yang berkaitan )</th>
                        <td width ="10%">  </td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Selesai</td>
                        <td class="text-center"><br> <?= $form->field($model, 'penyelarasan')->radio(['label' => '', 'value' => 1, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Belum Selesai</td>
                        <td class="text-center">  <?= $form->field($model, 'penyelarasan')->radio(['label' => '', 'value' => 2, 'uncheck' => null])->label(false)  ?>   </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Tidak Berkenaan</td>
                        <td class="text-center">  <?= $form->field($model, 'penyelarasan')->radio(['label' => '', 'value' => 3, 'uncheck' => null])->label(false)  ?>   </td>

                    </tr>
            </table> 
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" type="reset">Reset</button>
            <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?' ]]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        
    </div>   
    </div>
</div>
</div>