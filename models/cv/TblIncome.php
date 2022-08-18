<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_addcri_genincome".
 *
 * @property int $id
 * @property string $uid
 * @property string $genincome_date
 * @property string $genincome_activities
 * @property string $ICNO
 */
class TblIncome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_addcri_genincome';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['genincome_activities','genincome_date'], 'required'],
            [['genincome_activities'], 'string', 'max' => 255],
            [['uid'], 'string', 'max' => 20],
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
            'genincome_date' => 'Tarikh',
            'genincome_activities' => 'Aktiviti',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
