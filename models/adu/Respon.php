<?php

namespace app\models\adu;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "utilities.adu_tbl_respon".
 *
 * @property int $id
 * @property int $main_id
 * @property string $icno
 * @property string $ulasan
 * @property string $create_dt
 * @property int $respon_type
 */
class Respon extends \yii\db\ActiveRecord
{
    public $redirectUrl;
    public $responKpd;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.adu_tbl_respon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'icno', 'ulasan', 'create_dt',], 'required'],
            [['main_id','respon_type'], 'integer'],
            [['ulasan'], 'string'],
            [['create_dt', 'redirectUrl','responKpd'], 'safe'],
            [['icno','responKpd'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_id' => 'Main ID',
            'icno' => 'Icno',
            'ulasan' => 'Ulasan',
            'create_dt' => 'Create Dt',
            'respon_type' => 'Jenis Respon',
            'responKpd' => 'Tindakan kepada Pegawai',
        ];
    }

    public function getBio()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'icno']);
    }
}
