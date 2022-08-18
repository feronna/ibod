<?php
use yii\helpers\Html;
use kartik\grid\GridView;

/** testing **/

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);

// the grid columns setup (only two column entries are shown here
// you can add more column entries you need for your use case)
$gridColumns = [
            [
                'label' => 'Siri #',
                'value'=> 'siri',
            ],
            [
                'label' => 'Tarikh',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model){               
                                if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
                                    
                                    $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
                                    $formatteddate = $myDateTime->format('d/m/Y');
                                    
                                    $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
                                    $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    
                                    if ($formatteddate == $formatteddate2 ){
                                        $formatteddate = $formatteddate;    
                                    } else {
                                        $formatteddate = $formatteddate.' - '.$formatteddate2;
                                    }
                                    
                                } else {
                                    $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
                                } 
                                return $formatteddate;
                            },
            ],
            [
                'label' => 'Lokasi ',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value'=> 'lokasi',
            ],
            [
                'label' => 'Kampus',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => 'campusName.campus_name',
            ],
            [
                'label' => 'Jumlah Jam',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => 'jumlahJamLatihan',
                'width' => '50px',
            ],
            [
                'label' => 'Mata IDP',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => 'jumlahMataIDP',
            ],
            [
                'label' => 'Status',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($model) {
                                if ($model->statusSiriLatihan != 'SEDANG BERJALAN'){
                                    $a = '<span class="glyphicon glyphicon-lock"></span>'.$model->statusSiriLatihan;
                                    
                                } else {
                                    $a = '<span class="glyphicon glyphicon-play-circle"></span>&nbsp;LIVE';
                                }
                                return $a;
                          
                        },
             ],
             [
                'label' => 'Bahan',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'format' => 'raw',
                'value' => function ($data){
                            $datalist = [];
                            if ($data->sasaran7){
                                foreach ($data->sasaran7 as $files) {
                                    $a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                                    array_push($datalist, $a); 
                                }
                            } else {
                                return "TIADA BAHAN";
                            }
                            $all = " ";
                            $b = count($datalist);
                            for($i = 0; $i < count($datalist); $i++){
                                $all = $b.') '.$datalist[$i].$all;
                                $b--;
                            }
                            return $all;
                },
            ],
            [
                'label' => 'Penceramah',
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'width' => '500px',
                'format' => 'raw',
                'value' => function ($data){
                            $datalist = [];
                            if ($data->ceramah){ // if ada penceramah
                                
                                foreach ($data->ceramah as $c) { //foreach penceramah
                                    
                                    if ($c->penceramah){
                                        $a = Html::a(ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)), [""], ['class' => 'btn btn-success disabled'] );
                                    } else {
                                        $a = Html::a(ucwords(strtolower($c->penceramahluar->penceramah_name)), [""], ['class' => 'btn btn-success disabled'] );
                                    }

                                    //$a = Html::a(ucwords(strtolower($c->penceramah->displayGelaran . ' ' . $c->penceramah->CONm)), [""], ['class' => 'btn btn-success disabled'] );
                                    //$a =  Html::a(Yii::$app->FileManager->NameFile($files->filename), Yii::$app->FileManager->DisplayFile($files->filename)).'<br>';
                                    array_push($datalist, $a); 
                                }
                            }
                            else {
                                return '<em><b>AKAN DIMAKLUMKAN</b></em>';
                            }
                            $all = " ";
                            $b = count($datalist);
                            for($i = 0; $i < count($datalist); $i++){
                                $all = $b.') '.$datalist[$i].'<br>'.$all;
                                $b--;
                            }
                            return $all;
                            //return count($datalist);
                },
                 
            ],
            [
                'label' => 'Kuota',
                'value' => 'kuota'
            ],
            ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Penetapan',
                            //'headerOptions' => ['style' => 'color:#337ab7'],
                            'template' => '{update} | {delete} | {linkSasaran} | {linkJemputan} | {semakPermohonan} | {jemputPeserta} ',
                            //'template' => '{update} | {delete}',
                            'buttons' => [
                               'jemputPeserta' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-briefcase"></span>', $url, [
                                              'title' => Yii::t('app', 'Jemput Peserta'),
                                  ]);
                              },   
                              'semakPermohonan' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-share"></span>', $url, [
                                              'title' => Yii::t('app', 'Semak Permohonan'),
                                  ]);
                              },
                              'linkSasaran' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                                              'title' => Yii::t('app', 'Tetapan Sasaran'),
                                  ]);
                              },
                              'linkJemputan' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-envelope"></span>', $url, [
                                              'title' => Yii::t('app', 'Tetapan Jemputan'),
                                  ]);
                              },
                              'update' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url, [
                                              'title' => Yii::t('app', 'Kemaskini'),
                                              //'class' => 'mapBtn btn btn-primary',
                                  ]);
                              },
                              'delete' => function ($url, $model) {
                                  return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                          ['data' => [
                                              'confirm' => 'Adakah anda pasti anda ingin menghapuskan rekod ini?',
                                              'method' => 'post',
                                              ],
                                          ],
                                          ['title' => Yii::t('app', 'Hapus'),]);     
                              },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                              if ($action === 'linkSasaran') {
                                  $url ='view-senarai-jawatan?id='.$model->siriLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              
                              if ($action === 'linkJemputan') {
                                  $url ='view-jemputan?id='.$model->siriLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              
                              if ($action === 'update') {
                                  $url ='update-siri?id='.$model->siriLatihanID; //hantar ke Controller
                                  return $url;
                              }
                              if ($action === 'delete') {
                                  $url ='delete-siri?id='.$model->siriLatihanID; 
                                  return $url;
                              }
                              
                              if ($action === 'semakPermohonan') {
                                  $url ='semak-permohonan-siri?id='.$model->siriLatihanID.'&pagee=viewPemohon'; 
                                  return $url;
                              }
                              
                              if ($action === 'jemputPeserta') {
                                  $url ='jemput-peserta?id='.$model->siriLatihanID; 
                                  return $url;
                              }
                            }
                      ],
];
?>




<head>  
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v3.3.1/css/all.css">
<style>
#myBtn {
  display: none; /* Hidden by default */
  position: fixed; /* Fixed/sticky position */
  bottom: 20px; /* Place the button at the bottom of the page */
  right: 30px; /* Place the button 30px from the right */
  z-index: 99; /* Make sure it does not overlap */
  border: none; /* Remove borders */
  outline: none; /* Remove outline */
  background-color: grey; /* Set a background color */
  color: white; /* Text color */
  cursor: pointer; /* Add a mouse pointer on hover */
  padding: 15px; /* Some padding */
  border-radius: 10px; /* Rounded corners */
  font-size: 18px; /* Increase font size */
}

#myBtn:hover {
  background-color: #555; /* Add a dark-grey background on hover */
}
</style>
</head>
<button onclick="topFunction()" id="myBtn" title="Go to top">&uarr;</button>
<script>
//Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

function checkDate(){
    var startDate = new Date(document.getElementById("StartDate").value);
    var endDate = new Date(document.getElementById("EndDate").value);
    
    if ((Date.parse(endDate) < Date.parse(startDate))) {
        alert("RALAT! Tarikh akhir kursus haruslah selepas tarikh mula. Sila isi kembali.");
        document.getElementById("EndDate").value = "";
  }
}  
</script>
<div class="row"> 
    <div class="x_panel">
        <div class="x_content">
<?php
//    GridView::widget([
//        'dataProvider' => $dataProvider,
//        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
//        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
//        'columns' => $gridColumns,
//    ]); 
?>
        </div>
    </div>
</div>
