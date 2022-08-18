<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "e_saman.sticker_pelajar".
 *
 * @property int $id
 * @property string $icno_pel
 * @property string $nama_pel
 * @property string $no_metrik
 * @property string $alamat_pel
 * @property string $no_tel_pel
 * @property string $email_pel
 * @property string $veh_owner
 * @property string $veh_user
 * @property string $rel_owner_user
 * @property string $reg_number
 * @property string $veh_color
 * @property string $veh_type
 * @property string $veh_brand
 * @property string $veh_model
 * @property string $roadtax_no
 * @property string $roadtax_exp
 * @property string $lesen_no
 * @property string $lesen_exp
 * @property string $apply_type
 * @property string $lesen_up
 * @property string $roadtax_up
 * @property string $grant_up
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $app_date
 * @property string $jfpiu_pel
 * @property string $no_siri
 */
class stickerPelajar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'e_saman.sticker_pelajar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno_pel', 'nama_pel', 'alamat_pel', 'no_tel_pel', 'email_pel', 'veh_owner', 'veh_user', 'rel_owner_user', 'reg_number', 'veh_color', 'veh_type', 'veh_brand', 'veh_model', 'roadtax_no', 'roadtax_exp', 'lesen_no', 'lesen_exp', 'apply_type', 'lesen_up', 'roadtax_up', 'grant_up', 'status_mohon', 'jfpiu_pel'], 'required'],
            [['alamat_pel'], 'string'],
            [['roadtax_exp', 'lesen_exp', 'mohon_date', 'app_date'], 'safe'],
            [['icno_pel', 'no_tel_pel'], 'string', 'max' => 12],
            [['nama_pel', 'veh_owner', 'veh_user'], 'string', 'max' => 40],
            [['no_metrik', 'no_siri'], 'string', 'max' => 15],
            [['email_pel', 'veh_color'], 'string', 'max' => 30],
            [['rel_owner_user', 'veh_type', 'apply_type', 'status_mohon'], 'string', 'max' => 10],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_brand', 'veh_model', 'roadtax_no', 'lesen_no', 'lesen_up', 'roadtax_up', 'grant_up'], 'string', 'max' => 50],
            [['jfpiu_pel'], 'string', 'max' => 35],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno_pel' => 'Icno Pel',
            'nama_pel' => 'Nama Pel',
            'no_metrik' => 'No Metrik',
            'alamat_pel' => 'Alamat Pel',
            'no_tel_pel' => 'No Tel Pel',
            'email_pel' => 'Email Pel',
            'veh_owner' => 'Veh Owner',
            'veh_user' => 'Veh User',
            'rel_owner_user' => 'Rel Owner User',
            'reg_number' => 'Reg Number',
            'veh_color' => 'Veh Color',
            'veh_type' => 'Veh Type',
            'veh_brand' => 'Veh Brand',
            'veh_model' => 'Veh Model',
            'roadtax_no' => 'Roadtax No',
            'roadtax_exp' => 'Roadtax Exp',
            'lesen_no' => 'Lesen No',
            'lesen_exp' => 'Lesen Exp',
            'apply_type' => 'Apply Type',
            'lesen_up' => 'Lesen Up',
            'roadtax_up' => 'Roadtax Up',
            'grant_up' => 'Grant Up',
            'status_mohon' => 'Status Mohon',
            'mohon_date' => 'Mohon Date',
            'app_date' => 'App Date',
            'jfpiu_pel' => 'Jfpiu Pel',
            'no_siri' => 'No Siri',
        ];
    }
}
