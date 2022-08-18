<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_kpi".
 *
 * @property int $id
 * @property int $kriteriakpi_id id dari table ref_kriteriakpi
 * @property string $perkara
 * @property string $catatan
 * @property string $perkara_2
 * @property string $catatan_2
 * @property string $perkara_3
 * @property string $catatan_3
 * @property string $tarikh
 * @property int $kontrak_id
 */
class TblKpi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_kpi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteriakpi_id', 'kontrak_id'], 'integer'],
            [['catatan'], 'required','message' => 'this field cannot be blank'],
            [['catatan', 'catatan_2', 'catatan_3'], 'string'],
            [['tarikh'], 'safe'],
            [['perkara'], 'string', 'max' => 50],
            [['perkara_2', 'perkara_3'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kriteriakpi_id' => 'Kriteriakpi ID',
            'perkara' => 'Perkara',
            'catatan' => 'Catatan',
            'perkara_2' => 'Perkara 2',
            'catatan_2' => 'Catatan 2',
            'perkara_3' => 'Perkara 3',
            'catatan_3' => 'Catatan 3',
            'tarikh' => 'Tarikh',
            'kontrak_id' => 'Kontrak ID',
        ];
    }
    
    public function getKriteria() {
        return $this->hasOne(RefKriteriaKpi::className(), ['id' => 'kriteriakpi_id']);
    }
    
    public function getKpibyyear() {
        return $this->hasMany(TblKpiByYear::className(), ['kpi_id' => 'id']);
    }
    
    public static function kpi_user($kontrak_id, $kpi_id){
        return static::find()->where(['kontrak_id' => $kontrak_id, 'kriteriakpi_id' => $kpi_id])->andWhere(['!=','perkara','comment'])->andWhere(['!=','perkara','comment_kp'])->orderBy(['id' => SORT_ASC])->all();
                                
    }
    
    public static function comment_kp($kontrak_id, $kpi_id){
        return static::find()->where(['kontrak_id'=> $kontrak_id, 'kriteriakpi_id'=>$kpi_id, 'perkara' => 'comment_kp'])->one()->catatan;
                                
    }
    
    public static function comment_kj($kontrak_id, $kpi_id){
        return static::find()->where(['kontrak_id'=> $kontrak_id, 'kriteriakpi_id'=>$kpi_id, 'perkara' => 'comment'])->one()->catatan;
                                
    }
}
