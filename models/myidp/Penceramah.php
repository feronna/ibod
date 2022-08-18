<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_tbl_penceramah".
 *
 * @property string $penceramah_id
 * @property string $penceramah_title
 * @property string $penceramah_name
 * @property string $penceramah_bio
 * @property string $created_at
 * @property string $created_by
 * @property string $email
 * @property string $office_number
 * @property string $mobile_number
 * @property string $agensi
 * @property int $id
 */
class Penceramah extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_penceramah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penceramah_name', 'email', 'mobile_number'], 'required'],
            [['penceramah_name', 'penceramah_bio', 'agensi'], 'string'],
            [['created_at'], 'safe'],
            [['penceramah_id', 'created_by'], 'string', 'max' => 12],
            [['penceramah_title'], 'string', 'max' => 4],
            [['email'], 'string', 'max' => 100],
            [['office_number', 'mobile_number'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'penceramah_id' => 'Penceramah ID',
            'penceramah_title' => 'Penceramah Title',
            'penceramah_name' => 'Penceramah Name',
            'penceramah_bio' => 'Penceramah Bio',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'email' => 'Email',
            'office_number' => 'Office Number',
            'mobile_number' => 'Mobile Number',
            'agensi' => 'Agensi',
            'id' => 'ID',
        ];
    }
}
