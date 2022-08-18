<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_addcri_paperwork".
 *
 * @property int $id
 * @property string $uid
 * @property string $paperwork_date
 * @property string $paperwork_activities
 * @property string $ICNO
 */
class TblPaperwork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_addcri_paperwork';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['paperwork_activities','paperwork_date'], 'required'],
            [['paperwork_activities'], 'string', 'max' => 255],
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
            'paperwork_date' => 'Tarikh',
            'paperwork_activities' => 'Aktiviti',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
