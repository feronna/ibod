<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; 
use app\models\kemudahan\Reftujuan;
use dosamigos\datepicker\DatePicker;

//use wbraganca\dynamicform\DynamicFormWidget;
//use app\models\hronline\HubunganKeluarga;



error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
         
        
    <div class="row"> 
         <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Staf Secara Atas Talian(On-line): Bayaran Balik</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3  col-md-offset-1">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
            <option value="" disabled selected>Sila Pilih</option>
            <option value=" ../boranglesen/form_lesen ">Lesen Memandu</option>
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
    </div>
</div>


</div>
        <?php ActiveForm::end(); ?>
        </div> 
    </div>
</div>
</div>

 
<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>
