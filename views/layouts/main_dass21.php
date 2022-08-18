<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */
use yii\helpers\Html;
use kartik\growl\Growl;
use app\assets\AppAsset;
use aryelds\sweetalert\SweetAlert;
use app\widgets\NotificationWidget;
use yii\bootstrap\Modal;
use kartik\spinner\Spinner;
use app\models\dass\TblUserAccess;

$bundle = yiister\gentelella\assets\Asset::register($this);

AppAsset::register($this);

if(!Yii::$app->user->isGuest) {
    $tmp = TblUserAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->one();
}
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
    <?php $this->beginBody(); ?>
    <div class="container body">
        <!-----------------------------SweetAlert-------------------------->
        <?php if (Yii::$app->session->hasFlash('alert')) { ?>
        <?php $msg = Yii::$app->session->getFlash('alert'); ?>
        <?php
        echo SweetAlert::widget([
            'options' => [
                'title' => $msg['title'],
                'text' => $msg['msg'],
                'type' => $msg['type'],
            ]
        ]);
        ?>

        <?php  ?>
        <?php 
    } ?>
        <!-----------------------------SweetAlert-------------------------->
        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title"><i class="fa fa-ravelry"></i> <span>HROnline v4</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1(Yii::$app->user->id)); ?>.jpeg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Selamat Datang,</span>
                            <h2><?php echo ucfirst(Yii::$app->user->identity->CONm); ?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3><?= is_null($tmp) ? '' : 'Menu'?></h3>
                            <?php
                            echo \yiister\gentelella\widgets\Menu::widget(
                                [
                                    "items" => [
                                        ["label" => "Home", "url" => ["dass21/index"], "icon" => "home"],
                                        ["label" => "Dashboard", "url" => ["dass21/dashboard"], "icon" => "user-circle-o", "visible" => (is_null($tmp) ? false : true)],
                                        //["label" => "Permohonan Jawatan", "url" => ["openpos/index"], "icon" => "envelope-square"],

                                        //["label" => "Pelantikan Semula Kontrak", "url" => ["kontrak/mohonlanjut"], "icon" => "book"],
                                        //["label" => "Sumber Manusia", "url" => ["biodata/view?id=" . Yii::$app->user->getId()], "icon" => "book"],
                                    ],
                                ]
                            )
                            ?>
                            <?php
 //                                echo
                            //                                \yiister\gentelella\widgets\Menu::widget(
                            //                                        [
                            //                                            "items" => [
                            //                                                    ["label" => "Laman Utama", "url" => ["site/index"], "icon" => "home"],
                            //                                                    ["label" => "Maklumat Eksekutif", "url" => ["site/eis"], "icon" => "info-circle"],
                            //                                                    [
                            //                                                    "label" => "Pengurusan Diri",
                            //                                                    "url" => "#",
                            //                                                    "icon" => "user",
                            //                                                    "items" => [
                            //                                                            [
                            //                                                            "label" => "Tindakan Individu",
                            //                                                            "url" => "#",
                            //                                                            "items" => [
                            //                                                                    [
                            //                                                                    "label" => "Kenaikan Pangkat",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "IDP",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "Lanjut Kontrak",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "Rekod Harta",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "Kehadiran",
                            //                                                                    "url" => ["kehadiran/index"],
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "WBB",
                            //                                                                    "url" => ["kehadiran/wbb"],
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "Cuti",
                            //                                                                    "url" => ["cuti/default"],
                            //                                                                ],
                            //                                                            ],
                            //                                                        ],
                            //                                                            [
                            //                                                            "label" => "Keperluan Jabatan",
                            //                                                            "url" => "#",
                            //                                                            "items" => [
                            //                                                                    [
                            //                                                                    "label" => "Laporan Lonjakan",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                                    [
                            //                                                                    "label" => "Rekod MoU,MoA dan Lol",
                            //                                                                    "url" => "",
                            //                                                                ],
                            //                                                            ],
                            //                                                        ],
                            //                                                            [
                            //                                                            "label" => "Maklumat Peribadi",
                            //                                                            "url" => ["profil/default"],
                            //                                                        ],
                            //                                                    ],
                            //                                                ],
                            //                                                    ["label" => "Sumber Manusia", "url" => ["site/bsm"], "icon" => "id-card"],
                            //                                                    ["label" => "Pentadbiran & Governan", "url" => ["site/bpg"], "icon" => "suitcase"],
                            //                                                    ["label" => "Perundangan & Integriti", "url" => ["site/bpi"], "icon" => "handshake-o"],
                            //                                                    ["label" => "Keselamatan", "url" => ["site/bk"], "icon" => "shield"],
                            //                                                    ["label" => "Pengurusan Kualiti", "url" => ["site/bpq"], "icon" => "check-square-o"],
                            //                                                    ["label" => "Laporan", "url" => ["site/laporan"], "icon" => "file-text-o"],
                            //                                                    ["label" => "Bantuan", "url" => ["site/help"], "icon" => "question-circle"],
                            //                                            ],
                            //                                        ]
                            //                                )
                            ?>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <!--                            <a data-toggle="tooltip" data-placement="top" title="Logout">
                                                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                                                        </a>-->
                        <?= Html::a(' <span class="glyphicon glyphicon-off" aria-hidden="true"></span>', ['/site/logout'], ['data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Logout']) ?>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1(Yii::$app->user->id)); ?>.jpeg" alt=""><?php echo (explode(' ', Yii::$app->user->identity->CONm, 2)[0]); ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <!--                                        <li><a href="javascript:;">  Profile</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:;">
                                                                                        <span class="badge bg-red pull-right">50%</span>
                                                                                        <span>Settings</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:;">Help</a>
                                                                                </li>-->
                                    <!--<li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>-->
                                    <li><?= Html::a('<i class="fa fa-sign-out pull-right"></i>Log Out', ['/site/logout'], ['class' => '']) ?></li>

                                </ul>
                            </li>
                            <!-- letak ni notification widget -->
                            <?= NotificationWidget::widget() ?>
                            <!-- letak ni notification widget -->

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <?php if (isset($this->params['h1'])) : ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="clearfix"></div>
                <?= $content ?>
                <?php
                $spinner = Spinner::widget([
                    'preset' => Spinner::LARGE,
                    'color' => 'blue',
                    'align' => 'center'
                ])
                ?>
                <?php
                Modal::begin([
                    'header' => '<i class="fa fa-info-circle"></i>',
                    'id' => 'modal',
                    'size' => 'modal-lg',
                ]);

                echo "<div id='modalContent'><div class='well'> . $spinner .</div></div>";

                Modal::end();
                ?>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    &copy; Bahagian Sumber Manusia, Universiti Malaysia Sabah <?= date('Y'); ?>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <!-- /footer content -->
    <?php $this->endBody(); ?>
</body>

<?php  ?>

<?php  ?>

<?php  ?>
<?php  ?>

<?php  ?>

<?php  ?>

<?php  ?>

<?php  ?>

<?php  ?>
<?php  ?>
<?php  ?>
<?php  ?>
<?php  ?>

<?php  ?>
<?php  ?>
<?php  ?>

<?php  ?>

<?php  ?>
<?php  ?>
<?php  ?>

<?php  ?>
<?php  ?>

<?php  ?>

<?php  ?>

</html>
<?php $this->endPage(); ?> 