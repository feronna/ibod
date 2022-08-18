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
                    <td class="text-center"> Glosari SETARA</td>
                    <td class="text-center"><a href="<?php echo Url::to('@web/'.'uploads/hrdata/Glossary SETARA.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i></td>
                </tr>
            
        </tbody>
    </table>
</div>