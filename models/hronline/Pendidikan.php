<?php

namespace app\models\hronline;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "hronline.temp_edu".
 *
 * @property int $id
 * @property string $nama
 * @property string $icno
 */
class Pendidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.temp_edu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 255],
            [['icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'icno' => 'Icno',
        ];
    }
         public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
