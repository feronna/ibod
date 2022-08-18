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
use app\widgets\SideMenuWidget;
use yii\bootstrap\Modal;
use kartik\spinner\Spinner;
use ercling\pace;

$bundle = yiister\gentelella\assets\Asset::register($this);

AppAsset::register($this);
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
        <?php
        //            echo \app\widgets\PdpaWidget::widget() 
        ?>
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

            <?php ?>
        <?php }
        ?>
        <!-----------------------------SweetAlert-------------------------->
        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title">
                            <!--<i class="fa fa-ravelry"></i>-->
                            <?= Html::img('@web/images/hronline_logo.png', ['alt' => 'some', 'class' => 'thing', 'width' => '50px']); ?>
                            <span><?=Yii::$app->name; ?></span>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <!--                        <div class="profile">
                                                    <div class="profile_pic">
                                                        <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php //strtoupper(sha1(Yii::$app->user->id));         
                                                                                                                ?>.jpeg" alt="..." class="img-circle profile_img">
                                                    </div>
                                                    <div class="profile_info">
                                                        <span>Welcome,</span>
                                                        <h2><?php //echo ucfirst(Yii::$app->user->identity->CONm);         
                                                            ?></h2>
                                                    </div>
                                                </div>-->
                    <!-- /menu prile quick info -->

                    <!--<br />-->

                    <!-- sidebar menu -->

                   <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                            <div class="menu_section">
<!--                                <h2>Welcome</h2><br/>-->
<br/><br/>
                                <h3 class="text-center"><?= strtolower(\Yii::$app->user->identity->ICNO); ?></h3><br/>

                                <?php
                                

                                    echo \yiister\gentelella\widgets\Menu::widget(
                                          [
                                                "items" => [
//                                                    [
//                                                        "label" => "HALAMAN ADMIN",
//                                                        "url" => ["cb-lkk/halaman-admin"],
//                                                        "icon" => "home",
//                                                    ],
                                                    
                                                    
//                                                    [
//                                                        "label" => "ADMIN",
//                                                        "url" => ["cbadmin/tambah-admin"],
//                                                        "icon" => "plus",
//                                                    ],
//                                                    [
//                                                        "label" => "SUPERVISOR INFORMATION",
//                                                        "url" => ["cb-lkk/profil"],
//                                                        "icon" => "user",
//                                                    ],
                                                    [
                                                        "label" => "LIST OF STUDENT",
                                                        "url" => ["cb-lkk/student-list"],
                                                        "icon" => "plus",
                                                    ],
                                                    
                                                    
                                                ]
                                            ]
                                    );

//                                    echo \yiister\gentelella\widgets\Menu::widget(
//                                            [
//                                                "items" => [
//                                                    ["label" => "  LKK REPORT", "url" => ["cbadmin"], "icon" => "bar-chart"],
//                                                ],
//                                            ]
//                                    );
//                                    
                                    

//                                    echo \yiister\gentelella\widgets\Menu::widget(
//                                            [
//                                                "items" => [
//                                                    ["label" => "Student(s)", "url" => ["pemohon/halaman-utama"], "icon" => "graduation-cap"],
//                                                ],
//                                            ]
//                                    );
                                
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
                            <li class="nav-item dropdown">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php //$name = ucfirst(strtolower(Yii::$app->user->identity->CONm)); 
                                    ?>
                            <?= Html::img('@web/images/user.png', ['alt' => 'some', 'class' => 'thing', 'width' => '50px']); ?>

                                                                                                                                                        
                                    <span class=" fa fa-angle-down"></span>
                                </a>

                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><?= Html::a('<i class="fa fa-sign-out pull-right"></i>Log Out', ['/site/logout'], ['class' => '']) ?></li>

                                </ul>
                            </li>

                            <!-- letak ni notification widget -->
                         <!--   NotificationWidget::widget() ?> -->
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
                <?= \app\widgets\CrawlerWidget::widget() ?>

                <!-- temporary solution dlu by miji 24 april 2019-->
                <?php
                if (Yii::$app->controller->id == 'kehadiran') {
                    echo $this->render('/kehadiran/_menu');
                } elseif (substr(Yii::$app->controller->id, 0, 4) == 'cuti'&& 
                        substr(Yii::$app->controller->id,0,11) != 'cutibelajar' && substr(Yii::$app->controller->id,0,13) != 'cutisabatikal' ) {
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