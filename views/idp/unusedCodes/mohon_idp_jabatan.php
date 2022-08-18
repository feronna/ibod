<?php
use yii\helpers\Html; 
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use app\models\models_idp\KlusterKursus;
use app\models\models_idp\IdpKategoriJawatan;
use app\models\models_idp\IdpCampus;

echo \app\widgets\TopMenuWidget::widget(['top_menu' => [59, 64, 68], 'vars' => [
    ['label' => ''],
]]);
?>
<div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Borang Permohonan Mata IDP Bagi Penganjuran Kursus Oleh JFPIU</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT PEMOHON</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kod" style="background-color:lightgrey;">Nama : <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'pemilik_modul')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group" style="background-color:lightgrey;">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12">MAKLUMAT KURSUS LATIHAN</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tajuk Kursus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'tajuk_kursus')->textInput(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false)?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Tahun Ditawarkan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        
//                        // a password input
//                        $form->field($model, 'password')->passwordInput();
//                        // adding a hint and a customized label
//                        $form->field($model, 'username')->textInput()->hint('Please enter your name')->label('Name');
//                        // creating a HTML5 email input element
//                        $form->field($model, 'email')->input('email');
                        
/******************************** Use the code below to print out if have error **************************/                      
//                        \yii\helpers\VarDumper::dump($listYear,10,true);
//                        exit();

/******************************** Dropdownlist for YEAR range ********************************************/                        
                        echo $form->field($model, 'tahun_ditawarkan')->dropDownList(
                                $model->getYearsList(), //function from VIdpSenaraiKursus model
                                ['prompt'=>'Pilih tahun...'])
                                ->label(false);

                        ?>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kategori Jawatan: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\IdpKategoriJawatan;
                        $kategoriJawatan = IdpKategoriJawatan::find()
                                ->orderBy("kategoriJawatanName")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData2 = ArrayHelper::map($kategoriJawatan, 'kategoriJawatanID', 'kategoriJawatanName');
                        
                        echo $form->field($model, 'job_category')->dropDownList(
                            $listData2,
                            ['prompt'=>'Select...']
                            )->label(false)  
                        ?>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kluster: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\KlusterKursus;
                        $kluster = KlusterKursus::find()
                                ->orderBy("kluster_nama")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($kluster,'kluster_id','kluster_nama');
                        
                        echo $form->field($model, 'kluster_id')->dropDownList(
                            $listData,
                            ['prompt'=>'Select...']
                            )->label(false)  ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">Kampus: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        
                        //use app\models\IdpCampus;
                        $campus = IdpCampus::find()
                                ->orderBy("campus_name")
                                ->all();

                        //use yii\helpers\ArrayHelper;
                        $listData=ArrayHelper::map($campus,'campus_id','campus_name');
                        
                        echo $form->field($model, 'campus_id')->dropDownList(
                            $listData,
                            ['prompt'=>'Select...']
                            )->label(false)  ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3"></div> 
                    <div class="col-sm-9">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']); ?>
                        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
                
<!--			<fieldset>
			<legend>Borang Laporan Aktiviti Pelajar</legend>
			<table border="0" cellpadding="2" cellspacing="2" width="100%">
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PENGANJUR</th></tr>
			<tr>
			<td><label>Pertubuhan</label></td>
			<td>
				<select name="clubID">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
                                        
				</select>
			</td>
			</tr>
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PROGRAM</th></tr>
			<tr>
			<td><label>Kod Program</label></td>
			<td><input size="80%" type="text" name="kodProgram"></td>
			</tr>
			<tr>
			<td><label>Nama Program</label></td>
			<td><input size="80%" type="text" name="namaProgram"></td>
			</tr>
			<tr>
			<td><label>Tempat</label></td>
			<td><input size="80%" type="text" name="lokasi"></td>
			</tr>
			<tr>
			<td><label>Tarikh</label></td>
			<td><input type="date" name="tarikh"></td>
			</tr>
			<tr>
			<td><label>Sesi</label></td>
			<td><select name="pilihSesi">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
				</select></td>
			</tr>
			<tr>
			<td><label>Peringkat</label></td>
			<td><select name="pilihPeringkat">
					<option>--SILA PILIH--</option>
					<option value = "1" >1</option>
				</select></td>
			</tr>
			<tr><th bgcolor="lightgrey" colspan="2" align="center">MAKLUMAT PESERTA</th></tr>
			<tr>
			<td><label>Sila isi no matrik pelajar di sini :<label></td>
			<td><div class="input_fields_wrap">
			<button class="add_field_button">Tambah Pelajar</button>
				<div><input type="text" name="mytext[]"></div>
			</div></td>
			</tr>
			<tr>
			<td><label>Masukkan jumlah peserta di sini :</label></td>
			<td><input type="text" id="member" name="member" value=""><br/>
				<a href="#" id="filldetails" onclick="addFields()">TEKAN DI SINI</a>
				<div id="contain"/>
			</td>
			</tr>
			</table>
			</fieldset>-->
                




