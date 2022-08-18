<?php

namespace app\models\brp;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "brp.staf_akses".
 *
 * @property string $staf_akses_icno
 * @property int $staf_akses_id akses_level
 */
class StafAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.brp_staf_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staf_akses_icno'], 'required'],
            [['staf_akses_id'], 'integer'],
            [['staf_akses_icno'], 'string', 'max' => 14],
            [['staf_akses_icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staf_akses_icno' => 'Staf Akses Icno',
            'staf_akses_id' => 'Staf Akses ID',
        ];
    }
    
      public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO'=>'staf_akses_icno']);
    }
}
