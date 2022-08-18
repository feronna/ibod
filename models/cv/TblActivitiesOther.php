<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_activities_other".
 *
 * @property int $id
 * @property string $uid
 * @property string $date
 * @property int $level
 * @property string $other
 * @property string $ICNO
 */
class TblActivitiesOther extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_activities_other';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['level', 'other','date'], 'required'],
            [['level'], 'integer'], 
            [['other'], 'string', 'max' => 255], 
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'date' => 'Tarikh',
            'level' => 'Peringkat',
            'other' => 'Aktiviti lain',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getPeringkat() {
        return $this->hasOne(\app\models\cv\RefActivitiesOther::className(), ['id' => 'level']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
