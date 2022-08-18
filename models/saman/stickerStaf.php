<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "e_saman.sticker_staf".
 *
 * @property int $id
 * @property string $v_co_icno
 * @property string $nama_staf
 * @property string $umsper
 * @property string $alamat_staf
 * @property string $no_tel_staf
 * @property string $email_staf
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
 * @property string $jfpiu_staf
 * @property string $no_siri
 */
class stickerStaf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
      public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.sticker_staf';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['v_co_icno', 'nama_staf', 'jfpiu_staf'], 'required'],
            [['alamat_staf'], 'string'],
            [['roadtax_exp', 'lesen_exp', 'mohon_date', 'app_date'], 'safe'],
            [['v_co_icno', 'no_tel_staf'], 'string', 'max' => 12],
            [['nama_staf', 'veh_owner', 'veh_user'], 'string', 'max' => 40],
            [['umsper', 'no_siri'], 'string', 'max' => 15],
            [['email_staf', 'veh_color'], 'string', 'max' => 30],
            [['rel_owner_user', 'veh_type', 'apply_type', 'status_mohon'], 'string', 'max' => 10],
            [['reg_number'], 'string', 'max' => 9],
            [['veh_brand', 'veh_model', 'roadtax_no', 'lesen_no', 'lesen_up', 'roadtax_up', 'grant_up'], 'string', 'max' => 50],
            [['jfpiu_staf'], 'string', 'max' => 35],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'v_co_icno' => 'V Co Icno',
            'nama_staf' => 'Nama Staf',
            'umsper' => 'Umsper',
            'alamat_staf' => 'Alamat Staf',
            'no_tel_staf' => 'No Tel Staf',
            'email_staf' => 'Email Staf',
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
            'jfpiu_staf' => 'Jfpiu Staf',
            'no_siri' => 'No Siri',
        ];
    }
}
