<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "adminposition".
 *
 * @property int $id
 * @property string $position_name
 * @property int $position_type
 * @property int $position_no
 *
 * @property Tblrscoadminpost[] $tblrscoadminposts
 */
class Adminposition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adminposition';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'position_type', 'position_no'], 'integer'],
            [['ref_position_name', 'position_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_position_name' => 'Ref Position Name',
            'position_name' => 'Position Name',
            'position_type' => 'Position Type',
            'position_no' => 'Position No',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblrscoadminposts()
    {
        return $this->hasMany(Tblrscoadminpost::className(), ['adminpos_id' => 'id']);
    }
}
