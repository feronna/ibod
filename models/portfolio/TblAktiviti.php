<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_tbl_aktiviti".
 *
 * @property int $id
 * @property string $icno
 * @property int $myjd_id
 * @property int $fungsi_id
 * @property string $created_at
 * @property string $aktiviti
 */
class TblAktiviti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_aktiviti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['myjd_id', 'fungsi_id'], 'integer'],
            [['created_at'], 'safe'],
            [['aktiviti'], 'string'],
            [['icno'], 'string', 'max' => 15],
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
            'myjd_id' => 'Myjd ID',
            'fungsi_id' => 'Fungsi ID',
            'created_at' => 'Created At',
            'aktiviti' => 'Aktiviti',
        ];
    }
    
        public function getCartaFungsi() {
        return $this->hasOne(RefCartaFungsi::className(), ['id_fungsi' => 'fungsi_id']);
    }
    
    
}
