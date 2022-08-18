<?php

namespace app\models\elnpt\simulation;

use Yii;
use yii\base\Model;

class TblCalcData extends Model
{
    public $aktiviti_id;
    public $bil;
    public $mata;
    public $kategori;
    public $nilai_mata;
    public $order_no;
    public $jenis;

    public function rules()
    {
        return [
            [['aktiviti_id', 'mata', 'kategori', 'nilai_mata', 'order_no'], 'integer'],
            // [['kategori'], 'required'],
            [['bil', 'mata'], 'default', 'value' => 0],
            [['bil'], 'number', 'min' => 0],
            ['jenis', 'safe'],
        ];
    }

    public function formName()
    {
        return 'TblCalcData';
    }

    public function attributeLabels()
    {
        return [
            'bil' => 'Input',
            // 'lpp_id' => 'Lpp ID',
            // 'aspek_id' => 'Aspek ID',
            // 'skor' => 'Skor',
            // 'markah_pyd' => 'Markah Pyd',
            // 'markah_ppp' => 'Markah Ppp',
            // 'markah_ppk' => 'Markah Ppk',
            // 'markah_peer' => 'Markah Peer',
        ];
    }

    public static function integerOnly($index)
    {
        $decimalsInd = [2, 8, 56, 57, 58, 59, 60, 61, 62, 63, 64, 153, 154];
        if (!in_array($index, $decimalsInd))
            return false;
        else
            return true;
    }
}
