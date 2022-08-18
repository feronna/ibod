<div>
    <?=
    \kartik\detail\DetailView::widget([
        'model' => $lpp,
        'attributes' => [
            [
                'group' => true,
                'label' => 'MAKLUMAT STAFF',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'label' => '',
                'value' => $lpp->profilePic,
                'format' => 'raw'

            ],
            [
                'label' => 'STAFF',
                'value' => $lpp->guru->CONm,

            ],
            [
                'label' => 'UMSPER',
                'value' => $lpp->guru->COOldID,
            ],
            [
                'label' => 'GRED / JAWATAN',
                'value' => $lpp->gredGuru->fname

            ],
            [
                'label' => 'F/A/P/I',
                'value' => $lpp->deptGuru->fullname,
            ],
            [
                'label' => 'GUGUSAN',
                'value' => ($lpp->deptGuru->cluster == 1) ? 'Sains' : 'Sastera',

            ],
            [
                'group' => true,
                'label' => 'MAKLUMAT BORANG',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'label' => 'TAHUN PENILAIAN',
                'value' => $lpp->tahun,
                'captionOptions' => ['style' => 'width:15%'],
            ],
            [
                'label' => 'TEMPOH PENGISIAN',
                'value' => Yii::$app->formatter->asDate($lpp->tahunLpp->lpp_trkh_hantar, 'dd/MM/yyyy') . ' hingga ' . Yii::$app->formatter->asDate($lpp->tahunLpp->pengisian_PYD_tamat, 'dd/MM/yyyy'),
                'format' => 'html',
                //'captionOptions' => ['style' => 'width:20%'],
            ],
            [
                'label' => 'PPP',
                'value' => is_null($lpp->ppp) ? '<b>Pegawai Penilai Pertama Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $lpp->ppp->CONm,
                'format' => 'html',
            ],
            [
                'label' => 'PPK',
                'value' => is_null($lpp->ppk) ? '<b>Pegawai Penilai Kedua Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : $lpp->ppk->CONm,
                'format' => 'html',
            ],
            [
                'label' => 'PEER',
                'value' => is_null($lpp->peer) ? '<b>Peer Belum Ditetapkan. Sila Berhubung dengan Penetap Penilai di J/S/P/I/U anda.</b>' : ((app\models\elnpt\testing\TblTestingAccess::find()->where(['icno' => Yii::$app->user->identity->ICNO, 'access' => 1])->exists()) ? (($lpp->peer) ? $lpp->peer->CONm : null) : '<b>Peer Sudah Ditetapkan.</b>'),
                'format' => 'html',
            ],
            [
                'label' => 'CATATAN',
                'value' => $lpp->catatan,
            ],
            [
                'group' => true,
                'label' => 'LAIN-LAIN <sub>Ditentukan oleh F/A/P/I</sub>',
                'rowOptions' => ['class' => 'table-info']
            ],
            [
                'label' => '',
                'value' =>  $summary['label'],
                'format' => 'html',
            ],
            [
                'label' => 'PENGAJARAN & PENYELIAAN (K1)',
                'value' =>  Yii::$app->formatter->asPercent($summary['k1_k2'] / 100),
                'format' => 'html',
            ],
            [
                'label' => 'PENYELIDIKAN & PENERBITAN (K2)',
                'value' =>  Yii::$app->formatter->asPercent($summary['k3_k4'] / 100),
                'format' => 'html',
            ],
            [
                'label' => 'PERKHIDMATAN (K3)',
                'value' =>  Yii::$app->formatter->asPercent($summary['k5'] / 100),
                'format' => 'html',
            ],
            [
                'label' => 'KLINIKAL (K4)',
                'value' =>  Yii::$app->formatter->asPercent($summary['k6'] / 100),
                'format' => 'html',
            ],
            [
                'label' => 'PERATUS MAKSIMUM MARKAH BOLEH MELIMPAH DARI HAKIKI',
                'value' =>  Yii::$app->formatter->asPercent($summary['limpahan'] / 100),
                'format' => 'html',
            ],
            [
                'label' => 'SAIZ KELAS UNTUK MENDAPAT 1 MATA',
                'value' =>  $summary['saiz_kelas'],
                'format' => 'html',
            ],
        ],
    ])
    ?>
</div>