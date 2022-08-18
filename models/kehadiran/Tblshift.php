<?php

namespace app\models\kehadiran;

use Yii;
use app\models\kehadiran\RefWp;

/**
 * This is the model class for table "attendance.tbl_shifts".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property int $wp_id
 */
class Tblshift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_shifts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['icno', 'tarikh'], 'required'],
            [['wp_id'], 'required', 'message' => 'Please Select Shift'],
            [['tarikh'], 'safe'],
            [['wp_id'], 'integer'],
            [['icno'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'tarikh' => 'Tarikh',
            'wp_id' => 'Wp ID',
        ];
    }
    
    /**
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getWp() {
        return $this->hasOne(RefWp::className(), ['id' => 'wp_id']);
    }
    
    
    
    public function viewShift($icno, $tarikh){
        $val = false;
        
        $model = Tblshift::findOne(['icno'=>$icno, 'tarikh'=>$tarikh]);
        
        if($model){
            $val = $model->wp->jenis_wp;
        }
        
        return $val;
    }
    
    
    
}
