<?php

use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\models\kehadiran\TblRekod;
use app\models\cuti\AksesPengguna;
use app\models\hronline\Department;
use app\models\cuti\Tindakan;

$icno = Yii::$app->user->getId();

$icno2 = Tindakan::penerimaTindakan($icno);

$totalPendingRemark = TblRekod::totalPendingRemark($icno);
$pendingReason = $totalPendingRemark > 0 ? "&nbsp;<span class='badge bg-red'>$totalPendingRemark</span>" : '';

$totalPendingApproval = TblRekod::totalPendingApproval($icno2);
$ketidakpatuhan = $totalPendingApproval > 0 ? "&nbsp;<span class='badge bg-red'>$totalPendingApproval</span>" : '';;

$admin = AksesPengguna::findOne(['akses_cuti_icno' => $icno, 'akses_cuti_int' => 3]);
$penyelia = AksesPengguna::findOne(['akses_cuti_icno' => $icno, 'akses_cuti_int' => 2]);
$kj = Department::findOne(['chief' => $icno]);


NavBar::begin();
echo Nav::widget([
    'items' => [
        [
            'label' => "<i class='fa fa-user'></i>&nbsp;Staff$pendingReason",
            'items' => [
                //                ['label' => '<i class="fa fa-exchange"></i>&nbsp;Working hours(WBB)', 'url' => ['kehadiran/wbb']],
                //                ['label' => '<i class="fa fa-list"></i>&nbsp;Attendance report', 'url' => ['kehadiran/att-rpt']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Attendance report', 'url' => ['kehadiran/laporan_kehadiran']],
                ['label' => "<i class='fa fa-list'></i></i>&nbsp;Pending for reason$pendingReason", 'url' => ['kehadiran/tindakan_ketidakpatuhan']],
                ['label' => "<i class='fa fa-book'></i></i>&nbsp;Card Color report", 'url' => ['kehadiran/staf-color-list']],
                ['label' => '<i class="fa fa-info"></i>&nbsp;Card Colour info', 'url' => '#', 'linkOptions' => ['class' => 'mapBtn', 'id' => 'modalButton', 'value' => Url::to("kad_warna")]],
                ['label' => '<i class="fa fa-automobile"></i>&nbsp;Outstation', 'url' => Url::to("https://bendahari.ums.edu.my/aplikasi/module/login/login.cfm"), 'linkOptions' => ['target' => '_blank']],
                //                ['label' => '<i class="fa fa-file-video-o"></i>&nbsp;User manual', 'url' => Url::to("https://www.youtube.com/watch?v=gjuKEkfIS8c"), 'linkOptions' => ['target' => '_blank']],
                ['label' => '<i class="fa fa-book"></i>&nbsp;Guideline', 'url' => Url::to("@web/files/garis_panduan_kehadiran.pdf"), 'linkOptions' => ['target' => '_blank']],
                ['label' => "<i class='fa fa-home'></i></i>&nbsp;Mohon WFH", 'url' => ['kehadiran/wfh-mohon']],
                ['label' => "<i class='fa fa-list'></i></i>&nbsp;Senarai WFH / WFO", 'url' => ['kehadiran/wfh-list']],
                //                ['label' => '<i class="fa fa-question-circle"></i>&nbsp;Questionnaire', 'url' => Url::to("https://goo.gl/forms/lN70aPnLQhk3xX1D3"), 'linkOptions' => ['target' => '_blank']],
            ],
        ],
        [
            'label' => "<i class='fa fa-users'></i>&nbsp;Officer$ketidakpatuhan",
            'items' => [
                ['label' => "<i class='fa fa-exclamation-triangle'></i>&nbsp;Approval(Reason)$ketidakpatuhan", 'url' => ['kehadiran/senarai_tindakan']],
                //                ['label' => "<i class='fa fa-pencil-square-o'></i>&nbsp;Approval(Working hours)$wbb", 'url' => ['kehadiran/s_tindakan_wbb']],
                ['label' => '<i class="fa fa-file-o"></i>&nbsp;Card Colour Report', 'url' => ['kehadiran/staff-color-card']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Attendance report', 'url' => ['kehadiran/pantau-kehadiran']],
                ['label' => '<i class="fa fa-area-chart"></i>&nbsp;Monthly report', 'url' => ['kehadiran/monthly-summary']],
                '<li class="dropdown-header">Work from Home</li>',
                ['label' => '<i class="fa fa-users"></i>&nbsp;Senarai Tindakan WFH', 'url' => ['kehadiran/wfh-lulus']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan WFH', 'url' => ['kehadiran/pantau-permohonan-wfh-pegawai']],
            ],
        ],
        [
            'label' => '<i class="fa fa-id-card"></i>&nbsp;Head of Deparment',
            'items' => [
                ['label' => '<i class="fa fa-list"></i>&nbsp;Staff attendance', 'url' => ['kehadiran/kj-pantau-kehadiran']],
                ['label' => '<i class="fa fa-calendar-check-o"></i>&nbsp;Jadual WFH', 'url' => ['kehadiran/wfh-jadual-kj']],
                ['label' => '<i class="fa fa-users"></i>&nbsp;Senarai Tindakan WFH', 'url' => ['kehadiran/wfh-lulus']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Permohonan WFH', 'url' => ['kehadiran/pantau-permohonan-wfh-pegawai']],
            ],
            'visible' => $kj ? true : false,
        ],
        [
            'label' => '<i class="fa fa-edit"></i>&nbsp;Attendance Supervisor',
            'items' => [
                ['label' => '<i class="fa fa-address-book-o"></i>&nbsp;Staff lists', 'url' => ['kehadiran/senarai_kakitangan']],
                ['label' => '<i class="fa fa-bar-chart"></i>&nbsp;Staff Working hours', 'url' => ['kehadiran/staff-wbb']],
                ['label' => '<i class="fa fa-flag"></i>&nbsp;Monthly Reports', 'url' => ['kehadiran/sup-mth-rpt']],
                ['label' => '<i class="fa fa-globe"></i>&nbsp;Yearly Reports', 'url' => ['kehadiran/sup-year-rpt']],
                ['label' => '<i class="fa fa-file-o"></i>&nbsp;Card Colour Report', 'url' => ['kehadiran/senarai-warna-kad']],
                ['label' => '<i class="fa fa-list"></i>&nbsp;Pantau Staf', 'url' => ['kehadiran/pantau-staf']],
                ['label' => '<i class="fa fa-h-square"></i>&nbsp;Shields Status', 'url' => ['kehadiran/shield-status-list']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Shift Menu</li>',
                ['label' => '<i class="fa fa-users"></i>&nbsp;Staff Shift List', 'url' => ['kehadiran/staff-shift-list']],
                ['label' => '<i class="fa fa-wrench"></i>&nbsp;Shift Setup', 'url' => ['kehadiran/shift-setup']],
                ['label' => '<i class="fa fa-wrench"></i>&nbsp;Manage Supervisor/Staff', 'url' => ['kehadiran-admin/manage-shift-supervisor']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Work from Home</li>',
                ['label' => '<i class="fa fa-list"></i>&nbsp;Senarai Bulanan', 'url' => ['kehadiran/wfh-by-mth']],
                ['label' => '<i class="fa fa-calendar-check-o"></i>&nbsp;Jadual', 'url' => ['kehadiran/wfh-jadual']],
                ['label' => '<i class="fa fa-users"></i>&nbsp;Pantau Permohonan', 'url' => ['kehadiran/pantau-permohonan-wfh']],
            ],
            'visible' => ($penyelia ? true : $admin) ? true : false,
        ],
        [
            'label' => '<i class="fa fa-lock"></i>&nbsp;Administrator',
            'items' => [
                ['label' => '<i class="fa fa-address-book-o"></i>&nbsp;Staff lists', 'url' => ['kehadiran/staff-all']],
                ['label' => '<i class="fa fa-bar-chart"></i>&nbsp;Statistic(JFPIU)', 'url' => ['kehadiran/admin-mth-rpt']],
                // ['label' => '<i class="fa fa-credit-card"></i>&nbsp;Statistic(Card Color)', 'url' => ['kehadiran/admin-mth-rpt']],
                ['label' => '<i class="fa fa-list-ul"></i>&nbsp;Warning Letters', 'url' => ['kehadiran/color-rpt']],
                ['label' => '<i class="fa fa-fighter-jet"></i>&nbsp;Raw Data', 'url' => ['attendance/index']],
                ['label' => '<i class="fa fa-sign-out"></i>&nbsp;Senarai Keluar Pejabat', 'url' => ['kehadiran/senarai_keluar_pejabat']],
                ['label' => '<i class="fa fa-bath"></i>&nbsp;Admin Post (Akad)', 'url' => ['kehadiran/admin-post-list']],
                '<li class="divider"></li>',
                '<li class="dropdown-header">Work from Home</li>',
                ['label' => '<i class="fa fa-home"></i>&nbsp;Pantau Permohonan JAFPIB', 'url' => ['kehadiran/pantau-permohonan-wfh-admin']],
                ['label' => '<i class="fa fa-list-alt"></i>&nbsp;Jadual JAFPIB', 'url' => ['kehadiran/wfh-jadual-admin']],
                '<li class="divider"></li>',
                ['label' => '<i class="fa fa-medkit"></i>&nbsp;Vaccination Watchlist', 'url' => ['vaksinasi/watch-list']],
            ],
            'visible' => $admin ? true : false,
        ],
        [
            'label' => '<i class="fa fa-file-text-o"></i>&nbsp;Reports',
            'items' => [
                ['label' => '<i class="fa fa-address-book-o"></i>&nbsp;By Month(Range)', 'url' => ['kehadiran/range-month']],
                ['label' => '<i class="fa fa-flag"></i>&nbsp;Monthly Reports', 'url' => ['kehadiran/sup-mth-rpt']],
                ['label' => '<i class="fa fa-globe"></i>&nbsp;Yearly Reports', 'url' => ['kehadiran/sup-year-rpt']],
            ],
            'visible' => $admin ? true : false,
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
]);
NavBar::end();
?>
<br>