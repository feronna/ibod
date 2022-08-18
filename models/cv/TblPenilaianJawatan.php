<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_penilaian_jawatan".
 *
 * @property int $id
 * @property int $gred_id
 */
class TblPenilaianJawatan extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_penilaian_jawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gred_id' => 'Gred ID',
        ];
    }
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gred_id']);
    }
}
