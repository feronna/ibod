<style>
    .frm{
        background-color: rgb(235, 235, 228);
        opacity: 1;
        border: 1px solid #ccc;
        color: #555555;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555555;
        white-space: pre-line;
    }
</style>
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Application Particulars</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason For Extension <span class="required"></span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="frm"><?= $model->reason?></div><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date<span class="required"></span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input type="text" class="form-control" value="<?= $model->tarikhmohon?>" disabled="disabled"><br>
                        </div>
                    </div>
             <?php 
             $am = app\models\kontrak\TblAttachment::find()->where(['kontrak_id' => $model->id, 'type' => 'url'])->one();
             if($model->dokumen_sokongan!= NULL || $am){?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Supporting Document<span class="required"></span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <?php if($model->dokumen_sokongan!= NULL){?>
                            <a class="form-control" style="border:0;box-shadow: none;" href="<?= yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u><?= Yii::$app->FileManager->NameFile($model->dokumen_sokongan) ?></u></a>
                            <?php }?>
                            <?php if($am){?>
                            <a class="form-control" style="border:0;box-shadow: none;" href="<?= $am->url?>" target="_blank" ><i></i><u><?= $am->url ?></u></a>
                            <?php }?>
                        </div>
                    </div>
            <?php }?>
                </div>
            </div>
        </div>