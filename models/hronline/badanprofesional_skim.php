<?php

namespace app\models\hronline;

use Yii;

class badanprofesional_skim extends \yii\db\ActiveRecord
{
    public $_profbodyid;

    public static function tableName()
    {
        return 'hronline.badanprofesional_skim';
    }

    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    public function rules()
    {
        return [
            [['skim_id'], 'integer'],
            [['ProfBodyCd', '_profbodyid'], 'string', 'max' => 4],
            [['ProfBodyCd', 'skim_id'], 'unique', 'targetAttribute'=>['ProfBodyCd', 'skim_id'],'message'=>'Padanan sudah wujud.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ProfBodyCd' => 'Prof Body Cd',
            'skim_id' => 'Skim ID',
            '_profbodyid' => 'Prof Body',
        ];
    }

    public function getSkim() {
        return $this->hasOne(KlasifikasiPerkhidmatan::className(), ['id' => 'skim_id']);
    }
}
