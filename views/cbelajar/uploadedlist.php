<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
$this->title = 'File';
$this->params['breadcrumbs'][] = $this->title;
$no = 1;
?>


<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cbelajar/halaman-utama-pemohon']) ?></li>
        <li><?= Html::a('Muat Naik Dokumen', ['cbelajar/senarai-dokumen']) ?></li>
        <li>Dokumen</li>
    </ol>
</div>

<div class="body-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12 col-md-12">

            <!-- Start Summernote 5 WYSIWYG Editor -->
            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title"><span class="icon"><i class="glyphicon glyphicon-list-alt"></i></span>&nbsp;&nbsp;Senarai Dokumen</h3>

                    </div>
                     <p align ="right">
            <?php echo Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?>  
        </p>

                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive rounded mb-20 col-sm-12">
                       
                        <table id="tour-16" class="table table-striped table-theme">
                            <thead>
                            <tr>
                                <th class="text-center border-right">No</th>
                                <th class="text-center">Nama Dokumen</th>
                                <th class="text-center">Lampiran</th>
                                <th class="text-center">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($files ):?>
                                    <?php foreach($files as $file):?>
                                        <tr>
                                        <td class="text-center border-right"><?= $no; ?></td>

                                         <td class="text-center">
                                            <?php if(!empty($file->dokumen->nama_dokumen)):?>
                                            
                                            <?php echo $file->dokumen->nama_dokumen ?></a>
<!--                                            <img src="<?= Url::to('@web/'.$file->namafile, true);?>"/>-->
                                            <?php endif;?>
                                        </td>

                                        <td class="text-center">
                                            <?php if(!empty($file->namafile)):?>
                                            
                                            <a href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($file->namafile), true); ?>?>"/><i class="fa fa-download" aria-hidden="true"></i>
                                            <?php endif;?>
                                        </td>

                                        


                                      <td class="text-center">
                                               <!--<a data-toggle="tooltip" title="Kemaskini" href="<?= Url::to(['updates','id'=>$file->id]); ?>" class="btn btn-primary btn-xs rounded"><strong>Update</strong></a>-->  
                                            <a data-toggle="tooltip" title="Padam" href="<?= Url::to(['deletes','id'=>$file->id]); ?>"  class="btn btn-danger btn-xs rounded" onclick="return confirm('Are you sure you want to delete this item?');"><strong>Delete</strong></a>
                                        </td>
                                        <?php $no++;?>
                                        </tr>
                                        <?php endforeach;?>
                                <?php else : ?>
                                <tr>
                                    <td colspan=6 class="text-center text-green"><strong>Tidak ada file yang telah ditambahkan</strong></td>
                                </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->
            <!--/ End Summernote 5 WYSIWYG Editor -->

        </div>
    </div><!-- /.row -->

</div>