<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.flag".
 *
 * @property int $flag_id
 * @property string $flag_desc
 */
class Flag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.flag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_id', 'flag_desc'], 'required'],
            [['flag_id'], 'integer'],
            [['flag_desc'], 'string', 'max' => 10],
            [['flag_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'flag_id' => 'Flag ID',
            'flag_desc' => 'Flag Desc',
        ];
    }
    
    public function getFlagstatuss() {
        if($this->flag_desc == 'Waiting'){
            return 'Belum Disahkan';
        }
        elseif($this->flag_desc == 'Active'){
            return 'Aktif';
        }
        elseif($this->flag_desc == 'Not Active'){
            return 'Tidak Aktif';
        }
        else{
            return $this->Flagstatus;
        }
    }
    
    public function getFlagstatus() {
        if($this->flag_desc == 'Waiting'){
            return '<span class="label label-warning">Belum Disahkan</span>';
        }
        elseif($this->flag_desc == 'Active'){
            return '<span class="label label-success">Aktif</span>';
        }
        elseif($this->flag_desc == 'Not Active'){
            return '<span class="label label-danger">Tidak Aktif</span>';
        }
        else{
            return $this->Flagstatus;
        }
    }

}
