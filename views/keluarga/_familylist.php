<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
error_reporting(0);

$this->title = 'Senarai Keluarga';

?>
<div class="col-lg-1 col-sm-3 col-xs-12 text-center">
     <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $bio->ICNO)); ?>.jpeg"></span></div>
</div>
</br>
<?php
                    echo DetailView::widget([
                        'model' => $bio,
                        'attributes' => [
                            [ 
                                'label' => 'Nama',
                                'value' => (is_null($bio->gelaran) ? '' : $bio->gelaran->Title.' ').$bio->CONm
                            ],
                            [ 
                                'label' => 'KP / Pasport',
                                'value' => $bio->ICNO
                            ], 
                            [   
                                'label' => 'Jawatan',
                                'value' => $bio->jawatan->fname
                            ],
                            [ 
                                'label' => 'JSPIU',
                                'value' => $bio->department->fullname
                            ],
                            [       
                                'label' => 'Jenis Lantikan',
                                'value' => $bio->statusLantikan->ApmtStatusNm
                            ],
                            [
                                'label' => 'UMSPER',
                                'value' => $bio->COOldID
                            ],
                        ],
                    ]);
                    
                    ?></br>




    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">


            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>No. Kad Pengenalan</th>
                    <th>Nama</th>
                    <th>Hubungan</th>  
                </tr>
                </thead>
                <?php if($keluarga) {
                    
                   foreach ($keluarga as $keluargakakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $keluargakakitangan->FamilyId; ?></td>
                    <td><?= $keluargakakitangan->FmyNm; ?></td>
                    <td><?= $keluargakakitangan->hubkeluarga; ?></td> 
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>




