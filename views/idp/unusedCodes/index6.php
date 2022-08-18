<?php
use yii\helpers\Html;
use kartik\popover\PopoverX;
use app\assets\AppAsset;

$bundle = yiister\gentelella\assets\Asset::register($this);
AppAsset::register($this);

$content = '<p class="text-justify">' .
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.' . 
        '</p>';
        
// right
PopoverX::widget([]);

/*** Example *****/
$js2 = <<< 'SCRIPT'
$(function() {
    // use the popoverButton plugin
    $('#kv-btn-1').popoverButton({
        placement: 'left', 
        target: '#myPopover5'
    });
});
$(function() {
    $('#kv-btn-2').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js2);

?><!-- PopoverX Placement -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover1" data-placement="top">Top</button>
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover2" data-placement="right">Right</button>
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover3" data-placement="bottom">Bottom</button>
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover4" data-placement="left">Left</button>
<br>
<div id="myPopover1" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover2" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover3" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover4" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover10a" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover10b" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover10c" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover10d" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover20a" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover20b" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover20c" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover20d" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<br>
<!-- PopoverX Auto Placements -->
<button class="btn btn-success btn-lg" data-toggle="popover-x" data-target="#myPopover30a" data-placement="auto">Auto (Any)</button>
<button class="btn btn-warning btn-lg" data-toggle="popover-x" data-target="#myPopover30b" data-placement="horizontal">Auto Horizontal</button>
<button class="btn btn-warning btn-lg" data-toggle="popover-x" data-target="#myPopover30c" data-placement="vertical">Auto Vertical</button>
<hr>
<button class="btn btn-info btn-lg" data-toggle="popover-x" data-target="#myPopover40a" data-placement="auto-top">Auto Top</button>
<button class="btn btn-info btn-lg" data-toggle="popover-x" data-target="#myPopover40b" data-placement="auto-bottom">Auto Bottom</button>
<button class="btn btn-info btn-lg" data-toggle="popover-x" data-target="#myPopover40c" data-placement="auto-right">Auto Right</button>
<button class="btn btn-info btn-lg" data-toggle="popover-x" data-target="#myPopover40d" data-placement="auto-left">Auto Left</button>
<hr>
<br>
<div id="myPopover30a" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover30b" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover30c" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover40a" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover40b" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover40c" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
<div id="myPopover40d" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="popover-footer">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button><button type="reset" class="btn btn-sm btn-secondary">Reset</button>
    </div>
</div>
 <br>
<!-- PopoverX Sizes -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover13a" data-placement="right">Large</button>
<button type="button" class="btn btn-primary btn-lg" data-toggle="popover-x" data-target="#myPopover13b" data-placement="top">Medium</button>
 <!-- PopoverX content -->
<div id="myPopover13a" class="popover popover-x popover-default popover-lg">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Large PopoverX</div>
    <div class="popover-body popover-content">
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 <br>
<!-- PopoverX content -->
<div id="myPopover13b" class="popover popover-x popover-default popover-md">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Medium PopoverX</div>
    <div class="popover-body popover-content">
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 <br>
<!-- PopoverX Show on init -->
<button type="button" class="btn btn-info" data-toggle="popover-x" data-target="#myPopover15a" data-placement="right" data-show="true"><i class="fa fa-exclamation-circle"></i> Info</button>
 <!-- PopoverX content -->
<div id="myPopover15a" class="popover popover-x popover-info">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Details</div>
    <div class="popover-body popover-content">
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <button type="button" class="btn btn-primary" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover1a" data-placement="bottom">Primary</button>
<button type="button" class="btn btn-info" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover2a" data-placement="bottom">Info</button>
<button type="button" class="btn btn-danger" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover3a" data-placement="bottom">Danger</button>
<button type="button" class="btn btn-success" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover4a" data-placement="bottom">Success</button>
<button type="button" class="btn btn-warning" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover5a" data-placement="bottom">Warning</button>
<button type="button" class="btn btn-secondary" style="margin-right:15px" data-toggle="popover-x" data-target="#myPopover6a" data-placement="bottom">Default</button>
 <br>
<!-- PopoverX content -->
<div id="myPopover1a" class="popover popover-x popover-primary">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <!-- PopoverX content -->
<div id="myPopover2a" class="popover popover-x popover-info">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <!-- PopoverX content -->
<div id="myPopover3a" class="popover popover-x popover-danger">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <!-- PopoverX content -->
<div id="myPopover4a" class="popover popover-x popover-success">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <!-- PopoverX content -->
<div id="myPopover5a" class="popover popover-x popover-warning">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
 
 <!-- PopoverX content -->
<div id="myPopover6a" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Title</div>
    <div class="popover-body popover-content">
        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
</div>
<br>
<!-- Display advanced HTML content in popover with auto placement functionality -->
<!-- Button -->
<button type="button" class="btn btn-secondary btn-lg" data-toggle="popover-x" data-target="#myPopover1b" data-placement="auto">Login</button>
 
<!-- PopoverX content -->
<form class="form-vertical">
    <div id="myPopover1b" class="popover popover-x popover-default">
        <div class="arrow"></div>
        <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>Enter credentials</div>
        <div class="popover-body popover-content">
            <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
            <div class="form-group">
                <input class="form-control" placeholder="Username">
            </div>
            <input type="password" class="form-control" placeholder="Password">
        </div>
        <div class="popover-footer">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            <button type="reset" class="btn btn-sm btn-secondary">Reset</button>
        </div>
    </div>
</form>
<br>
<!-- Triggering popover via javascript. -->
<!-- Button -->
<button type="button" id="kv-btn-1" class="btn btn-secondary btn-lg">Launch 1</button>
 
<!-- PopoverX content -->
<div id="myPopover5" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>My Header</div>
    <div class="popover-body popover-content">
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
    </div>
</div>
 
<!--<script>
$(document).on('ready', function() {
    // use the popoverButton plugin
    $('#kv-btn-1').popoverButton({
        placement: 'left', 
        target: '#myPopover5'
    });
});
</script>-->
<br>
<!-- Triggering popover on hover/focus instead of click. -->
<!-- Button -->
<button type="button" id="kv-btn-2" class="btn btn-secondary btn-lg">Launch 2</button>
 
<!-- PopoverX content -->
<div id="myPopover6" class="popover popover-x popover-default">
    <div class="arrow"></div>
    <div class="popover-header popover-title"><button type="button" class="close" data-dismiss="popover-x">&times;</button>My Header</div>
    <div class="popover-body popover-content">
        <p class="text-justify">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.</p>
    </div>
</div>
<!-- 
<script>
$(document).on('ready', function() {
    $('#kv-btn-2').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
</script>-->



