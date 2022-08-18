<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_tbl_peratus_rubrik".
 *
 * @property int $id
 * @property int $aspek_rubrik_id
 * @property int $kump_rubrik_id
 * @property double $peratus
 */
class TblPeratusRubrik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_peratus_rubrik';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
//    public static function getDb()
//    {
//        return Yii::$app->get('db2');
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aspek_rubrik_id', 'kump_rubrik_id'], 'integer'],
            [['peratus'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aspek_rubrik_id' => 'Aspek Rubrik ID',
            'kump_rubrik_id' => 'Kump Rubrik ID',
            'peratus' => 'Peratus',
        ];
    }
}
