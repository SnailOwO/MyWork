<?php

namespace App\Repositories;

trait BaseRepository {

    /**
     * Store a new record.
     *
     * @param  $input
     * @return User
     */
    public function store($input) {    // model 单例会常驻内存中
        return $this->save($this->model, $input);
    }

    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     * @return mixed
     */
    public function save($model, $input) {
        $model->fill($input);

        $model->save();

        return $model;
    }

    public function create($data) {
        return $this->model->create($data);
    }

    /**
     * Get one record without draft scope
     *
     * @param $id
     * @return mixed
     */
    public function getById($id) {
        return $this->model->findOrFail($id);
    }

    // 根据Id查出相应的记录
    public function getOneById($id) {
        return $this->model->find($id);
    }
    /**
     * Delete the draft article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id) {
        return $this->getById($id)->delete();
    }

    // 批量删除
    public function destroyByIds($ids) {
        return $this->model->whereIn('id',$ids)->delete();
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getAllData($field = "*", $needToArray = true) {
        if ($needToArray) {
            return $this->model->select($field)->get()->toArray();
        } else {
            return $this->model->select($field)->get();
        }
    }

    /**
     * To judge the record is existence in you table
     *
     * @param $where
     */
    public function getFirstRecordByWhere($where) {
        return $this->model->where($where)->first();
    }


    public function getRecordByWhere($where) {
        return $this->model->where($where)
                        ->get()
                        ->toArray();
    }

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input) {
        $this->model = $this->getById($id);

        return $this->save($this->model, $input);
    }

    // public function page($where = false, $pagesize = 20, $sortColumn = 'weight', $sort = 'asc') {
    //     if ($where) {
    //         if($sortColumn != 'created_at'){
    //             return $this->model->where($where)->orderBy($sortColumn, $sort)->orderBy('created_at', 'desc')->paginate($pagesize);
    //         }
    //         return $this->model->where($where)->orderBy($sortColumn, $sort)->paginate($pagesize);
    //     } else {
    //         return $this->model->orderBy($sortColumn, $sort)->paginate($pagesize);
    //     }
    // }

    public function getThisModel() {
        return $this->model;
    }

    /**
     * Get all the records
     *
     * @return array User
     */
    public function all() {
        return $this->model
                    ->get()
                    ->toArray();
    }
}