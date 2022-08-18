<?php

namespace app\commands;

use app\models\dkums\Dimensi;
use app\models\dkums\Results;
use app\models\dkums\TblMain;
use app\models\dkums\YearSettings;
use app\models\myidp\Kehadiran;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\ArrayHelper;

class DkumsController extends Controller
{



    
    public function actionGenResult($tahun, $fasa)
    {

        $list_results = ArrayHelper::getColumn(Results::find()->all(), 'main_id', $keepKeys = true);

        $total = 0;
        $models = TblMain::find()
            ->where(['tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])
            ->andFilterWhere(['NOT IN', 'id', $list_results])
            ->all();

        foreach ($models as $model) {

            $results = new Results();
            $check_result = Results::findOne(['main_id' => $model->id]);

            if ($check_result) {
                $results = $check_result;
            }

            $results->main_id = $model->id;
            $results->penilaian_hidup = $model->getPenilaianHidup();
            $results->emosi_positif = $model->getEmosiPositif();
            $results->kepuasan_kerja = $model->getKepuasanKerja();
            $results->keterlibatan_kerja = $model->getKeterlibatanKerja();
            $results->syukur = $model->getSyukur();
            $results->dkums = $model->getDkums();

            if ($results->save()) {
                echo 'id ' . $model->id . '- syukur :' . $results->syukur .  "\n";
                $total++;
            }
        }

        echo "Total : " . $total . "\n\n";

        return ExitCode::OK;
    }

    public function actionGenDimensi($tahun, $fasa)
    {

        $list_results = ArrayHelper::getColumn(Dimensi::find()->all(), 'main_id', $keepKeys = true);

        $total = 0;
        $models = TblMain::find()
            ->where(['tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])
            ->andFilterWhere(['NOT IN', 'id', $list_results])
            ->all();

        foreach ($models as $model) {

            $results = new Dimensi();
            $check_result = Dimensi::findOne(['main_id' => $model->id]);

            if ($check_result) {
                $results = $check_result;
            }

            $results->main_id = $model->id;
            $results->gaji = $model->gaji;
            $results->pangkat = $model->pangkat;
            $results->penyeliaan = $model->penyeliaan;
            $results->faedah = $model->faedah;
            $results->ganjaran = $model->ganjaran;
            $results->prosedur = $model->prosedur;
            $results->rakan = $model->rakan;
            $results->sifat = $model->sifat;
            $results->komunikasi = $model->komunikasi;
            $results->semangat = $model->semangat;
            $results->dedikasi = $model->dedikasi;
            $results->kesungguhan = $model->kesungguhan;

            if ($results->save()) {
                echo 'id ' . $model->id .  "\n";
                $total++;
            }
        }

        echo "Total : " . $total . "\n\n";

        return ExitCode::OK;
    }

    public function actionAddMata($tahun, $fasa)
    {

        $total = 0;

        $year = YearSettings::find()->where(['tahun' => $tahun, 'fasa' => $fasa])->one();

        $slotID = $year->slot_id;

        $model = TblMain::find()->where(['submit' => 1, 'tahun' => $tahun, 'fasa' => $fasa])->all();

        foreach ($model as $m) {
            $idp = Kehadiran::addKehadiran($slotID, $m->icno);
            if ($idp) {
                $total++;
            }
        }

        echo "Total : " . $total . "\n\n";

        return ExitCode::OK;
    }
}
