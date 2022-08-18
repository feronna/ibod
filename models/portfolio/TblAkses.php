<?php

namespace app\models\portfolio;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.portfolio_tbl_akses".
 *
 * @property int $id
 * @property int $jenis_akses
 * @property string $icno
 */
class TblAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_tbl_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_akses'], 'integer'],
            [['icno'], 'string', 'max' => 18],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_akses' => 'Jenis Akses',
            'icno' => 'Icno',
        ];
    }
        public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
