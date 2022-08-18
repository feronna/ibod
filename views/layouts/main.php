<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\utilities\DiariKetuaJbtn;
use aryelds\sweetalert\SweetAlert;
use app\widgets\NotificationWidget;
use app\widgets\SideMenuWidget;
use yii\bootstrap\Modal;
use kartik\spinner\Spinner;
use yii\widgets\Breadcrumbs;

$bundle = yiister\gentelella\assets\Asset::register($this);

AppAsset::register($this);
$timer_start = microtime(1);
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
    <title><?= Html::encode(Yii::$app->name) ?></title>
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
        <?php } ?>
        <!-----------------------------SweetAlert-------------------------->
        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title">
                            <?= Html::img('@web/images/hronline_logo.png', ['alt' => 'some', 'class' => 'thing', 'width' => '50px']); ?>
                            <span><?= Yii::$app->name; ?></span>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- sidebar menu -->
                    <!-- ni yg menu baru -->
                    <?php //echo $this->render('side_menu');
                    ?>
                    <!-- ni yg menu baru -->
                    <?php
                    echo SideMenuWidget::widget();
                    ?>

                    <!-- testing side menu baru -->
                    <?php
                    //uncomment utk testing
                    // echo app\widgets\SideMenuNewWidget::widget();
                    ?>

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
                        <?php echo Html::a(' <span class="glyphicon glyphicon-off" aria-hidden="true"></span>', ['/site/logout'], ['data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Logout']) ?>
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
                            <li class="nav-item dropdown">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php //$name = ucfirst(strtolower(Yii::$app->user->identity->CONm)); 
                                    ?>

                                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1(Yii::$app->user->id)); ?>.jpeg" alt=""><?php //echo (explode(' ', $name)[0]) . ' ' .  (explode(' ', $name)[1]);         
                                                                                                                                                        ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>

                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><?= Html::a('<i class="fa fa-user pull-right"></i>&nbsp;My Profile', ['/biodata/userview'], ['class' => '']) ?></li>
                                    <?php if (DiariKetuaJbtn::isKj(Yii::$app->user->id)) { ?>
                                        <li><?= Html::a('<i class="fa fa-book pull-right"></i>&nbsp;Diari', ['/diari/index'], ['class' => '']) ?></li>
                                    <?php } ?>
                                    <li><?= Html::a('<i class="fa fa-lock pull-right"></i>&nbsp;Change Password', 'https://drive.google.com/file/d/11E7IFgWxNnBiq1IuA2z8CoPDMvQz13vi/view', ['target' => '_blank']) ?></li>
                                    <li><?= Html::a('<i class="fa fa-sign-out pull-right"></i>Log Out', ['/site/logout'], ['class' => '']) ?></li>
                                </ul>
                            </li>

                            <!-- letak ni notification widget -->
                            <?= NotificationWidget::widget() ?>
                            <!-- letak ni notification widget -->

                            <li style="cursor: pointer;"><a class="user-profile" aria-expanded="false" onclick="showkukuro()">
                                    <img src="https://www.ums.edu.my/v5/images/kukuro_h.png"></a></li>

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
                <?= \app\widgets\CrawlerWidget::widget() ?>

                <!-- temporary solution dlu by miji 24 april 2019-->
                <?php
                if (Yii::$app->controller->id == 'kehadiran' || Yii::$app->controller->id == 'kehadiran-admin') {
                    echo $this->render('/kehadiran/_menu');
                } elseif (
                    substr(Yii::$app->controller->id, 0, 4) == 'cuti' &&
                    substr(Yii::$app->controller->id, 0, 11) != 'cutibelajar' && substr(Yii::$app->controller->id, 0, 13) != 'cutisabatikal'
                ) {
                    echo $this->render('/cuti/_menu');
                }
                ?>
                <!-- temporary solution dlu by miji 24 april 2019-->
                <?=
                ercling\pace\PaceWidget::widget([
                    'color' => 'blue',
                    'theme' => 'flash',
                    'options' => [
                        'ajax' => ['trackMethods' => ['GET', 'POST']]
                    ]
                ])
                ?>
                <?=
                Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('yii', 'Home'),
                        //'url' => Yii::$app->homeUrl,
                    ],
                    'links' => (isset($this->params['breadcrumbs']) && (Yii::$app->controller->id == 'data')) ? $this->params['breadcrumbs'] : [],
                ])
                ?>

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
                <?php
                Modal::begin([
                    'header' => '<i class="fa fa-info-circle"></i>',
                    'id' => 'mod',
                    'size' => 'modal-lg',
                ]);

                echo "<div id='content'><div class='well'> . $spinner .</div></div>";

                Modal::end();
                ?>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <?php echo "Generated in " . (round((microtime(1) - $timer_start), 4)) . " sec."; ?>
                <?php //opcache_get_status(); 
                ?>
                <div class="pull-right">
                    &copy; Registrar Department, Universiti Malaysia Sabah <?= date('Y'); ?>
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
<?php echo $this->render('kukuro'); ?>

</html>
<?php $this->endPage(); ?>
<style>
    .navbar-nav .open .dropdown-menu {
        position: absolute;
        background:
            #fff;
        margin-top: 0;
        border: 1px solid #D9DEE4;
        -webkit-box-shadow: none;
        right: 0;
        left: auto;
        width: auto;
    }
</style>
<script>
    function showkukuro() {
        var x = document.querySelectorAll('[id=botmanWidgetRoot]');
        for (var i = 0; i < x.length; i++) {
            if (x[i].style.display === "none") {
                x[i].style.display = "block";
                botmanChatWidget.open();
            } else {
                x[i].style.display = "none";
            }
        }
    }

    function start() {
        var x = document.querySelectorAll('[id=botmanWidgetRoot]');
        for (var i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
    }
    window.addEventListener('load', function() {
        start();
    });

    function showkukuro() {
        var x = document.querySelectorAll('[id=botmanWidgetRoot]');
        for (var i = 0; i < x.length; i++) {
            if (x[i].style.display === "none") {
                x[i].style.display = "block";
                botmanChatWidget.open();
            } else {
                x[i].style.display = "none";
            }
        }
    }
</script>