<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
//use app\models\hronline\Negara;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

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
            var a = document.getElementById("tambang2").value;
            var b = document.getElementById("elaun_makan2").value;
            var c = document.getElementById("elaun_hotel2").value;
            var d = document.getElementById("yuran2").value;
            var e = document.getElementById("transport2").value;
            var f = document.getElementById("dll2").value;
            var x = Number(a) + Number(b) + Number(c) + Number(d) + Number(e) + Number(f);;
            return document.getElementById("jumlah2").value = " " + x;
        }
         function call() {
             if(document.getElementById("tambang2")){
            document.getElementById("jumlah2").value=addNumber();
        }
        }
</script> 

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> PERMOHONAN BERTUGAS RASMI KE LUAR NEGARA </strong></h2>
<!--            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['semakan-canselori'], ['class' => 'btn btn-primary']) ?></p>      -->
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
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Lawatan</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'nama_lawatan')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Faedah Lawatan</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'faedah_lawatan')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tujuan Lawatan</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'tujuan')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tujuan Aktiviti</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'tujuan_aktiviti')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Mula Aktiviti</label>  
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model, 'startA')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Akhir Aktiviti</label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model, 'endA')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div>  
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tempat</label>  
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= $form->field($model, 'nama_tempat')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
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
<!--                    <= $form->field($model, 'date_from')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'disabled'=>'disabled', 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_from' ]])->label(false);?>-->
                    <?= $form->field($model, 'datefrom')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Balik</label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
<!--                      <= $form->field($model, 'date_to')->widget(DatePicker::className(),
                              ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                              'options' => [ 'disabled'=>'disabled', 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'date_to' ]])->label(false);?>   -->
                    <?= $form->field($model, 'dateto')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                    <label class="control-label col-md-1 col-sm-1 col-xs-4">Tempoh</label>
                    <div class="col-md-1 col-sm-1 col-xs-10"> 
                    <?= $form->field($model, 'days')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
                    </div>  
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Justifikasi</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'justifikasi')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Bilangan Peserta</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'bil_peserta')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
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
                                <td class="text-center"><?= $pesertakakitangan->kakitangan->adminpos->adminpos->position_name ?></td>
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
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Sejarah Perjalanan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
        <div class="table-responsive">
             <table class="table table-striped table-sm jambo_table table-bordered">
               <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tarikh Perjalanan</th>
                    <th class="text-center">Nama Lawatan</th>
                    <th class="text-center">Tempat</th>
                    <th class="text-center">Kod Peruntukan</th>
                </tr>
               </thead>
                <?php
                if ($ln) { $bil1=1;?>
                    <?php foreach ($ln as $a) { 
                        { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil1++ ?></td>
                            <td class="text-center"><?php echo $a->kakitangan->CONm; ?></td>
                            <td class="text-center"><?php echo $a->datefrom; ?> - <?php echo $a->dateto; ?></td>
                            <td class="text-center"><?php echo $a->nama_lawatan; ?></td>
                            <td class="text-center"><?php echo $a->nama_tempat; ?></td>
                            <td class="text-center"><?php echo $a->kod_peruntukan_cn; ?></td>
                        </tr>
                    <?php } }?>
                <?php } else { ?>
                   
                <?php } ?>
                 
            </table>           
        </div>
        </div>
    </div>
    </div>
        
<!--    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Peserta</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                    <tr class="headings">
                        <th class="text-center">Bil.</th>
                        <th class="text-center">Nama Peserta</th>
                        <th class="text-center">Jawatan Hakiki</th>

                    </tr>
                    </thead>
                    <php if($peserta) { 
                       foreach ($peserta as $pesertakakitangan) { 
                    ?>

                    <tr>
                        <td class="text-center"><= $bil++ ?></th>
                        <td class="text-center"><= $pesertakakitangan->kakitangan->CONm; ?></td>
                        <td class="text-center"><= $pesertakakitangan->kakitangan->jawatan->fname; ?></td>

                    </tr>

                       <php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <php  
                    } ?>
            </table>
        </div>
    </div>
    </div>-->
        
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
                        <td class="text-center"><br> <?= $form->field($model, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 1, 'uncheck' => null])->label(false)  ?>     </td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Memerlukan bantuan kewangan dari pihak Universiti</td>
                        <td class="text-center">  <?= $form->field($model, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 2, 'uncheck' => null])->label(false)  ?>   </td>

                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Tidak memerlukan bantuan Universiti/Tanpa biaya</td>                        
                        <td class="text-center"> <?= $form->field($model, 'perbelanjaan')->radio(['disabled'=>'disabled', 'label' => '', 'value' => 3, 'uncheck' => null])->label(false) ?>  </td>
                    </tr> 
            </table> 
        </div>
    </div>
    </div>
        
    <div class="row" style="display: <?php if($model->status != 'DALAM TINDAKAN CANSELORI'){echo 'none';}?>">   
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Jumlah Anggaran Perbelanjaan Yang Diperlukan</strong></h2>
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
                        <td class="text-center" width ="10%">Jumlah Disyorkan (RM)</td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Tambang pergi-balik </td>
                        <td class="text-center"><?= $form->field($model, 'tambang')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'tambang2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'tambang2', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Elaun Makan </td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_makan2', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Elaun Sewa Hotel </td>                        
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'elaun_hotel2', 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"> iv) </td>
                        <td class="text-left" >Yuran Pendaftaran </td>
                        <td class="text-center"><?= $form->field($model, 'yuran')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'yuran2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'yuran2', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> v) </td>
                        <td class="text-left" >Lain-lain: Pengangkutan </td>
                        <td class="text-center"><?= $form->field($model, 'transport')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'transport2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'transport2', 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> vi) </td>
                        <td class="text-left" >Lain-lain: Pertukaran Wang/Dobi/dll </td>                        
                        <td class="text-center"><?= $form->field($model, 'dll')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'dll2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'dll2', 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"></td>
                        <td class="text-left" >Jumlah </td>                        
                        <td class="text-center"><?= $form->field($model, 'jumlah')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'jumlah2')->textInput(['maxlength' => true, 'onchange' => 'call()', 'id' => 'jumlah2','rows' => 2])->label(false); ?></td>
                    </tr> 
            </table><br>
            
            <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4">Bantuan yang dipohon dari Universiti:</label>        
                    <div class="col-md-4 col-sm-4 col-xs-8"> 
<!--                        <input type="text" class="form-control" value="<php echo $model->kod_peruntukan;?>" disabled="disabled">-->
                        <?= $form->field($model, 'kod_peruntukan')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
            </div><br>
             
<!--            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Permohonan (RM)<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'jumlah')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
                </div>
            </div>-->

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
                                <?php if($model->jumlah!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->jumlah, 'RM '); ?> 
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
     
    
    <div class="row" style="display: <?php if($model->status === 'DALAM TINDAKAN CANSELORI'){echo 'none';}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Jumlah Anggaran Perbelanjaan Yang Diperlukan</strong></h2>
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
                        <td class="text-center" width ="10%">Jumlah Disyorkan (RM)</td>
                    </tr>
                </thead> 
                    <tr class="headings">
                        <td class="text-center"> i) </td>
                        <td class="text-left" >Tambang pergi-balik </td>
                        <td class="text-center"><?= $form->field($model, 'tambang')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'tambang2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> ii) </td>
                        <td class="text-left" >Elaun Makan </td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_makan2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> iii) </td>
                        <td class="text-left" >Elaun Sewa Hotel </td>                        
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'elaun_hotel2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"> iv) </td>
                        <td class="text-left" >Yuran Pendaftaran </td>
                        <td class="text-center"><?= $form->field($model, 'yuran')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'yuran2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> v) </td>
                        <td class="text-left" >Lain-lain: Pengangkutan </td>
                        <td class="text-center"><?= $form->field($model, 'transport')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'transport2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr>
                    <tr class="headings">
                        <td class="text-center"> vi) </td>
                        <td class="text-left" >Lain-lain: Pertukaran Wang/Dobi/dll </td>                        
                        <td class="text-center"><?= $form->field($model, 'dll')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'dll2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr> 
                    <tr class="headings">
                        <td class="text-center"></td>
                        <td class="text-left" >Jumlah </td>                        
                        <td class="text-center"><?= $form->field($model, 'jumlah')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                        <td class="text-center"><?= $form->field($model, 'jumlah2')->textInput(['disabled'=>'disabled', 'maxlength' => true, 'rows' => 2])->label(false); ?></td>
                    </tr> 
            </table><br>
            
            <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-4">Bantuan yang dipohon dari Universiti:</label>        
                    <div class="col-md-4 col-sm-4 col-xs-8"> 
<!--                        <input type="text" class="form-control" value="<php echo $model->kod_peruntukan;?>" disabled="disabled">-->
                        <?= $form->field($model, 'kod_peruntukan')->textArea(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
            </div><br>
             
<!--            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Permohonan (RM)<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'jumlah')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
                </div>
            </div>
            
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Disyorkan (RM)<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'jumlah2')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
                </div>
            </div>
             
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Beza Perbelanjaan (RM)<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'baki')->textInput(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
                </div>
            </div>-->

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
                        <tr class="odd">
                            <td><strong>Jumlah Dipohon </strong></td>
                            <td><strong>
                                <?php if($model->jumlah!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->jumlah, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td> 
                        <tr class="odd">
                            <td><strong>Jumlah Disyorkan </strong></td>
                            <td><strong>
                                <?php if($model->jumlah2!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->jumlah2, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td> 
<!--                        <tr class="odd">
                            <td><strong>Beza Peruntukan</strong></td>
                            <td><strong>
                                <?php if($model->baki!= NULL){?>  
                                <?= Yii::$app->formatter->asCurrency( $model->baki, 'RM '); ?> 
                                <?php }else{
                                    echo "Tidak Berkaitan";
                                }?>
                            </strong></td> 
                        </tr>                                             -->
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Kertas Kerja:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php if($model->dokumen_sokongan!= NULL){?> 
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Kertas Kerja.pdf</u></a><br>
                        <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Surat Jemputan:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php if($model->dokumen_sokongan2!= NULL){?> 
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Dokumen Surat Jemputan.pdf</u></a><br>
                        <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="form-group" id="file">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan:</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php if($model->dokumen_sokongan3!= NULL){?> 
                        <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan3), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a><br>
                        <?php }else{
                        echo "Tiada Dokumen Disertakan";
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
        
    <div class="row" style="display: <?php if($model->status === 'DALAM TINDAKAN KETUA JABATAN'){echo $model->status_jfpiu;}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Perakuan Ketua Jabatan</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_jfpiu;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_jfpiu')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Diperaku</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->appdate;?>" disabled="disabled">
                </div>
            </div>    
        </div>
        </div>
        </div>
    </div>  
    </div>
    
    <div class="row" style="display: <?php if($model->status != 'DALAM TINDAKAN CANSELORI'){echo 'none';}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Semakan Canselori</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <br>
        <div class="x_content">
        <div class="table-responsive">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Peruntukan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'kod_peruntukan_cn')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
            </div>
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Status Semakan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'status_semakan')->label(false)->widget(Select2::classname(), [
                            'data' => ['Diperakui' => 'PERMOHOHAN DIPERAKUI', 'Tidak Diperakui' => 'PERMOHONAN DITOLAK'],
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "Diperakui"){
                            $("#ulasan").show();
                            }
                            else{
                            $("#ulasan").show();
                            }'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
            </div>
            <div class="form-group" id="ulasan" style="display: none">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan:<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'ulasan_semakan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..'] ]) ?>
                </div>
            </div>
        </div>
        </div>
        </div>
    </div>
    </div>    

    <div class="row" style="display: <?php if($model->status === 'DALAM TINDAKAN CANSELORI'){echo 'none';}?>">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Status Semakan Canselori</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kod Peruntukan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'kod_peruntukan_cn')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Disyorkan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" 
                    value="<?php if($model->jumlah2!= NULL){?>  
                            <?= Yii::$app->formatter->asCurrency($model->jumlah2,'RM'); ?> 
                            <?php }else{
                                echo "Tidak Berkaitan";
                            }?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->status_semakan;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_semakan')->textArea(['maxlength' => true, 'rows' => 4, 'disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->verdate;?>" disabled="disabled">
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
