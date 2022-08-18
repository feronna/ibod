<?php

use yii\helpers\Html; 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$title = $this->title = 'Maklumat Akademik';
?> 

<?php echo $this->render('_menu', ['title' => $title]) ?>



<!-- Maklumat Akademik -->

 <div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
        
        <div class="x_panel">
            
            <div class="x_title">
                <h2><strong><i class="fa fa-book"></i> Maklumat Akademik</strong></h2>
                 <p align ="right">
                <?php echo Html::a('<i class="fa fa-edit"></i> ', ['pendidikan/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>
                
        </p>
               
                <div class="clearfix"></div>
            </div>

 <div>  <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title text-center">Bil</th>
                        <th class="column-title text-center">Nama Dokumen </th>
                         <th class="column-title text-center">Tindakan</th>
                    </tr>

                </thead>
                <tbody>

                    <?php $bil=1; foreach ($model as $model) { ?>

                        <tr>

                            <td class="text-center"><?= $bil++ ?></td>
                            <td><?= $model->nama_dokumen; ?></td>
                            <td><?= $form->field($model, 'file')->fileInput()->label(false) ?></td>
                      
                        </tr>
                    <?php } ?>
                </tbody>

                     </table>
<?php ActiveForm::end();?>
                </form>

                 <p align ="right">
                    
                    <?= Html::a('Seterusnya', ['cbelajar/maklumat-pengajian'], ['class' => 'btn btn-info btn-sm']); ?>
                    <?php echo Html::a('Kembali',  ['cbelajar/maklumat-peribadi'], ['class' => 'btn btn-primary btn-sm']); ?> 
                </p>



            </div>
        </div>
        
    </div>
</div>
  
