<?php

use yii\helpers\Html;
?>
<?php if($model){ ?>
<marquee behavior="scroll" direction="left" scrolldelay="50" onmouseover="this.stop();" onmouseout="this.start();">

    <span class="glyphicon glyphicon-bullhorn" style="font-size:14px; padding: 0px 10px 0px 5px;"></span>
    <span class="fontblue" style="padding: 0px 5px 0px 0px;"></span>
    <span class="fontgrey" style="color: red;"> 
    <?php foreach ($model as $data) { ?>
        <?= $data->title ?> -> <?= strip_tags($data->content) ?>&nbsp;&nbsp; / &nbsp;&nbsp;
    <?php } ?>
    </span>

</marquee>
<?php } ?>