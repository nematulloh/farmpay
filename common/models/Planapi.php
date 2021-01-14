<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "plan".
 *
 * @property int $id
 * @property int $pharmacist_id
 * @property int $dori_id
 * @property int $count
 * @property int $date
 */
class Planapi extends Plan
{
    /**
     * {@inheritdoc}
     */
    public function fields(){
        return [
            'id',
            // 'dori_id',
            'dori'=>function($data){
                $dori=DoriApi::findOne($data->dori_id);
                return $dori['name'];
            },
            'count',
            'sold'=>function($data){
                $sold=RegisterPharmacist::find()->where(['plan_id'=>$data->id,'type'=>'chiqim'])->andWhere(['<','date',strtotime('now')])->sum('count');
                if($sold==null){
                    $sold=0;
                }else{
                    $sold=$sold * -1;
                }
                return $sold;
            },
        ];
    }
}
