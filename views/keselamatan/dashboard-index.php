<?php 
use yii\helpers\Html;
?>
<style>
    @media screen and (min-width: 701px) {
        .count {
          font-size: 18px;
        }
        .klinik {
          font-size: 14px;
        }
        .count_top {
          font-size: 12px;
        }
      }

      @media screen and (max-width: 700px) {
        .count {
          font-size: 14px;
        }
        .klinik {
          font-size: 12px;
        }
        .count_top {
          font-size: 10px;
        }
      }
    .count{
        font-weight: 600;
        color: white;
    }
    .count_top{
        color: black;
    }
    #inside {
        line-height: 2;
        height: 70px;
        padding: 5px 10px 0 10px;
        margin: 0 0 10px 0;
    }
</style>
<div class="row">
    <div class="btn btn-primary col-md-2 col-sm-4 col-xs-4" id="inside">
        <span class="count_top"><i class="fa fa-calendar"></i> Syif A</span>
        <div class="count">12 / <?= $syifA ?></div>
    </div>
  </div>