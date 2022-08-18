<?php

namespace app\models\lnpt;

use Yii;

/**
 * This is the model class for table "lppums.markah_keseluruhan".
 *
 * @property string $markah_id
 * @property int $lpp_id
 * @property double $markah_PPP
 * @property double $markah_PPK
 * @property double $markah_PP
 * @property string $atatan
 * @property double $markah_CPD
 */
class Markahkeseluruhan extends \yii\db\ActiveRecord
{
    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'lppums.markah_keseluruhan';
        return 'hrm.lppums_markah_keseluruhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['markah_PPP', 'markah_PPK', 'markah_PP', 'markah_CPD'], 'number'],
            [['catatan'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'markah_id' => 'Markah ID',
            'lpp_id' => 'Lpp ID',
            'markah_PPP' => 'Markah  Ppp',
            'markah_PPK' => 'Markah  Ppk',
            'markah_PP' => 'Markah  Pp',
            'catatan' => 'Catatan',
            'markah_CPD' => 'Markah  Cpd',
        ];
    }
}
