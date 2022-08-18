<?php 
use yii\helpers\Html;?>
<div class="row" > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> <?= $model->secondapp?>'s Endorsement</strong></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-3" for="wp_id"></label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?= Html::button(' Key Performance Indicators', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['kpi', 'id' => $model->id, 'modal' => 'mod']),'style'=>'width : 100%;', 'class' => 'btn btn-primary btn-md fa fa-eye mapBtn']);?>
                        </div>
                    </div><br><br>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12"><?= $model->secondapp?> <span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="kotak">
                            <?= $model->appbiodata->CONm? $model->appbiodata->CONm: $model->ketuajfpiu;?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Status of Endorsement <span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="kotak">
                            <?= $model->viewstatusdekan;?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Suggestion Post<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <div class="kotak">
                            <?= $model->cadangan_jawatan;?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Proposed Renewal Period of Contract<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <div class="kotak">
                            <?= $model->tempoh_l_jfpiu;?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Attachment<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <div class="kotak">
                               <?php if($model->dokumen_jfpiu != ''){?>
                            <a style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_jfpiu), true); ?>" target="_blank" ><i></i><u><?= Yii::$app->FileManager->NameFile($model->dokumen_jfpiu) ?></u></a>
                               <?php }?>
                           </div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Comment<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="kotak">
                            <?= $model->ulasan_jfpiu;?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 col-xs-12">Date<span class="required"></span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="kotak">
                            <?= $model->tarikhkj;?></div><br>
                        </div>
                    </div>
                    </div></div>
            </div>
        </div>