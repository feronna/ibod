<?php

use app\models\cuti\AksesPengguna;
use app\models\cuti\TblRecords;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;



NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => '<i class="fa fa-tachometer"></i>&nbsp;Dashboard', 'url' => ['cuti/individu/index'],
        ],
        [
            'label' => "<i class='fa fa-user'></i>&nbsp;Staff Menu" . $no1 = TblRecords::totalPending(Yii::$app->user->getId(), 1),
            'items' => [
                ['label' => '<i class="fa fa-plane"></i>&nbsp;Apply Leave', 'url' => ['cuti/individu/pilih']],
                ['label' => '<i class="fa fa-users"></i>&nbsp;Substitute' . $no1, 'url' => ['cuti/individu/ganti']],
                ['label' => '<i class="fa fa-file-text-o"></i>&nbsp;Leave Statement', 'url' => ['cuti/individu/statement']],
                ['label' => '<i class="fa fa-certificate"></i>&nbsp;Leave Entitlement', 'url' => ['cuti/individu/entitlement']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Application list', 'url' => ['cuti/individu/list']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Substitute list', 'url' => ['cuti/individu/substitute-list']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;GCR & CBTH Application', 'url' => ['cuti/individu/apply-gcr'], 'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 5)],
                ['label' => '<i class="fa fa-list"></i>&nbsp;My GCR & CBTH Application List', 'url' => ['cuti/individu/gcr-list']],
                // ['label' => '<i class="fa fa-list"></i>&nbsp;Apply GCR & CBTH', 'url' => ['cuti/individu/apply-gcr']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp;Officer Menu" . $no2 = TblRecords::totalPending(Yii::$app->user->getId(), 2),
            'items' => [
                ['label' => '<i class="fa fa-pencil-square-o"></i>&nbsp:Pending List' . TblRecords::totalPending(Yii::$app->user->getId(), 7), 'url' => ['cuti/pegawai/senarai-peraku-lulus']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;GCR & CBTH Application List' . TblRecords::totalPending(Yii::$app->user->getId(), 5), 'url' => ['cuti/pegawai/gcr-list-checked']],
                ['label' => '<i class="fa fa-pencil-square-o"></i>&nbsp:Approved Leave List', 'url' => ['cuti/pegawai/list']],
                ['label' => '<i class="fa fa-list"></i>&nbsp:Staff Under My Supervision', 'url' => ['cuti/pegawai/staff-leave']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;GCR & CBTH Application List (Ketua Jabatan BSM)', 'url' => ['cuti/pegawai/sort'], 'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 3)],
                // ['label' => '<i class="fa fa-list"></i>&nbsp;Research Leave Application', 'url' => ['cuti/pegawai/cp-list']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Back On Duty', 'url' => ['cuti/pegawai/bod-list']],
            ],
        ],
        [
            'label' => "<i class='fa fa-star'></i>&nbsp;Supervisor Menu" . $no3 = TblRecords::totalPending(Yii::$app->user->getId(), 3),
            'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 0),
            'items' => [
                ['label' => '<i class="fa fa-plane"></i>&nbsp;Sick Leave List' . $no3, 'url' => ['cuti/supervisor/sick-leave-list']],
                ['label' => '<i class="fa fa-users"></i>&nbsp;Supervised Staff', 'url' => ['cuti/supervisor/supervised-staff/']],
                ['label' => '<i class="fa fa-file-text-o"></i>&nbsp;Monthly Statement', 'url' => ['cuti/supervisor/leave-statement-report']],
                ['label' => '<i class="fa fa-certificate"></i>&nbsp;Monitor Staff Leave', 'url' => ['cuti/supervisor/leave-monitoring']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Leave Calender', 'url' => ['cuti/supervisor/calender']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;GCR & CBTH Application List', 'url' => ['cuti/supervisor/gcr-list']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Reset GCR & CBTH Application', 'url' => ['cuti/supervisor/gcr-list-checked']],
            ],
        ],
        [
            'label' => "<i class='fa fa-star'></i>&nbsp;Admin Menu" . $no4 = TblRecords::totalPending(Yii::$app->user->getId(), 4),
            'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 1),
            'items' => [
                ['label' => '<i class="fa fa-plane"></i>&nbsp; Verify' . $no4, 'url' => ['cuti/admin/cr2-list']],
                ['label' => '<i class="fa fa-users"></i>&nbsp;On Behalf Of', 'url' => ['cuti/admin/behalf-list']],
                ['label' => '<i class="fa fa-file-text-o"></i>&nbsp;Access', 'url' => ['cuti/admin/access']],
                ['label' => '<i class="fa fa-certificate"></i>&nbsp;GCR Application List', 'url' => ['cuti/admin/gcr-application-list']],
                // ['label' => '<i class="fa fa-list"></i>&nbsp;Report', 'url' => ['cuti/admin/report']],
                ['label' => '<i class="fa fa-calendar"></i>&nbsp;Public Holiday Calender', 'url' => ['cuti/admin/ph-list']],
                ['label' => '<i class="fa fa-calendar"></i>&nbsp;Maternity Leave', 'url' => ['cuti/admin/cb-list']],
                ['label' => '<i class="fa fa-calendar"></i>&nbsp;Add Apply GCR After Closed Date', 'url' => ['cuti/admin/admin-index']],
            ],
        ],
        [
            'label' => "<i class='fa fa-star'></i>&nbsp;Report",
            'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 1),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Report by Department (Date Range)', 'url' => ['cuti/admin/report']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Statistic by Leave Type', 'url' => ['cuti/admin/report-leave-list']],
            ],
        ],
        [
            'label' => "<i class='fa fa-star'></i>&nbsp;Sector HR",
            'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 1),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Manage(Surat)', 'url' => ['manage/list']],
            ],
        ],
        [
            'label' => "<i class='fa fa-star'></i>&nbsp;Pentadbiran",
            'visible' => AksesPengguna::visible(Yii::$app->user->getId(), 7),
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp; Senarai Permohonan HSO', 'url' => ['cuti/pegawai/report']],
            ],
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>