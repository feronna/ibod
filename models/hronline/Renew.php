<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.renew".
 *
 * @property int $renew_id
 * @property string $renew_desc
 */
class Renew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.renew';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['renew_id', 'renew_desc'], 'required'],
            [['renew_id'], 'integer'],
            [['renew_desc'], 'string', 'max' => 10],
            [['renew_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'renew_id' => 'Renew ID',
            'renew_desc' => 'Renew Desc',
        ];
    }
    
    public function getRenewstatus() {
        if($this->renew_desc == 'new'){
            return 'Baru';
        }
        elseif($this->renew_desc == 'renew'){
            return 'Diperbaharui';
        }
        else{
            return $this->Renewstatus;
        }
    }
}
