<?php

use yii\helpers\Html;
?>
<div class="col-md-3 col-sm-3 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-calendar"></i>&nbsp;Info</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div>
                <table class="table">

                    <tbody>
                        
                        <tr>
                            <td colspan='3'><u><b> My Staffs (<?php echo date('d/m/Y') ?>)</b></u></td>
                        </tr>
                        <tr>
                            <td colspan='2'><b> Total Staff : </b><?php echo $onleave->team ?></td>
                         
                        </tr>
                        <tr>
                            <td colspan='2'><b> On Leave : </b><?php echo $onleave->totalStaff ?></td>
                         
                        </tr>
                        <tr>
                            <td colspan='2'><b> WFH : </b><?php echo $onleave->wfh ?></td>
                         
                        </tr>
                        <tr>
                            <td colspan='2'><b> Clock In : </b><?php echo $onleave->todays ?></td>
                         
                        </tr>
                        <tr>
                        <tr>
                            
                            <td colspan="2"><?= $onleave->deptId == 2 ? Html::a('<i class="fa fa-clock-o"</i>  More Details', ['cuti/pegawai/staffonleaveskb'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']) : Html::a('<i class="fa fa-clock-o"</i>  More Details', ['cuti/pegawai/staffonleave'], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank']); ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>