<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_addcri_invresearch".
 *
 * @property int $id
 * @property string $uid
 * @property string $invresearch_date
 * @property string $invresearch_activities
 * @property string $ICNO
 */
class TblResearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_addcri_invresearch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['invresearch_activities','invresearch_date'], 'required'],
            [['invresearch_activities'], 'string', 'max' => 255],
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
            'invresearch_date' => 'Tarikh',
            'invresearch_activities' => 'Aktiviti',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
