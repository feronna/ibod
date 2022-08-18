<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Expression;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ActiveDataProvider;

use app\models\Notification;
use app\models\dass\RefPenilaianDass21;
use app\models\dass\TblPenilaianDass21;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Dass21Controller extends Controller
{
    public function actionGenerateReport($query, $icno)
    {
        $rubric = new RefPenilaianDass21();

        $exporter = new Spreadsheet([
            'dataProvider' => new ActiveDataProvider([
                'query' => TblPenilaianDass21::findBySql($query),
                'pagination' => [
                    'pageSize' => 200, // export batch size
                ],
            ]),
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'BIL',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    //'attribute' => 'CONm',
                    'label' => 'NAMA',
                    'headerOptions' => ['class' => 'column-title'],
                    'value' => function ($model) {
                        return '<strong>' . $model->biodata->CONm . '</strong>' . '<br><small>' . $model->department->fullname . '</small>' .
                            '<br><small>' . $model->jawatan->nama . ' ' . $model->jawatan->gred;
                    },
                    'format' => 'html',
                ],
                [
                    //'attribute' => 'CONm',
                    'label' => 'JSPIU',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function ($model) {
                        return $model->department->shortname;
                    },
                ],
                [
                    //'attribute' => 'CONm',
                    'label' => 'TARIKH / MASA',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'attribute' => 'created_dt'
                ],
                [
                    //'attribute' => 'CONm',
                    'label' => 'TAHUN',
                    'headerOptions' => ['class' => 'text-center'],
                    'contentOptions' => ['class' => 'text-center'],
                    'attribute' => 'tahun'
                ],
                [
                    //'attribute' => 'CONm',
                    'label' => 'SKOR',
                    'headerOptions' => ['class' => 'text-center'],
                    //'contentOptions' => ['class'=>'text-center'],
                    'value' => function ($model) use ($rubric) {
                        foreach (array_reverse($rubric->depression_scale) as $key) {
                            if ($model->skor_d >= $key['score']) {
                                $d_msg = $key['status'];
                                break;
                            }
                        }

                        foreach (array_reverse($rubric->anxiety_scale) as $key) {
                            if ($model->skor_a >= $key['score']) {
                                $a_msg = $key['status'];
                                break;
                            }
                        }

                        foreach (array_reverse($rubric->stress_scale) as $key) {
                            if ($model->skor_s >= $key['score']) {
                                $s_msg = $key['status'];
                                break;
                            }
                        }

                        return '<ul><li>Depression : ' . $model->skor_d . '/21 <b>' . $d_msg . '</b></li>' .
                            '<li>Anxiety : ' . $model->skor_a . '/21 <b>' . $a_msg . '</li>' .
                            '<li>Stress : ' . $model->skor_s . '/21 <b>' . $s_msg . '</b></li></ul>';
                    },
                    'format' => 'html',
                ],
            ],

        ]);

        $exporter->save('web/files/reports/dass_report_' . date("Y_m_d") . '_' . $icno . '.xlsx');

        $doc = new \app\models\system_core\TblDocuments();
        $uapi = new \app\components\UAPI;
        $file = $uapi->UploadFile('dass_report_' . date("Y_m_d") . '_' . $icno . '.xlsx', 'web/files/reports/dass_report_' . date("Y_m_d") . '_' . $icno . '.xlsx', '04', 'hrv4_reports/', $icno);

        if ($file->status == true) {
            $doc->filehash = $file->file_name_hashcode;
            $doc->file_name = 'dass_report_' . date("Y_m_d") . '_' . $icno . '.xlsx';
            $doc->module = 'dass21';
            $doc->created_by = $icno;
            $doc->created_dt = new \yii\db\Expression('NOW()');
            $doc->save(false);

            unlink('web/files/reports/dass_report_' . date("Y_m_d") . '_' . $icno . '.xlsx');
        }

        return ExitCode::OK;
    }
}
