<?php

namespace app\models\myportfolio;

use Yii;
use app\models\hronline\PendidikanTertinggi;
/**
 * This is the model class for table "myportfolio.tbl_ikhtisas".
 *
 * @property int $id
 * @property string $icno
 * @property string $ikhtisas
 * @property string $portfolio_id
 */
class TblIkhtisas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myjd_tbl_ikhtisas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
            [['ikhtisas', 'bidang'], 'string'],
            [['portfolio_id'], 'string', 'max' => 50],
            [['ikhtisas','bidang'],'required','message' => Yii::t('app', 'Wajib Diisi')],
            
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
            'ikhtisas' => 'Ikhtisas',
            'portfolio_id' => 'Portfolio ID',
        ];
    }
    
      public function getRefPendidikan() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd' => 'ikhtisas']);
    }
}
