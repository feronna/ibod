<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_calon_kiv".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $gred
 * @property string $added_at
 * @property string $added_by
 * @property int $active
 */
class TblCandidateKiv extends \yii\db\ActiveRecord
{ 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cv_tbl_calon_kiv';
    }

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan_id', 'active'], 'integer'],
            [['added_at'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['added_by'], 'string', 'max' => 12],
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
            'added_at' => 'Added At',
            'added_by' => 'Added By',
            'active' => 'Active',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_id']);
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
