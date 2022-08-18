<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_bonkontrak".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $nama_organisasi
 * @property string $tempoh_bon
 * @property string $baki_bon
 */
class TblpBonKontrak extends \yii\db\ActiveRecord
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
        return 'ejobs.tbl_bonkontrak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'nama_organisasi', 'tempoh_bon', 'baki_bon'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['ICNO'], 'string', 'max' => 12],
            [['nama_organisasi'], 'string', 'max' => 300],
            [['tempoh_bon', 'baki_bon'], 'string', 'max' => 50],
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
            'nama_organisasi' => 'Nama Organisasi',
            'tempoh_bon' => 'Tempoh Bon',
            'baki_bon' => 'Baki Bon',
        ];
    }
}
