<?php
use yii\helpers\Url;
?>
<div class="table-responsive">

    <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
        <thead>
            <tr class="headings">
                <th class="text-center">GLOSARI</th>
                <th class="text-center">MUAT TURUN</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="text-center"> Glosari MyMohes (Format Staf)</td>
                    <td class="text-center"><a href="<?php echo Url::to('@web/'.'uploads/hrdata/Glosari MyMohes (Format Staf).pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i></td>
                </tr>         
        </tbody>
        <tbody>
                <tr>
                    <td class="text-center"> Glosari MyMohes (Kod rujukan staf,student,ins)</td>
                    <td class="text-center"><a href="<?php echo Url::to('@web/'.'uploads/hrdata/Glosari MyMohes (Kod rujukan staf,student,ins).pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i></td>
                </tr>         
        </tbody>
    </table>
</div>