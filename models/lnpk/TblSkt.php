<?php

namespace app\models\lnpk;

use Yii;

/**
 * This is the model class for table "hrm.lnpk_tbl_skt".
 *
 * @property int $id
 * @property string $lnpk_id
 * @property string $skt_aktiviti
 * @property string $skt_kuantiti
 * @property string $skt_kualiti
 * @property string $skt_masa
 * @property string $skt_kos
 * @property string $skt_sasar
 * @property string $skt_capai
 * @property string $skt_ulasan_PYD
 */
class TblSkt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lnpk_tbl_skt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skt_aktiviti'], 'required'],
            [['lnpk_id'], 'integer'],
            [['skt_ulasan_PYD'], 'string'],
            [['skt_aktiviti'], 'string', 'max' => 100],
            [['skt_kuantiti', 'skt_kualiti', 'skt_masa', 'skt_kos'], 'string', 'max' => 50],
            [['skt_sasar', 'skt_capai'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lnpk_id' => 'Lnpk ID',
            'skt_aktiviti' => 'Skt Aktiviti',
            'skt_kuantiti' => 'Skt Kuantiti',
            'skt_kualiti' => 'Skt Kualiti',
            'skt_masa' => 'Skt Masa',
            'skt_kos' => 'Skt Kos',
            'skt_sasar' => 'Skt Sasar',
            'skt_capai' => 'Skt Capai',
            'skt_ulasan_PYD' => 'Skt Ulasan Pyd',
        ];
    }

    public function getPetunjukPrestasi()
    {
        return '<dl >
            <dt>Kuantiti</dt>
            <dd>' . ($this->skt_kuantiti || !empty($this->skt_kuantiti) ? $this->skt_kuantiti : '-') . '</dd>
        
            <dt>Kualiti</dt>
            <dd>' . ($this->skt_kualiti || !empty($this->skt_kualiti) ? $this->skt_kualiti : '-') . '</dd>

            <dt>Masa</dt>
            <dd>' . ($this->skt_masa || !empty($this->skt_masa) ? $this->skt_masa : '-') . '</dd>
        
            <dt>Kos</dt>
            <dd>' . ($this->skt_kos || !empty($this->skt_kos) ? $this->skt_kos : '-') . '</dd>
        </dl>';
    }
}
