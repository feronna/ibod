<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_bantuan".
 *
 * @property int $id
 * @property string $bentukBantuan
 * @property string $BantuanCd
 */
class RefBantuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_bantuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bentukBantuan_ums'], 'string', 'max' => 255],
            [['BantuanCd'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bentukBantuan_ums' => 'Bentuk Bantuan UMS',
            'BantuanCd' => 'Bantuan Cd',
        ];
    }
    
    public function getSponsor() {
        return $this->hasOne(RefBantuan::className(), ['BantuanCd'=>'BantuanCd']);
    }
}
