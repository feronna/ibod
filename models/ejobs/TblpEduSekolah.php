<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_eduschool".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $scNama
 * @property string $scTahun
 */
class TblpEduSekolah extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.tbl_eduschool';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'scNama', 'scTahun'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['scTahun'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['scNama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'scNama' => 'Sc Nama',
            'scTahun' => 'Sc Tahun',
        ];
    }
}
