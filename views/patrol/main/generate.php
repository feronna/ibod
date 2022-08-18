<?php

use app\models\patrol\RefBit;
use app\models\patrol\RefRoute;
use dosamigos\datepicker\DatePicker;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/patrol/_menu') ?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
$today = Yii::$app->getRequest()->getQueryParam('date');

?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Searching</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
<?php echo '<img src="' . $qrCode->writeDataUri() . '">';
 ?>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
         
        </div>
    </div>
</div>
