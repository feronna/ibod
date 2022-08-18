<style>
    .titlesu{
        font-size: 16px;
    }
    .countries_list tr:hover{
        background-color: #cccccc;
        cursor: pointer;
    }
    .countries_list td a { 
    display: block; 
}
</style>
<div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i>&nbsp;Personal Info</h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="countries_list">
                <tbody>
                    <tr>
                    <td style="border-top:none" class="titlesu">
                        <a href="<?=Yii::$app->urlManager->createUrl("biodata/lihatbiodata")?>"><i class="fa fa-user"></i> Biodata</a></td>
                    <td style="border-top:none" class="fs15 fw700 text-right" style="font-size: 12px">
                        <a href="<?=Yii::$app->urlManager->createUrl("biodata/lihatbiodata")?>">Last Updated
                        :<br>
                        <i style="color:black">[&nbsp;<?= Yii::$app->MP->BioLastUpdate()?>&nbsp;]</i></a></td>
                    </tr>
                    
                    <tr>
                    <td class="titlesu">
                        <a href="<?=Yii::$app->urlManager->createUrl("keluarga/view")?>"><i class="fa fa-users"></i> Family</a></td>
                    <td class="fs15 fw700 text-right" style="font-size: 12px">
                        <a href="<?=Yii::$app->urlManager->createUrl("keluarga/view")?>">Total 
                        :<br>
                        <i style="color:black">[&nbsp;<?= Yii::$app->MP->TotalFmy()?>&nbsp;]</i></a></td>
                    </tr>
                    
                    <tr>
                    <td class="titlesu">
                        <a href="<?=Yii::$app->urlManager->createUrl("pendidikan/view")?>"><i class="fa fa-graduation-cap"></i> Education</a></td>
                    <td class="fs15 fw700 text-right" style="font-size: 12px">
                        <a href="<?=Yii::$app->urlManager->createUrl("pendidikan/view")?>">Highest Education 
                        :<br>
                        <i style="color:black">[&nbsp;<?= Yii::$app->MP->HighestEdu()?>&nbsp;]</i></a></td>
                    </tr>
                    
                    <tr>
                    <td class="titlesu">
                        <a href="<?=Yii::$app->urlManager->createUrl("pasport-permit/view")?>"><i class="fa fa-address-card"></i> Passport</a></td>
                    <td class="fs15 fw700 text-right" style="font-size: 12px">
                        <a href="<?=Yii::$app->urlManager->createUrl("pasport-permit/view")?>">Expiry Date
                        :<br>
                        <i style="color:black">[&nbsp;<?= Yii::$app->MP->LatestPassport() ? Yii::$app->MP->Tarikh(Yii::$app->MP->LatestPassport()->PassportExpiryDt):'-'?>&nbsp;]</i></a></td>
                    </tr>
                <tr>
                    <td class="titlesu"><a href="<?=Yii::$app->urlManager->createUrl("lesen/view")?>"><i class="fa fa-address-card-o"></i> License</a></td>
                <td class="fs15 fw700 text-right" style="font-size: 12px">
                    <a href="<?=Yii::$app->urlManager->createUrl("lesen/view")?>">Expiry Date
                    :<br>
                    <i style="color:black"><?= Yii::$app->MP->LatestLicense()? 
                    "<i class='fa fa-car'></i>&nbsp;[&nbsp;".Yii::$app->MP->Tarikh(Yii::$app->MP->LatestLicense()->LicExpiryDt)."&nbsp;]":'[ - ]'?></i></a></td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
</div>
