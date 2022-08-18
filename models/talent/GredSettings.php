<?php

namespace app\models\talent;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Adminposition;
use Yii;

/**
 * This is the model class for table "{{%hrm.talent_gred_settings}}".
 *
 * @property int $id
 * @property int $sort_no
 * @property int $adminpos_id
 * @property string $gred
 */
class GredSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrm.talent_gred_settings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adminpos_id','sort_no'], 'integer'],
            [['gred'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adminpos_id' => 'Adminpos ID',
            'gred' => 'Gred',
            'sort_no' => 'Sort No',
        ];
    }

    public static function getStaf($gred, $holder_icno = null, $dept_id = null, $program_id = null, $post_id = null)
    {

        if ($post_id == 13) { //if pustakawan
            $model = Tblprcobiodata::find()->joinWith('jawatan')
                ->where(['gred' => $gred, 'statLantikan' => 1])
                ->andWhere(['<>', 'Status', 6])
                ->andWhere(['NOT LIKE', 'nama', '%tanpa%', false])
                ->andFilterWhere(['!=', 'ICNO', $holder_icno])
                ->andFilterWhere(['deptId' => $dept_id, 'KodProgram' => $program_id])
                ->andFilterWhere(['LIKE', 'nama', '%pustakawan%', false])
                ->orderBy(['endDateLantik' => SORT_ASC])
                ->all();
        } else {
            $model = Tblprcobiodata::find()->joinWith('jawatanHakiki')
                ->where(['gred' => $gred, 'statLantikan' => 1])
                ->andWhere(['<>', 'Status', 6])
                ->andWhere(['NOT LIKE', 'nama', '%tanpa%', false])
                ->andFilterWhere(['!=', 'ICNO', $holder_icno])
                ->andFilterWhere(['deptId' => $dept_id, 'KodProgram' => $program_id])
                ->orderBy(['endDateLantik' => SORT_ASC])
                ->all();
        }


        if ($model) {
            return $model;
        }

        return false;
    }

    public static function getStafByKlasifikasi($gred_id)
    {

        $model = Tblprcobiodata::find()->joinWith('jawatan')
            ->where(['statLantikan' => 1, 'gredjawatan.id' => $gred_id])
            ->andWhere(['<>', 'Status', 6])
            ->orderBy(['startDateLantik' => SORT_ASC])
            ->all();


        if ($model) {
            return $model;
        }

        return false;
    }

    public static function getAdminPostByKriteria($kriteria)
    {

        $model = [];

        if ($kriteria == 1) {
            $model = Adminposition::find()->where(['pegawai_utama' => 1])->all();
        }

        if ($kriteria == 2) {
            $model = Adminposition::find()->where(['id' => [3, 4, 5, 6]])->all();
        }

        if ($kriteria == 3) {
            $model = Adminposition::find()->where(['id' => [18]])->all();
        }


        return $model;
    }

    public static function getTotalGred($adminpos_id)
    {

        $model = self::find()->where(['adminpos_id' =>$adminpos_id])->all();

        if($model){
            return count($model);
        }

        return 0;
    }
}
