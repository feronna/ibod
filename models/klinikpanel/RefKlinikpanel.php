<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "klinikpanel2.klinik_panel".
 *
 * @property int $klinik_id
 * @property string $nama
 * @property string $alamat
 * @property string $fax
 * @property string $telefon
 * @property string $created_by
 * @property string $tarikhproses
 * @property string $updateoleh
 * @property string $tarikhupdate
 * @property string $saga_id
 * @property string $klinik_ref
 * @property string $klinik_email
 */
class RefKlinikpanel extends \yii\db\ActiveRecord
{
    // add the function below:
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_klinik_panel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'telefon', 'created_by', 'tarikhproses', 'saga_id', 'klinik_ref'], 'required'],
            [['tarikhproses', 'tarikhupdate','isUMS'], 'safe'],
            [['nama'], 'string', 'max' => 150],
            [['alamat','isActive'], 'string', 'max' => 200],
            [['fax', 'telefon', 'saga_id', 'klinik_ref', 'klinik_email'], 'string', 'max' => 45],
            [['created_by', 'updateoleh'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'klinik_id' => 'Klinik ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'fax' => 'Fax',
            'telefon' => 'Telefon',
            'created_by' => 'Created By',
            'tarikhproses' => 'Tarikhproses',
            'updateoleh' => 'Updateoleh',
            'tarikhupdate' => 'Tarikhupdate',
            'saga_id' => 'Saga ID',
            'klinik_ref' => 'Klinik Ref',
            'klinik_email' => 'Klinik Email',
        ];
    }
}
