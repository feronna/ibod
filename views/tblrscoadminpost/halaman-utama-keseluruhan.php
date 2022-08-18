<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Lantikan';
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>

    <?php $form = ActiveForm::begin([
        'action' => ['halaman-utama-keseluruhan'],
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
                                Pn Stella @ Nurul Martini Gontol<br/>
                                Timbalan Pendaftar <br/>
                                Tel: 088320000 (samb. 1410)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                Pn Hasba Mohd Basri<br/>
                                Penolong Pendaftar <br/>
                                Tel: 088320000 (samb. 2199)
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                Cik Norfaezah Hashim<br/>
                                Pembantu Tadbir (P/O) <br/>
                                Tel: 088320000 (samb. 1178)
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
                    <h2><strong><i class="fa fa-list"></i> Lantikan Pentadbiran </strong></h2>
                <div class="clearfix"></div>
                </div>
                
            <div class="well well-lg">  
            <div class="row">
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user-plus',
                                        'header' => 'Tambah Lantikan',
                                        'text' => 'Tambah Rekod Lantikan<br><p style="color: green"><strong>Dalam fasa pengujian</strong></p>',
                                        'number' => '1',
                                    ]
                    );
//                    echo Html::a($rekod_lantikan, ['']);
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/halaman-utama'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user',
                                        'header' => 'Papar Lantikan Terkini',
                                        'text' => 'Lantikan Terkini<br><p style="color: green"><strong>Dalam fasa pengujian</strong></p>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/admin-post-list-terkini'], ['target' => '_blank']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Papar Lantikan Keseluruhan',
                                        'text' => 'Lantikan Keseluruhan',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['tblrscoadminpost/admin-post-list-keseluruhan'], ['target' => '_blank']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user-secret',
                                        'header' => 'Papar Lantikan Pegawai Utama',
                                        'text' => 'Lantikan Pegawai Utama',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/senarai-pegawai-utama'], ['target' => '_blank']);
                    ?>
                </div>  
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Pelantikan 3 Bulan Akan Tamat',
                                        'text' => 'Lantikan 3 Bulan Akan Tamat<br><p style="color: green"><strong>Dalam fasa pengujian</strong></p>',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/admin-post-list-tamat'], ['target' => '_blank']);
                    ?>
                </div>  
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'check',
                                        'header' => 'Papar Lantikan Belum Disahkan',
                                        'text' => 'Lantikan Belum Sah<br><p style="color: green"><strong>Dalam fasa pengujian</strong></p>',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/admin-post-list-sah'], ['target' => '_blank']);
                    ?>
                </div> 
                
            </div>
            </div>
                
            </div>
        </div>
</div>
