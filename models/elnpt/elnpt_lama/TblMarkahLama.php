<?php

namespace app\models\elnpt\elnpt_lama;

use Yii;

use app\models\elnpt\elnpt_lama\TblSupervisor;

/**
 * This is the model class for table "hrm.elnpt_markah".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $tahun
 * @property double $markah
 * @property double $markahPPP
 * @property double $markahPPK
 * @property double $purata
 */
class TblMarkahLama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_markah';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'tahun'], 'required'],
            [['staff_id', 'tahun'], 'integer'],
            [['markah', 'markahPPP', 'markahPPK', 'purata'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'tahun' => 'Tahun',
            'markah' => 'Markah',
            'markahPPP' => 'Markah Ppp',
            'markahPPK' => 'Markah Ppk',
            'purata' => 'Purata',
        ];
    }
    
    public function getSupervisor() {
        return $this->hasOne(TblSupervisor::className(), ['staff_id' => 'staff_id', 'tahun' => 'tahun']);
    }
}
