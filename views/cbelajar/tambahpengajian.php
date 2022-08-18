<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Rekod Maklumat Pengajian';

?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
     <?php echo $this->render('/cutibelajar/_topmenu'); ?>

    <div class="x_panel">
        
        <div class="x_content">
<div class="tblpengajian-create">

    <?= $this->render('_formpengajian', [
        'model' => $model,
        'iklan' => $iklan,
    ]) ?>

</div>
        </div>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

