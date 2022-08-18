<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_pelekat_kenderaan_pelawat".
 *
 * @property int $id
 * @property int $id_kenderaan
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $apply_type
 * @property string $no_siri
 * @property string $expired_date
 * @property string $total
 * @property string $updater 
 * @property int $deleted 
 */
class TblPelekatKenderaanPelawat extends \yii\db\ActiveRecord
{
    public $booked;
    
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_pelekat_kenderaan_pelawat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apply_type','siri','no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['id_kenderaan', 'deleted'], 'integer'],
            [['booked','kod_siri','mohon_date', 'expired_date','expired_date_2','id_pelawat'], 'safe'],
             [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['total'], 'number'], 
            [['status_mohon'], 'string', 'max' => 30],
            [['apply_type','no_resit'], 'string', 'max' => 10],
            [['no_siri', 'updater'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_kenderaan' => 'Id Kenderaan',
            'status_mohon' => 'Status Mohon',
            'mohon_date' => 'Mohon Date',
            'apply_type' => 'Apply Type',
            'no_siri' => 'No Siri',
            'expired_date' => 'Expired Date',
            'total' => 'Total',
            'updater' => 'Updater', 
            'deleted' => 'Deleted', 
        ];
    } 
    
    public function getKenderaan() {
        return $this->hasOne(\app\models\esticker\TblStickerPelawat::className(), ['id' => 'id_kenderaan']);
    } 
    
    public function getYangBertugas() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'updater']);
    }
}
