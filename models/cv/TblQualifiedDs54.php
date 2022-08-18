<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "{{%hrm.cv_tbl_qualified}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $statLantikan
 */
class TblQualifiedDs54 extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%hrm.cv_tbl_qualified_ds54}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['K1','K2','K3','K4','K5','K6','K7','percent','created_at'], 'safe'],
            [['statLantikan'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'statLantikan' => 'Stat Lantikan',
        ];
    }

    public function getUser() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }  

}
