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
class TaskQueueController extends Controller
{
    public function actionJanaReportDass($query, $icno)
    {
        Yii::$app->queue->push(new \app\components\Dass21Report([
            'query' => $query,
            'icno' => $icno,
        ]));
    }

    public function actionJanaApcElnpt($query, $tahun, $icno)
    {
        Yii::$app->queue->push(new \app\components\ElnptApcReport([
            'query' => $query,
            'tahun' => $tahun,
            'icno' => $icno,
        ]));
    }

    public function actionJanaApcLppums($query, $tahun, $icno)
    {
        Yii::$app->queue->push(new \app\components\LppumsApcReport([
            'query' => $query,
            'tahun' => $tahun,
            'icno' => $icno,
        ]));
    }

    public function actionJanaElnptReport($jfpiu, $tahun, $range, $purata, $icno)
    {
        Yii::$app->queue->push(new \app\components\ElnptReport([
            'jfpiu' => $jfpiu,
            'tahun' => $tahun,
            'range' => $range,
            'purata' => $purata,
            'icno' => $icno
        ]));
    }

    public function actionJanaLppumsReport($jfpiu, $tahun, $range, $purata, $icno)
    {
        Yii::$app->queue->push(new \app\components\LppumsReport([
            'jfpiu' => $jfpiu,
            'tahun' => $tahun,
            'range' => $range,
            'purata' => $purata,
            'icno' => $icno
        ]));
    }

    public function actionFixMarkahElnpt($tahun)
    {
        Yii::$app->queue->push(new \app\components\ElnptFixMarkah([
            'tahun' => $tahun,
        ]));
    }
}
