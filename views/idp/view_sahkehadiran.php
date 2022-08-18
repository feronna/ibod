<?php
//require './vendor/autoload.php'; 
use Zxing\QrReader;
use yii\helpers\Html;
use yii\widgets\DetailView;
use Da\QrCode\QrCode;
use yii\helpers\Url;

echo $this->render('/idp/_topmenu');

?>
<style>
.qrcode-text-btn {
    display: none;
}

.qrcode-text {
  box-sizing: border-box;
  vertical-align: middle;
}

@media only screen and (max-device-width:750px) {
 previous CSS code goes here 
    body,
    input {
      font-size: 14pt;
    }
    input,
    label {
      vertical-align: middle;
    }
    .qrcode-text {
      padding-right: 1.7em;
      margin-right: 0;
      vertical-align: middle;
    }
    .qrcode-text-btn {
      display: inline-block;
      background: url(//dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg)
        50% 50% no-repeat;
      height: 1em;
      width: 1.7em;
      margin-left: -1.7em;
      cursor: pointer;
    }
    .qrcode-text-btn > input[type="file"] {
      position: absolute;
      overflow: hidden;
      width: 1px;
      height: 1px;
      opacity: 0;
    }

    .qrcode-text + .qrcode-text-btn {
      width: 1.7em;
      margin-left: -1.7em;
      vertical-align: middle;
    }
}

</style>
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js">
</script>
<script>  
function openQRCamera(node) {
  var reader = new FileReader();
  reader.onload = function() {
    node.value = "";
    qrcode.callback = function(res) {
      if (res instanceof Error) {
        alert(
          "No QR code found. Please make sure the QR code is within the camera's frame and try again."
        );
      } else {
        alert(
          "Scanning OR code is successful"
        );
        node.parentNode.previousElementSibling.value = res;
        window.location.replace(res);
      }
    };
    qrcode.decode(reader.result);
  };
  reader.readAsDataURL(node.files[0]);
}

function showQRIntro() {
  return confirm("Use your camera to take a picture of a QR code.");
}

</script>
<!--<script type="text/javascript" src="llqrcode.js"></script>
<script type="text/javascript" src="webqr.js"></script>-->
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">  
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-camera" aria-hidden="true"></i> Pengesahan Kehadiran</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group">
                        <input type=url size=10 placeholder="IMBAS" class=qrcode-text>
                        <label class=qrcode-text-btn>
                            <input type=file
                                   accept="image/*" 
                                   capture=environment
                                   onclick="return showQRIntro();"
                                   onchange="openQRCamera(this);" 
                                   tabindex=-1>
                        </label>
                        <input type=button value="TEKAN SINI" disabled>
                </div>
            </div> <!-- x_content -->
        </div>
    </div>
</div>

