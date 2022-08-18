<?php

namespace app\models\lppums\v2;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v2_tbl_document".
 *
 * @property string $id
 * @property int $id_skt
 * @property string $filehash
 * @property string $file_name
 * @property string $created_dt
 * @property string $verified_ppp
 * @property string $verified_dt_ppp
 * @property string $verified_ppk
 * @property string $verified_dt_ppk
 * @property string $ulasan
 */
class TblDocuments extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    // const SCENARIO_UPDATE = 'update';

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v2_tbl_document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'file_name', 'filehash', 'created_dt', 'id_skt'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id_skt'], 'integer'],
            [['created_dt', 'verified_dt_ppp', 'verified_dt_ppk'], 'safe'],
            [['filehash'], 'string', 'max' => 150],
            [['file_name'], 'string', 'max' => 3000],
            [['verified_ppp', 'verified_ppk'], 'string', 'max' => 12],
            [['ulasan'], 'string', 'max' => 500],
            [['file'], 'file', 'extensions' => ['pdf', 'jpg', 'png'], 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['file', 'file_name', 'filehash', 'created_dt', 'id_skt'],
            // self::SCENARIO_UPDATE => ['username', 'email', 'password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_skt' => 'Id Skt',
            'filehash' => 'Filehash',
            'file_name' => 'File Name',
            'created_dt' => 'Created Dt',
            'verified_ppp' => 'Verified Ppp',
            'verified_dt_ppp' => 'Verified Dt Ppp',
            'verified_ppk' => 'Verified Ppk',
            'verified_dt_ppk' => 'Verified Dt Ppk',
            'ulasan' => 'Ulasan',
        ];
    }
}
