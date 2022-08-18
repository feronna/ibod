<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "cv.cv_tbl_skills".
 *
 * @property int $id
 * @property string $uid
 * @property string $skills
 * @property string $ICNO
 */
class TblSkills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skills'], 'required'],
            [['uid'], 'string', 'max' => 20],
            [['skills'], 'string', 'max' => 255],
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
            'skills' => 'Kemahiran',
            'ICNO' => 'Icno',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
