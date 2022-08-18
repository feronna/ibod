<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\models\elnpt\TblLppTahun;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lpp = app\models\elnpt\TblMain::findOne(['lpp_id' => $lppid]);
$tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

if($lpp->PYD == Yii::$app->user->identity->ICNO) {
    if(!$req){
        $flag = true;
        if($lpp->PYD_sah == 1){
            $flag = true;
        }else {
            $flag = false;
        }
    }else {
        $flag = false;
    }
}else {
    $flag = true;
}

$grid = GridView::widget([
            'dataProvider' => $data2,
            'columns' => [  
                ['class' => 'yii\grid\SerialColumn'],
                // Simple columns defined by the data contained in $dataProvider.
                // Data from the model's column will be used.
                'Nomatrik',
                'NamaPelajar',
                'KodSesi_Sem',
                'TahapPenyeliaanBM',
                'StatusPengajianBM',
//                [
//                    'label' => 'StatusPengajianBM',
//                    'value' => function ($model) {
//                        if($model->StatusPengajianBM == 'DIJANGKA TAMAT')
//                            return 'TAMAT PENGAJIAN';
//                        else
//                            return $model->StatusPengajianBM;
//                    }
//                ],
                'LevelPengajian'
            ],
        ]);

?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center" rowspan="3">BIL.</th>
            <th class="text-center col-md-4" rowspan="3">TAHAP PENYELIAAN</th>
            <th class="text-center" colspan="4">BILANGAN PELAJAR DISELIA YANG AKTIF (TERKUMPUL)</th>
        </tr>
        <tr>
            <th class="text-center" colspan="2">SEBAGAI PENYELIA UTAMA/PENGERUSI</th>
            <th class="text-center" colspan="2">SEBAGAI PENYELIA BERSAMA/AHLI</th>
        </tr>
        <tr>
            <th class="text-center">TELAH PERLANJUTAN</th>
            <th class="text-center">BELUM PERLANJUTAN</th>
            <th class="text-center">TELAH PERLANJUTAN</th>
            <th class="text-center">BELUM PERLANJUTAN</th>
        </tr>
        <?php 
        $abc = 1;
        foreach($data as $dt) {
            if($dt['LevelPengajian'] == '1' OR $dt['LevelPengajian'] == '2')
                continue;
            ?>
            <tr>
                <td class="text-center"><?= $abc++; ?></td>
                <td ><?php 
                    switch($dt['LevelPengajian']){
                        case 'PHD':
                            echo 'PhD (Penyelidikan)';
                            break;
                        case 'MASTER':
                            echo 'Sarjana (Penyelidikan)';
                            break;
                        case 'M.Phil.':
                            echo 'DrPH (Doctor of Public Health)';
                            break;
                        default:
                            echo $dt['LevelPengajian'].' - <b>Penyeliaan Luar</b>';
                            break;
                    }
                ?> <?= ($dt['id'] > 0 && $lpp->PYD == Yii::$app->user->identity->ICNO && $lpp->PYD_sah == 0 AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat)
                        or ($dt['id'] > 0 && $lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) ? Html::button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['elnpt/update-penyeliaan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id]), 'class' => 'btn btn-warning btn-xs modalButton']).Html::a('<i class="fa fa-trash"></i>', ['elnpt/delete-penyeliaan', 'id' => $dt['id'], 'lppid' => $lpp->lpp_id], ['class' => 'btn btn-danger btn-xs']) : '' ?>
                <?= ($dt['id'] > 0 && $lpp->PYD != Yii::$app->user->identity->ICNO) ? '*' : '' ?></td>
                <td class="text-center"><?= $dt['utama_telah']; ?></td>
                <td class="text-center"><?= $dt['utama_belum']; ?></td>
                <td class="text-center"><?= $dt['sama_telah']; ?></td>
                <td class="text-center"><?= $dt['sama_belum']; ?></td>
            </tr>
        <?php } ?>
        <?php $form = ActiveForm::begin();
            $cnt = 1;
            foreach ($input as $ind => $inp) {
        ?>
        <tr>
            <td class="text-center"><?= $abc; ?></td>
            <td><?= $form->field($inp, "[$ind]tahap_penyeliaan")->hiddenInput(['value'=> $cnt])->label(false);?><?= ($cnt == 1) ? 'Sarjana (Kerja Kursus)' : 'Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)' ?></td>
            <td class="text-center"><?= $form->field($inp, "[$ind]utama_telah")->textInput(['style' => 'text-align:center;  width: 40%', 'class' => 'text-center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            <td class="text-center"><?= $form->field($inp, "[$ind]utama_belum")->textInput(['style' => 'text-align:center;  width: 40%', 'class' => 'text-center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            <td class="text-center"><?= $form->field($inp, "[$ind]sama_telah")->textInput(['style' => 'text-align:center;  width: 40%', 'class' => 'text-center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
            <td class="text-center"><?= $form->field($inp, "[$ind]sama_belum")->textInput(['style' => 'text-align:center;  width: 40%', 'class' => 'text-center', 'placeholder' => '0', 'disabled' => $flag])->label(false); ?></td>
        </tr>
    
            <?php 
            $cnt++;
            $abc++;}?>
        </table>
        <?php if((($lpp->PYD == Yii::$app->user->identity->ICNO AND $lpp->PYD_sah == 0) AND (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat))
                or ($lpp->PYD == \Yii::$app->user->identity->ICNO  AND (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
        
    
        <div style="clear: both;" class="form-group pull-right">
            <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'value'=>'create_add', 'name'=>'submit']) ?>
        </div>    
    <?php } ?>  

    <?php ActiveForm::end(); ?>
</div><br>

<?php if(!is_null($data2)) { ?>
<hr>

<?=
\yiister\gentelella\widgets\Accordion::widget(
    [
        'items' => [
            [
//                'active' => true,
                'title' => 'Click to view',
                'content' => '<div class="table-responsive">'.
                      $grid
                    .'</div>'
                
            ],
//            [
//                'title' => 'Collapsible Group Item #2',
//                'content' => '<p><strong>Collapsible Item 2 data</strong>
//                    </p>
//                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
//                ',
//            ],
//            [
//                'title' => 'Collapsible Group Item #3',
//                'content' => '<p><strong>Collapsible Item 3 data</strong>
//                    </p>
//                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
//                ',
//            ],
        ],
    ]
);
?>
<?php }?>

<div style="clear: both;"><br><hr>
    
    <dl class="dl-horizontal">
    <dt>Belum Perlanjutan</dt>
    <dd>Pelajar masih dalam tempoh pengajian yang ditetapkan seperti yang dinyatakan dalam surat tawaran menyambung pengajian.</dd>
    <dt>Telah Perlanjutan </dt>
    <dd>Pelajar telah memohon untuk <i>extend</i> tempoh pengajian melebihi tempoh yang dinyatakan dalam surat tawaran menyambung pengajian.</dd>
    </dl> 
    
            <?php if(($lpp->PPP == Yii::$app->user->identity->ICNO) OR ($lpp->PPK == Yii::$app->user->identity->ICNO)) { ?>
            <p><i>* Kursus yang ditambah secara manual oleh PYD.</i></p>
            <?php } ?>
</div>

