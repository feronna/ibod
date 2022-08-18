<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\latihan\IdpV */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Idp Vs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="idp-v-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'tahun',
            'susunan',
            'kumpulan',
            'nama_kumpulan',
            'v_co_icno',
            'v_co_umsper',
            'v_co_title',
            'v_co_name',
            'v_co_gender',
            'v_co_sts',
            'v_co_app_cd',
            'v_co_app',
            'v_co_app_startdate',
            'campus_id',
            'v_co_campus',
            'v_co_gred',
            'v_co_jwtn',
            'DeptId',
            'v_co_dept_sn',
            'v_co_dept_fn',
            'v_co_job_grp',
            'v_co_cpd_group_name',
            'v_co_sand_date',
            'v_co_tempoh_sandangan_month',
            'v_co_tempoh_sandangan_year',
            'gred_skim',
            'gred_no',
            'kategori',
            'tahap',
            'gredjawatan',
            'v_co_cpd_group',
            'v_mata_minima',
            'v_mata_terkumpul',
            'v_cf_umum',
            'v_idp_teras',
            'v_idp_elektif',
            'v_idp_umum',
            'pp',
            'hod',
            'isPegawaiUtama',
            'updatedate',
            'bhgn_id',
            'ServStatusNm',
            'ServStatusCd',
            'ServStatusStDt',
            'v_matamin_teras_uni',
            'v_idp_teras_uni',
            'v_cf_teras_skim',
            'v_matamin_teras_skim',
            'v_idp_teras_skim',
            'v_cf_elektif',
            'v_matamin_elektif',
        ],
    ]) ?>

</div>
