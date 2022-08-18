<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_ref_skor_aspek".
 *
 * @property int $id
 * @property int $aspek_id
 * @property string $sub_aspek
 * @property double $pemberat
 */
class RefSkorAspek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_ref_skor_aspek';
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
            [['aspek_id'], 'integer'],
            [['pemberat'], 'number'],
            [['sub_aspek'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aspek_id' => 'Aspek ID',
            'sub_aspek' => 'Sub Aspek',
            'pemberat' => 'Pemberat',
        ];
    }
}
