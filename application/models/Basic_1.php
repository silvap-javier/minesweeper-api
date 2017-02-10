<?php

class Basic extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	

	public function add($collection,$data){
		$status = $this->mongo_db->insert($collection, $data);
		return $status;	
	}
	public function update($collection,$where,$update){
		$status = $this->mongo_db->where($where)->set($update)->update($collection);
		return $status;
	}
	public function get_all($collection,$order = false){
		if ($order){
			$collection = $this->mongo_db->order_by(array($order => 'ASC'))->get($collection);
		}else{
			$collection = $this->mongo_db->get($collection);
		}
		return $collection;
	}

	public function get_all_by_select($collection,$where){
		$collection = $this->mongo_db->select($where)->get($collection);
		return $collection;
	}

	public function get_where($collection,$where,$order = false){
		if ($order){
			$collection = $this->mongo_db->where($where)->order_by(array($order => 'ASC'))->get($collection);
		}else{
			$collection = $this->mongo_db->where($where)->get($collection);
		}
		return $collection;
	}

	public function delete($collection,$where){
		return $this->mongo_db->where($where)->delete($collection);
	}

}