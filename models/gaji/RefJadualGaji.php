<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.r_jadual_gaji".
 *
 * @property string $r_jg_gred
 * @property int $r_jg_peringkat
 * @property string $r_jg_min
 * @property string $r_jg_maks
 * @property string $r_jg_kgt
 * @property string $r_jg_peratus
 */
class RefJadualGaji extends \yii\db\ActiveRecord
{
    // add the function below:
    //    public static function getDb() {
    //        return Yii::$app->get('db2'); // second database
    //    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_r_jadual_gaji';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['r_jg_peringkat'], 'integer'],
            [['r_jg_min', 'r_jg_maks', 'r_jg_kgt', 'r_jg_peratus'], 'number'],
            [['r_jg_gred'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'r_jg_gred' => 'R Jg Gred',
            'r_jg_peringkat' => 'R Jg Peringkat',
            'r_jg_min' => 'R Jg Min',
            'r_jg_maks' => 'R Jg Maks',
            'r_jg_kgt' => 'R Jg Kgt',
            'r_jg_peratus' => 'R Jg Peratus',
        ];
    }
}
