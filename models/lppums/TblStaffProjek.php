<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hronline.staf_projek".
 *
 * @property string $icno
 */
class TblStaffProjek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.staf_projek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'required'],
            [['icno'], 'string', 'max' => 12],
            [['icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
        ];
    }
}
