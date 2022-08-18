<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.tbl_publications".
 *
 * @property int $id
 * @property string $icno
 * @property int $type 1 = Google Scholar | 2 : Scopus
 * @property string $url
 */
class Publications extends \yii\db\ActiveRecord
{

    public $nokp = null;

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db2'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.tbl_publications';
    }

    public function getTypeTxt()
    {

        if ($this->type == 1) {
            return 'Google Scholar';
        }

        if ($this->type == 2) {
            return 'Scopus';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['url'], 'unique'],
            [['url'], 'url'],
            [['type', 'url'], 'required'],
            [['type'], 'checkType', 'on'=>'newRecord', 'params'=>$this->nokp],
            [['icno'], 'string', 'max' => 15],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'type' => 'Publication Type',
            'url' => 'Profile Url',
        ];
    }

    public function checkType($attribute, $params)
    {

        $check_exist = self::find()->where(['icno'=>$params, 'type'=>$this->type])->one();

        if ($check_exist) {
            $this->addError($attribute, 'Publication type is already exist!, Please check your record');
        }
    }

}
