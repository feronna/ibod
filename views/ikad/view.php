<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ikad\TblMohon */

$this->title = $model->d_mohon_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Mohons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-mohon-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->d_mohon_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->d_mohon_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'd_mohon_id',
            'd_pemohon_icno',
            'd_bahasa_kad',
            'd_gelaran_bm',
            'd_gelaran_bi',
            'd_nama',
            'd_edu_bi_1',
            'd_edu_bi_2',
            'd_edu_bm_1',
            'd_edu_bm_2',
            'd_jawatan_bi',
            'd_jawatan_bm',
            'd_jbtn_bi',
            'd_jbtn_bm',
            'd_kampus_bi',
            'd_kampus_bm',
            'd_kampus2_bi',
            'd_kampus2_bm',
            'd_office_telno',
            'd_office_extno',
            'd_faxno',
            'd_hpno',
            'd_email:email',
            'd_pieces',
            'd_tarikh_mohon',
            'd_hantar',
            'd_tarikh_hantar',
            'd_status_kad',
            'd_status_tarikh',
            'd_update_id',
            'd_peraku_peg',
            'd_peraku_peg_id',
            'd_peraku_peg_dt',
        ],
    ]) ?>

</div>
