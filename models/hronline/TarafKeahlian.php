<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.membershiptype".
 *
 * @property string $MembershipTypeCd
 * @property string $MembershipType
 */
class TarafKeahlian extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.membershiptype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MembershipTypeCd','MembershipType'], 'required','message'=>'Ruang ini adalah mandatori'],
            [['MembershipTypeCd'], 'string', 'max' => 1],
            [['MembershipType'], 'string', 'max' => 255],
            [['MembershipTypeCd'], 'unique'],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MembershipTypeCd' => 'Membership Type Cd',
            'MembershipType' => 'Membership Type',
        ];
    }
    public function getStatus() {
        return $this->isActive ? "Aktif":"Tidak aktif";
    }
}
