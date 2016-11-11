<?php
namespace App\Services;


use App\Models\OmGoodsCat;
use Illuminate\Support\Facades\Auth;

class GoodsCatService extends BaseService {

    protected  $uid;
    public function __construct(OmGoodsCat $omGoodsCat){
        $this->model = $omGoodsCat;
        $this->uid = Auth::user()->id;
    }

    //添加类目
    public function addCat($data){
        if(!isset($data['name']) || !$data['name']){
            return ['status'=>false, 'msg'=>'类目名称不能为空'];
        }

        $cat_data['parent_id'] = isset($data['parent_id']) ? intval($data['parent_id']) : 0;
        $cat_data['name'] = $data['name'];
        $cat_data['uid'] = $this->uid;

        $cat = $this->model->create($cat_data);
        if($cat){
            return ['status'=>true, 'data'=>$cat];
        }else{
            return ['status'=>false, 'msg'=>'类目添加失败'];
        }
    }

    //编辑类目
    public function editCat($id, $data){
        $cat = $this->model->where(array('id'=>$id,'is_deleted'=>0))->first();
        if(!$cat){
            return ['status'=>false, 'msg'=>'类目不存在'];
        }
        if(!isset($data['name']) || !$data['name']){
            return ['status'=>false, 'msg'=>'类目名称不能为空'];
        }

        $cat_data['parent_id'] = isset($data['parent_id']) ? intval($data['parent_id']) : 0;
        $cat_data['name'] = $data['name'];

        $cat_id = $this->model->where('id', $id)->update($cat_data);
        if($cat_id){
            $cat = $this->model->where('id',$cat_id)->first();
            return ['status'=>true, 'data'=>$cat];
        }else{
            return ['status'=>false, 'msg'=>'类目编辑失败'];
        }
    }

    //类目详情
    public function getCat($id){
        $cat = $this->model->where(array('id'=>$id,'is_deleted'=>0))->first();
        if(!$cat){
            return ['status'=>false, 'msg'=>'类目不存在'];
        }
        return ['status'=>true, 'data'=>$cat];
    }

    //类目列表
    public function getCats($data){
        $parent_id = isset($data['parent_id']) ? $data['parent_id'] : 0;
        $offset = isset($data['offset']) ? $data['offset'] : null;
        $limit = isset($data['limit']) ? $data['limit'] : null;
        $where = array(
            array('column'=>'parent_id', 'value'=>$parent_id, 'operator'=>'='),
            array('column'=>'is_deleted', 'value'=>0, 'operator'=>'='),
        );
        $result['_count'] = $this->getCount($where);
        $result['data'] = $this->getList($where, $offset, $limit);

        return $result;
    }

    //删除类目
    public function deleteCats($ids){
        $res = $this->model->whereIn('id',$ids)->delete();
        if(!$res){
            return ['status'=>false,'msg'=>'操作失败'];
        }
        return ['status'=>true];
    }
}