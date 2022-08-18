<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_tbl_sumbangan".
 *
 * @property string $sumb_id
 * @property string $sumb
 * @property string $sumb_peringkat
 * @property string $lpp_id
 */
class TblSumbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_sumbangan';
    }
    
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
            [['lpp_id'], 'integer'],
            [['sumb', 'sumb_peringkat'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sumb_id' => Yii::t('app', 'Sumb ID'),
            'sumb' => Yii::t('app', 'Sumb'),
            'sumb_peringkat' => Yii::t('app', 'Sumb Peringkat'),
            'lpp_id' => Yii::t('app', 'Lpp ID'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->sumb = strtoupper($this->sumb);
        $this->sumb_peringkat = strtoupper($this->sumb_peringkat);
        
        return true;
    }
}
