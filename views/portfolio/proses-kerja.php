<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
';

$this->registerJs($js);
//error_reporting(0);
?>



<style>
    th {
        background-color: #2290F0;
        color: white;
        text-align: left;
    }

</style>



<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu'); ?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

            <div class="x_panel" id="rcorners2">
                <!--         <div class="x_title">
                          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
                         </div>-->

                <?php
                echo Html::a(Yii::t('app', '<i class="fa fa-users"></i> <span class="label label-success">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian', 'id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
                echo Html::a(Yii::t('app', '<i class="fa fa-university"></i> <span class="label label-info">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf', 'id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
                echo Html::a(Yii::t('app', '<i class="fa fa-book"></i> <span class="label label-success">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas', 'id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
                ?>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_content"> 

                <?php
                echo Html::a(Yii::t('app', 'CARTA ORGANISASI'), ['/portfolio/carta-organ-staf', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                echo Html::a(Yii::t('app', 'CARTA FUNGSI'), ['/portfolio/carta-fungsi', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                echo Html::a(Yii::t('app', 'AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);

                echo Html::a(Yii::t('app', 'PROSES KERJA'), ['/portfolio/proses-kerja', 'id' => $deskripsi->id], ['class' => 'btn btn-warning']);
                echo Html::a(Yii::t('app', 'SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);

                echo Html::a(Yii::t('app', 'SENARAI BORANG'), ['/portfolio/senarai-borang', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                echo Html::a(Yii::t('app', 'SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                echo Html::a(Yii::t('app', 'PERAKUAN'), ['/portfolio/perakuan', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                echo Html::a(Yii::t('app', 'JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio', 'id' => $deskripsi->id], ['class' => 'btn btn-success']);
                ?>
            </div></div>




        <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>



        <div class="col-md-12 col-xs-12"> 


            <div class="x_panel">
                <div class="x_title">
                    <p style="font-size:15px;font-weight: bold;">AKTIVITI </p> 
                    <div class="clearfix"></div>
                </div>
                <div class="x_content ">

                    <div class="form-group" id="jenisHarta">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenisHarta">Struktur: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            if ($carta->unit_staff == null) {
                                echo $form->field($modelmel, 'section_id')->widget(Select2::classname(), ['data' => ArrayHelper::map(\app\models\portfolio\RefSection::find()->joinWith('cartaJabatan')->where(['portfolio_ref_section.jabatan_id' => $test->DeptId])->andWhere(['portfolio_ref_section.id' => $carta->section])->orderBy(['section_details' => SORT_DESC])->all(), 'id', 'section_details'),
                                    'options' => [
                                        'placeholder' => '- Pilh Stuktur - '],
                                ])->label(false);
                            } else {
                                echo $form->field($modelmel, 'section_id')->widget(Select2::classname(), ['data' => ArrayHelper::map(\app\models\portfolio\RefSection::find()->joinWith('cartaJabatan')->where(['portfolio_ref_section.jabatan_id' => $test->DeptId])->orWhere(['portfolio_ref_section.id' => $carta->section])->orderBy(['section_details' => SORT_DESC])->all(), 'id', 'section_details'),
                                    'options' => [
                                        'placeholder' => '- Pilh Stuktur - '],
                                ])->label(false);
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="senarai" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Unit: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($modelmel, 'unit_id')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'data' => ArrayHelper::map(\app\models\portfolio\RefUnit::find()->where(['jabatan_id' => $test->DeptId])->orderBy(['unit_details' => SORT_DESC])->all(), 'id', 'unit_details'),
                                'options' => [
                                    'multiple' => false],
                                'pluginOptions' => [
                                    'placeholder' => '- Pilih Unit - ',
                                    'depends' => [Html::getInputId($modelmel, 'section_id')],
                                    'initialize' => true,
                                    'url' => Url::to(['/portfolio/statelist'])
                                ]
                            ])->label(false)
                            ?>


                        </div>
                    </div>

                    <div class="form-group" id="daerah" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Fungsi Unit: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($modelmel, 'fungsi_unit')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'data' => ArrayHelper::map(\app\models\portfolio\RefFungsiUnit::find()->joinWith('fungsiUnit')->where(['description' => $test->DeptId])->orderBy(['unit_details' => SORT_DESC])->all(), 'id', 'description'),
                                'options' => [
                                    'multiple' => false,],
                                'pluginOptions' => [
                                    'placeholder' => '- Pilih Fungsi Unit - ',
                                    'depends' => [Html::getInputId($modelmel, 'unit_id')],
                                    'initialize' => true,
                                    'url' => Url::to(['/portfolio/citylist'])
                                ]
                            ])->label(false)
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="daerah" >
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Daerah">Aktiviti Bagi Fungsi: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=
                            $form->field($modelmel, 'aktiviti_fungsi')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'data' => ArrayHelper::map(\app\models\portfolio\TblAktiviti::find()->orderBy(['aktiviti' => SORT_DESC])->all(), 'id', 'aktiviti'),
                                'options' => [
                                    'multiple' => false,],
                                'pluginOptions' => [
                                    'placeholder' => '- Pilih Aktiviti -',
                                    'depends' => [Html::getInputId($modelmel, 'fungsi_unit')],
                                    'initialize' => true,
                                    'url' => Url::to(['/portfolio/fungsilist'])
                                ]
                            ])->label(false)
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Undang-undang, Peraturan dan Punca Kuasa: <span class="required" style="color:red;">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($modelmel, 'undang')->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Carta Alir:
                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" Sila muat naik Carta Alir Proses kerja "></i> 
                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            if ($modelmel->file) {
                                ?> <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                                   href="<?= Url::to(Yii::$app->FileManager->DisplayFile($modelmel->file), true); ?>" target="_blank" ><u>Muat Turun</u></a>
                               <?php } else {
                                   ?>
                                        <?= $form->field($modelmel, 'file')->fileInput()->label(false); ?> </td>

                            <?php }
                            ?>

                        </div>
                    </div>

                </div>
            </div>
            <div class="x_panel">
                <div class="customer-form">
                    <?php
                    DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 30, // the maximum times, an element can be added (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsBarang[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'description',
                        ],
                    ]);
                    ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                <i class="fa ">Tambah Proses Kerja</i>
                                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                                <?php // Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="btn-label">Tambah</span>', ['borangehsan/form-family',  'id' => $model->id ], ['class' => 'btn btn-success btn-sm pull-right']) 
                                ?>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="container-items">
                                <!-- widgetBody -->
                                <?php foreach ($modelsBarang as $i => $modelsBarang) : ?>
                                    <div class="item panel panel-default">
                                        <!-- widgetItem -->
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            // necessary for update action.
                                            if (!$modelsBarang->isNewRecord) {
                                                echo Html::activeHiddenInput($modelsBarang, "[{$i}]id");
                                            }
                                            ?>


                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggungjawab: <span class="required" style="color:red;">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?=
                                                    $form->field($modelsBarang, "[{$i}]tanggungjawab")->label(false)->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                                                        ->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                                                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ]);
                                                    ?>
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Proses Kerja: <span class="required" style="color:red;">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?= $form->field($modelsBarang, "[{$i}]proses_kerja")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Lain/Dirujuk: 
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?=
                                                    $form->field($modelsBarang, "[{$i}]pegawai_lain")->label(false)->widget(Select2::classname(), [
                                                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()
                                                                        ->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                                                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ]);
                                                    ?>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh / Kekerapan: <span class="required" style="color:red;">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <?= $form->field($modelsBarang, "[{$i}]tempoh")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                </div>
                                            </div>






                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div><!-- .panel -->
                <?php DynamicFormWidget::end(); ?>
                <!--           view dyanamic end here-->


                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Simpan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>



            </div>


        </div>




        <?php ActiveForm::end(); ?>


        <div class="col-md-12 col-xs-12"> 
            <div class="x_panel" >
                <div class="x_content">
                    <table class="table table-bordered table-sm jambo_table">

                        <thead>

                            <tr class="headings">
                                <th class="column-title">BIL </th>

                                <th class="column-title">AKTIVITI BAGI FUNGSI </th>
                                <th class="column-title">DOKUMEN</th>
                                <th class="column-title">TANGGUNGJAWAB </th>
                                <th class="column-title">PROSES KERJA </th>
                                <th class="column-title">PEGAWAI LAIN/DIRUJUK </th>

                                <th class="column-title">TEMPOH / KEKERAPAN</th>
                                <th class="column-title">SENARAI UNDANG-UNDANG, PERATURAN DAN PUNCA KUASA</th>
                                <th class="column-title">TINDAKAN</th>


                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if ($viewAktiviti) {

                                foreach ($viewAktiviti as $key => $item) {
                                    ?>

                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td> <?= $item->aktivitiProses->fungsiAktiviti->aktiviti ?></td>


                                        <td> 
                                        <a href="<?php echo Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/'. 
                                                $item->aktivitiProses->file, true); ?>" target="_blank" ><i class="fa fa-download"></i> 
                                            Klik Sini Untuk Muat Turun</a><br>

<!--                                                                    Html::a('<u><strong>'.$query->tajuk_prosedur, "https://mediahost.ums.edu.my/api/v1/viewFile/".$query->file, ['role' => 'modal-remote', 'target' => '_blank']);-->

                                        <td> <?php echo $item->kakitangan->CONm . '<br>' . $item->kakitangan->jawatan->fname ?></td>
                                        <td> <?= $item->proses_kerja ?></td>
                                        <td> <?php echo $item->pegawai->CONm . '<br>' . $item->pegawai->jawatan->fname ?></td>

                                        <td> <?= $item->tempoh ?></td>
                                        <td> <?= $item->aktivitiProses->undang ?></td>
                                        <td width="50px" class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-proses-kerja', 'id' => $item->id, 'myjd_id' => $item->myjd_id]) ?> | <?=
                                            Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-proses-kerja', 'id' => $item->id, 'myjd_id' => $item->myjd_id], [
                                                'data' => [
                                                    'confirm' => 'Anda ingin membuang rekod ini?',
                                                    'method' => 'post',
                                                ],
                                            ])
                                            ?></td>  


                                    </tr>


                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="text-center">Tiada Rekod</td>                     
                                </tr>
                            <?php }
                            ?>
                    </table>
                </div>
            </div></div>


    </div>
</div>
