<?php

use yii\helpers\Html;
?>
<li role="presentation" class="dropdown">
    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <?php if($total != 0){?>
        <span class="badge bg-green"><?= $total ?></span>
        <?php } ?>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
        <?php ?>
        <li style="background-color:white; border-bottom: 1px solid #000">
            <div style="float: left"><input type="checkbox" onclick="selectall(this)"></div>
            <div style="margin-left:20px">
                <a onclick="archivenoti()" title="Archive" data-toggle="popover" data-trigger="hover">
                    <span class="image">
                        <i class="fa fa-archive"></i>
                    </span></a>
                <a onclick="markreadnoti()" title="Mark as read" data-toggle="popover" data-trigger="hover">
                    <span class="image">
                        <i class="fa fa-envelope-open-o"></i>
                    </span></a>
            </div>
        </li>
        <?php foreach ($noti as $ntf) { ?>
        <li>
            <div style="float: left"><input type="checkbox" name="checknoti" value="<?= $ntf->id ?>"></div>
            <div style="margin-left:20px">
                <?= Html::a('
                    <span class="image">
                        <i class="fa fa-calendar-check-o"></i>
                    </span>
                    <span>
                        <span> ' . $ntf->shortTitle . '</span>
                        <span class="time"> ' . $ntf->formattedntfdt . '</span>
                    </span>
                    <span class="message">
                        ' . $ntf->short . '
                    </span>', ['site/read_noti', 'id' => $ntf->id]) ?>
            </div>
            </li>
        <?php } ?>
        <li>
            <div class="text-center">
                <?= Html::a('<strong>Pusat Notifikasi</strong>
                    <i class="fa fa-angle-right"></i>', ['site/notifikasi']) ?>
            </div>
        </li>
    </ul>
</li>
<script>
function selectall(val){
  checkboxes = document.getElementsByName('checknoti');
  for (i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = val.checked;
  } 
}

function archivenoti(){
    checkboxes = document.getElementsByName('checknoti');
    for (i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked === true){
    $.ajax({
           timeout: 0,
           url: "/staff/web/site/send_archive?id="+checkboxes[i].value,
           success: function(data) {
    }
      });}}
      
      location.reload();
}

function markreadnoti(){
    checkboxes = document.getElementsByName('checknoti');
    for (i = 0; i < checkboxes.length; i++) {
        if(checkboxes[i].checked === true){
    $.ajax({
           timeout: 0,
           url: "/staff/web/site/mark_read?id="+checkboxes[i].value,
           success: function(data) {
    }
      });}}
      
      location.reload();
}
</script>