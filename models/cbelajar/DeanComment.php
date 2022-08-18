<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_dean_comment".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $app_by
 * @property string $icno
 * @property string $d_comment
 * @property string $create_dt
 * @property string $status
 */
class DeanComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_dean_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['d_comment'], 'string'],
            [['create_dt'], 'safe'],
            [['app_by', 'icno','reportID'], 'string', 'max' => 12],
            [['status'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'app_by' => 'App By',
            'icno' => 'Icno',
            'd_comment' => 'D Comment',
            'create_dt' => 'Create Dt',
            'status' => 'Status',
        ];
    }
    
      public function getPengajian() {
       
        return $this->hasOne(TblPengajian::className(), ['icno' => 'icno'])->where(['cb_tbl_pengajian.status'=>[1,4,2]]);
       
   }
}
