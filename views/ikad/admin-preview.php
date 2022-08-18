<?php

use yii\helpers\Html;
use app\models\keselamatan\cuti;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
// as a widget
?>

<?php echo $this->render('/ikad/_menu'); ?>

<style>
    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 10px 0 rgba(0, 0, 0.5, 0.5);
        transition: 0.3s;
        /* padding: 1px 16px; */
        width: 500px;


    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(1, 0, 0, 0.5);
    }

    /* Add some padding inside the card container */
    .container {
        padding: 2px;
    }

    /* p {
        margin: 4px;
    } */
</style>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Card Preview</strong></h2>

                <div class="clearfix">

                </div>
            </div>
            <?php if ($model->language_id == 0) { ?>
                <div class="x_content">
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <h2>English</h2>
                            <div class="card">
                                <br>

                                &nbsp;&nbsp;
                                <img class="shrinkToFit" src="../images/logo.png" alt="https://registrar.ums.edu.my/staff/web/images/Infografik_myjd.png" width="auto">
                                <div class="container">
                                    <!-- <br> -->
                                    <div class=" col-md-12 col-sm-12 col-xs-12">

                                        <h5><b><?php echo $model->d_nama ?></b></h5>
                                        <p><?php echo $model->d_edu_bi_1 . ' ' . $model->d_edu_bi_2  ?></p>
                                        <p style="color:rgb(51, 204, 255)"><?php echo $model->d_jawatan_bi ?></p>

                                        <hr style="border-width:1px;border-color:#000000; width:auto; margin:1px;">
                                        </hr>
                                    </div>
                                    <div class=" col-md-6 col-sm-6 col-xs-12">

                                        <?php echo $model->d_jbtn_bi ?>,</p>
                                        <?php echo $model->dept_address_bi_1 ?>,
                                        <?php echo $model->dept_address_bi_2 ?>,
                                        Tel: <?php echo $model->d_office_telno ?> Ext: <?php echo $model->d_office_extno ?>
                                        Mobile: <?php echo $model->d_hpno ?> Ext: <?php echo $model->d_faxno ?>
                                        Email: <?php echo $model->d_email ?>
                                    </div>
                                    <div>
                                        <img class="fit" src="../images/shape.png" right=0 padding-left="0" float="right" width="50%" height="150px">

                                    </div>
                                </div>
                            </div>

                            <br>

                            <h2>Malay</h2>
                            <div class="card">
                                <br>
                                &nbsp;&nbsp;
                                <img class="shrinkToFit" src="../images/logo.png" alt="https://registrar.ums.edu.my/staff/web/images/Infografik_myjd.png" width="auto">
                                <div class="container">
                                    <div class=" col-md-12 col-sm-12 col-xs-12">

                                        <h5><b><?php echo $model->d_nama ?></b></h5>
                                        <p><?php echo $model->d_edu_bm_1 . ' ' . $model->d_edu_bm_2  ?></p>
                                        <p style="color:rgb(51, 204, 255)"><?php echo $model->d_jawatan_bm ?></p>

                                        <hr style="border-width:1px;border-color:#000000; width:auto; margin:1px;">
                                        </hr>
                                    </div>
                                    <div class=" col-md-6 col-sm-6 col-xs-12">

                                        <?php echo $model->d_jbtn_bm ?>,</p>
                                        <?php echo $model->dept_address_bm_1 ?>,
                                        <?php echo $model->dept_address_bm_2 ?>,
                                        Tel: <?php echo $model->d_office_telno ?> Ext: <?php echo $model->d_office_extno ?>
                                        Mobile: <?php echo $model->d_hpno ?> Ext: <?php echo $model->d_faxno ?>
                                        Email: <?php echo $model->d_email ?>
                                    </div>
                                    <div>
                                    <img class="fit" src="../images/shape.png" right=0 padding-left="0" float="right" width="50%" height="150px">

                                    </div>
                                </div>
                            </div>

                        </table>
                    </div>
                    <!--  -->


                </div>
            <?php } elseif ($model->language_id == 1) { ?>
                <h2>English</h2>
                <div class="card">
                    <br>

                    &nbsp;&nbsp;
                    <img class="shrinkToFit" src="../images/logo.png" alt="https://registrar.ums.edu.my/staff/web/images/Infografik_myjd.png" width="auto">
                    <div class="container">
                        <div class=" col-md-12 col-sm-12 col-xs-12">

                            <h5><b><?php echo $model->d_nama ?></b></h5>
                            <p><?php echo $model->d_edu_bi_1 . ' ' . $model->d_edu_bi_2  ?></p>
                            <p style="color:rgb(51, 204, 255)"><?php echo $model->d_jawatan_bi ?></p>

                            <hr style="border-width:1px;border-color:#000000; width:auto; margin:1px;">
                            </hr>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-xs-12">

                            <?php echo $model->d_jbtn_bi ?>,</p>
                            <?php echo $model->dept_address_bi_1 ?>,
                            <?php echo $model->dept_address_bi_2 ?>,
                            Tel: <?php echo $model->d_office_telno ?> Ext: <?php echo $model->d_office_extno ?>
                            Mobile: <?php echo $model->d_hpno ?> Ext: <?php echo $model->d_faxno ?>
                            Email: <?php echo $model->d_email ?>
                        </div>
                        <div>
                        <img class="fit" src="../images/shape.png" right=0 padding-left="0" float="right" width="50%" height="150px">

                        </div>
                    </div>
                </div>
            <?php } elseif ($model->language_id == 2) { ?>
                <h2>English</h2>
                <div class="card">
                    <br>

                    &nbsp;&nbsp;
                    <img class="shrinkToFit" src="../images/logo.png" alt="https://registrar.ums.edu.my/staff/web/images/Infografik_myjd.png" width="auto">
                    <div class="container">
                        <div class=" col-md-12 col-sm-12 col-xs-12">

                            <h5><b><?php echo $model->d_nama ?></b></h5>
                            <p><?php echo $model->d_edu_bm_1 . ' ' . $model->d_edu_bm_2  ?></p>
                            <p style="color:rgb(51, 204, 255)"><?php echo $model->d_jawatan_bi ?></p>

                            <hr style="border-width:1px;border-color:#000000; width:auto; margin:1px;">
                            </hr>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-xs-12">

                            <?php echo $model->d_jbtn_bi ?>,</p>
                            <?php echo $model->dept_address_bi_1 ?>,
                            <?php echo $model->dept_address_bi_2 ?>,
                            Tel: <?php echo $model->d_office_telno ?> Ext: <?php echo $model->d_office_extno ?>
                            Mobile: <?php echo $model->d_hpno ?> Ext: <?php echo $model->d_faxno ?>
                            Email: <?php echo $model->d_email ?>
                        </div>
                        <div>
                        <img class="fit" src="../images/shape.png" right=0 padding-left="0" float="right" width="50%" height="150px">

                        </div>
                    </div>
                </div>
            <?php } ?>
            <br>
            <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['ikad/main-index'], ['class' => 'btn btn-warning']) ?>

        </div>

    </div>

</div>