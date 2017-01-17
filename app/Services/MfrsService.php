<?php
namespace App\Services;


use App\Models\OmGoods;
use App\Models\OmGoodsMfrs;
use Illuminate\Support\Facades\Auth;

class MfrsService extends BaseService {
    protected $uid;

    public function __construct(OmGoodsMfrs $goodsMfrs){
        $this->model = $goodsMfrs;
        $this->uid = Auth::user()->id;
    }

    //修改排序
    public function putMfrsSort($goods_id, $data){
        foreach ($data as $k=>$v) {
            $mfrs = explode('_',$v['id']);
            OmGoodsMfrs::where(array('id'=>$mfrs[1],'goods_id'=>$goods_id))->update(['sort'=>$v['sort']]);
        }
    }

    public function getMfrs($id){
        $mfrs = $this->model->select('id','sort','mfrs_name','mfrs_sn','goods_id')->where('id',$id)->first();
        $goods_name = OmGoods::where('id',$mfrs['id'])->pluck('cn_name');
        return ['data'=>$mfrs,'goods_name'=>$goods_name,'goods_id'=>$mfrs['goods_id']];
    }

    public function putMfrs($id, $data){
        unset($data['edit']);
        $update = $this->model->where('id',$id)->update($data);
        if(!$update){
            return ['status'=>false, '更新失败'];
        }
        return ['status'=>true];
    }

    public function deleteMfrs($id){
        $delete = $this->model->where('id',$id)->delete();
        if(!$delete){
            return ['status'=>false, '删除失败'];
        }
        return ['status'=>true];
    }

}