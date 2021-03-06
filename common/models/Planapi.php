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
            'foto'=>function($data){
                $dori=DoriApi::findOne($data->dori_id);
                return 'http://83.221.167.17:60011/farmpay/admin/image/'.$dori['foto'];
            },
            'residue'=>function($data){
                $sold=RegisterPharmacist::find()->where(['plan_id'=>$data->id])->andWhere(['<','date',strtotime('now')])->sum('count');
                if($sold==null){
                    $sold=0;
                }
                return (double)$sold;
            },
            'outlay'=>function($data){
                $outlay=RegisterPharmacist::find()->where(['plan_id'=>$data->id,'type'=>'chiqim'])->andWhere(['<','date',strtotime('now')])->sum('count');
                if($outlay==null){
                    $outlay=0;
                }
                return (double)$outlay;
            },
            'income'=>function($data){
                $income=RegisterPharmacist::find()->where(['plan_id'=>$data->id,'type'=>'kirim'])->andWhere(['<','date',strtotime('now')])->sum('count');
                if($income==null){
                    $income=0;
                }
                return (double)$income;
            },
            'dori_id',
            'count',
            'sold'=>function($data){
                return $data->Sold($data);
            },
        ];
    }
}
