<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/ptm/_topmenu'); ?> 
</div>
</div>

<!--    <php $form = ActiveForm::begin([
        'action' => ['halaman-utama-keseluruhan'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>-->

<div class="row">
<!--<div class="col-md-12 col-sm-12 col-xs-12" >
    <php ActiveForm::end(); ?>
</div>  -->
    
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
            <div class="x_content">  
                <strong>
                    Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                    <table>
                        <tr>
                            <td>
                                En Juniezam Bin Juka<br/>
                                Penolong Pendaftar Kanan <br/>
                                Tel: 088320000 (samb. 1003)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                Pn Delveja Jakin<br/>
                                Pembantu Tadbir <br/>
                                Tel: 088320000 (samb. 1185)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                    </table>
                </strong>  
            </div>
            </div>
        </div>
    
        <div class="col-md-12 col-sm-12 col-xs-12" > 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-list"></i> Rekod Kompetensi </strong></h2>
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user-plus',
                                        'header' => 'Tambah Rekod',
                                        'text' => 'Tambah Rekod PTM',
                                        'number' => '1',
                                    ]
                    );
//                    echo Html::a($rekod_lantikan, ['']);
                    echo Html::a($rekod_lantikan, ['ptm/halaman-utama'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $ptm = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Kursus PTM',
                                        'text' => 'Rekod Kursus PTM<br>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($ptm, ['ptm/rekod-ptm'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $ptm = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Kursus P&P',
                                        'text' => 'Rekod Kursus P&P',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($ptm, ['ptm/rekod-pnp'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $ptm = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Kursus Metodologi Penyelidikan',
                                        'text' => 'Rekod Kursus Metodologi Penyelidikan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($ptm, ['ptm/rekod-penyelidikan'], ['target' => '_blank']);
                    ?>
                </div>  
                <div class="col-xs-12 col-md-6">
                    <?php
                    $ptm = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Kursus BITK',
                                        'text' => 'Rekod Kursus BITK',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($ptm, ['ptm/rekod-bitk'], ['target' => '_blank']);
                    ?>
                </div>  
            </div>
            </div>
                
            </div>
        </div>
</div>
