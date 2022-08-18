<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_addcri_orgculsports".
 *
 * @property int $id
 * @property string $uid
 * @property string $orgculsports_date
 * @property string $orgculsports_activities
 * @property string $ICNO
 */
class TblSports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_addcri_orgculsports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['orgculsports_activities','orgculsports_date'], 'required'],
            [['orgculsports_activities'], 'string', 'max' => 255],
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
            'orgculsports_date' => 'Orgculsports Date',
            'orgculsports_activities' => 'Orgculsports Activities',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
