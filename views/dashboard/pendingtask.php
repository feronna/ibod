<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel scrollmenu">
        <div class="x_title">
            <h2><i class="fa fa-check-square-o"></i> Approval Center</h2>
            <div class="clearfix"></div>
        </div>
            <table class="table" style="text-align: center">
                <tr>
                    <?php $i=1; foreach($pendingtask as $p){?>
                    <td width="500px">
                        <div class="col-md-12 col-sm-12 col-xs-12 app1" style="padding-left:0px">
                            <div class="col-md-4 col-sm-4 col-xs-4" style="height: 100%; background-color: #17a2b8!important; color:white;"><br>
                            <i style="font-size:26px;" class="fa fa-info-circle"></i><span class="badge bg-red"><?= $p->count?></span>
                            </div>
                            <div class="appname"><br><?= $p->name?></div>
                        </div>
                    </td><?php }?>
                </tr>
            </table>
    </div></div>
</div>