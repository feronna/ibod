<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/pengesahan/_topmenu'); ?> 
</div>
</div>

    <?php $form = ActiveForm::begin([
        'action' => ['halaman-utama-pengesahan'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >
    <?php ActiveForm::end(); ?>
</div>  
    
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
            <div class="x_content">  
                <strong>
                    Untuk maklumat lanjut, sila hubungi talian berikut:<br/><br/>
                    <table>
                        <tr>
                            <td>
                                Pn. Rozaidah Amir Hussein<br/>
                                Penolong Pendaftar Kanan <br/>
                                Tel: 088320000 (samb. 102005)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                Pn. Patricia Binti Joseph<br/>
                                Pembantu Tadbir <br/>
                                Tel: 088320000 (samb. 102241)
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
                    <h2><strong><i class="fa fa-list"></i> Pengesahan Dalam Perkhidmatan </strong></h2>
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'AKADEMIK',
                                        'text' => 'Pengesahan Dalam Perkhidmatan [Akademik]',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($pengesahan, ['pengesahanakademik/halaman-pengesahan-akademik'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'AKADEMIK (DU51P)',
                                        'text' => 'Pengesahan Dalam Perkhidmatan [Akademik (DU51P)]',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($pengesahan, ['pengesahanakademik/halaman-pengesahan-akademik2'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'PENTADBIRAN',
                                        'text' => 'Pengesahan Dalam Perkhidmatan [Pentadbiran]',
                                        'number' => '3',
                                    ]
                    );
//                    echo Html::a($rekod_lantikan, ['']);
                    echo Html::a($pengesahan, ['halaman-pengesahan-pentadbiran'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $pengesahan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'cog',
                                        'header' => 'TETAPAN',
                                        'text' => 'Tetapan Pengesahan Dalam Perkhidmatan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($pengesahan, ['pengesahan/halaman-tetapan'], ['target' => '_blank']);
                    ?>
                </div>
            </div>
            </div>
                
            </div>
        </div>
</div>
