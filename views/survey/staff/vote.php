<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

?>
<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
        width: 100%;
        max-width: 100%;
    }

    th,
    td {
        font-size: 14px;
        padding: 10px;
        text-align: left;
        vertical-align: top;
    }

    th {
        color: @baseheadingfontcolor;
        .font-size(16);
    }

    tr.selected {
        background: #ddd;
    }

    .form-radio {
        display: none;
    }
</style>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-check-square-o"></i>&nbsp;<strong><?= $this->title ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form-1',
                    'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'],
                ])
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered" witdh="100px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Nombor</th>
                                <th class="text-center" colspan="2">Calon</th>
                                <!-- <th class="text-center">Pilih Calon</th> -->
                            </tr>
                        </thead>
                        <?php if ($calon) { ?>

                            <tbody class="product-options">
                                <?php foreach ($calon as $v) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:center" width="10px">
                                            <p style="margin-top: 40px;"><strong><?= $bil++ ?></strong></p>
                                        </td>
                                        <td class="text-center" style="text-align:center" width="70px">
                                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($v->icno)) ?>.jpeg" class="text-center" style="width: 70px">
                                        </td>
                                        <td>
                                            <strong>Nama</strong> : <?php echo $v->kakitangan->CONm; ?><br>
                                            <strong>UMSPER</strong> : <?php echo $v->kakitangan->COOldID; ?><br>
                                            <strong>Jawatan</strong> : <?php echo $v->kakitangan->jawatan->fname; ?><br>
                                            <strong>Jawatan Pentadbiran</strong> : <?php echo $v->jwtnPentadbiran; ?>
                                            <input type="radio" id="tblvotes-calon_id" name="TblVotes[calon_id]" value="<?= $v->id ?>" class="form-radio">
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>

                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <div class="form-group">
                        <div class="text-center">
                           <?php echo Html::submitButton('Vote&nbsp;<i class="fa fa-check-square-o"></i>', ['class' => 'btn btn-primary', 'data' => [
                                'disabled-text' => 'Please Wait..',
                                'confirm' => 'Anda pasti dengan pilihan anda?',
                                'method' => 'post',
                            ]]) ?>


                        </div>
                    </div><?php ActiveForm::end() ?>
                </div>

                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>


<?php
$script = <<< JS

        $('.product-options tr').click(function() {
        $(this).children('td').children('input').prop('checked', true);

        $('.product-options tr').removeClass('selected');
        $(this).toggleClass('selected');
    });
JS;
$this->registerJs($script, View::POS_END);
?>