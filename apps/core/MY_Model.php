<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );
/**
 * 封装数据库类
 *
 * @author chaituan
 * @property CI_Loader $load
 *        
 */
class MY_Model extends CI_Model {
	
	/**
	 * 后台登录session user key
	 */
	const ADMIN_SESSION_USER = 'admin_fanqie_session_user';
	
	/**
	 * 后台登录用户权限key
	 */
	const ADMIN_SESSION_PERMISSION = 'admin_fanqie_session_permission';
	/**
	 * 是否超级管理员
	 */
	const ADMIN_SUPPER_MANAGER = 'admin_fanqie_super_manager';
	/**
	 * 商铺 session
	 */
	const SHOP_SESSION_USER = 'shop_fanqie_session_user';
	// 表名字
	protected $table_name = '';
	public $pagemenu = '';
	/**
	 * 获取单条数据
	 *
	 * @param string|array $conditions
	 *        	查询条件
	 * @param string|array $fields
	 *        	查询字段
	 * @param string $order
	 *        	排序
	 * @param string|array $group
	 *        	分组字段
	 * @param string|array $having
	 *        	分组条件
	 * @return mixed
	 */
	public function  __construct(){//手动加载 database，如果改为自动可取消 初始化
		$this->load->database();
	}
	
	function getItem($conditions = null, $fields = null, $order = null, $group = null, $having = null) {
		if (! empty ( $conditions ))
			$this->db->where ( $conditions ); // 条件
		if (! empty ( $fields ))
			$this->db->select ( $fields ); // 查询字段
		if (! empty ( $order ))
			$this->db->order_by ( $order ); // 排序
		if (! empty ( $group ))
			$this->db->group_by ( $group ); // 分组
		if (! empty ( $having ))
			$this->db->having ( $having );
		$query = $this->db->get ( $this->table_name );
		$item = $query->row_array ();
		$query->free_result ();
		return $item;
	}
	/**
	 * 获取数据列表
	 *
	 * @param string|array $conditions
	 *        	查询条件
	 * @param string|array $fields
	 *        	查询字段
	 * @param string|array $order
	 *        	排序
	 * @param int $page
	 *        	当前页
	 * @param int $pagesize
	 *        	每页数量
	 * @param string $group
	 *        	分组字段
	 * @param string|array $having
	 *        	分组条件
	 * @param $pagemenu 返回分页数据        	
	 * @return array
	 */
	function getItems($conditions = null, $fields = null, $order = null, $page = null, $pagesize = null, $group = null, $having = null,$mobile = null) {
		if (! empty ( $conditions ))$this->db->where ( $conditions ); // 条件
		if (! empty ( $fields ))$this->db->select ( $fields ); // 查询字段
		if (! empty ( $order ))$this->db->order_by ( $order ); // 排序
		if (! empty ( $pagesize )) {
			$this->db->limit ( $pagesize, ! empty ( $page ) ? ($page - 1) * $pagesize : 0 ); // (10, 20) LIMIT 20, 10
		}
		if (! empty ( $group ))
			$this->db->group_by ( $group ); // 分组
		if (! empty ( $having ))$this->db->having ( $having );
			// var_dump($this->db->get_compiled_select($this->table_name));//返回sql 语句
		$query = $this->db->get ( $this->table_name );
		$item = $query->result_array ();
		$query->free_result (); // 释放
		
		if (! empty ( $pagesize )) { // 是否启用分页
			$count = $this->count ( $conditions, $group, $having); // 获取总数
			if(!empty($mobile)){//是否是手机端
				$end = (int) ceil($count / $pagesize)-$page;
				$this->pagemenu = array('end'=>$end>0?$end:0,'start'=>$page+1);
			}else{
				$pages = pages ( $count, $pagesize ); // 获取分页
				$this->pagemenu = $pages; // 控制器直接调用
			}
		}
		return $item;
	}
	
	/**
	 * 获取总数
	 *
	 * @param string $conditions        	
	 * @param string $group        	
	 * @param string $having        	
	 * @param array $table
	 *        	key 数据表 val 条件 val里面写+ 后面带的是关联方式
	 * @return int
	 */
	function count($conditions = null, $group = null, $having = null, $table = null) {
		if (! empty ( $table )) {
			foreach ( $table as $k => $v ) {
				$vs = explode ( '+', $v );
				if (! empty ( $vs [1] )) {
					$this->db->join ( $k, $vs [0], $vs [1] );
				} else {
					$this->db->join ( $k, $vs [0] );
				}
			}
		}
		
		if (! empty ( $conditions ))
			$this->db->where ( $conditions ); // 条件
		if (! empty ( $group ))
			$this->db->group_by ( $group ); // 分组
		if (! empty ( $having ))
			$this->db->having ( $having );
		$item = $this->db->count_all_results ( $this->table_name );
		return $item;
	}
	/**
	 * 关联查询
	 *
	 * @param array $table
	 *        	key 数据表 val 条件
	 * @param string $conditions        	
	 * @param string $fields        	
	 * @param string $order        	
	 * @param string $page        	
	 * @param string $pagesize        	
	 * @param string $group        	
	 * @param string $having        	
	 * @return array
	 */
	function getItems_join($table, $conditions = null, $fields = null, $order = null, $page = null, $pagesize = null, $group = null, $having = null,$mobile = null) {
		// 分解table + 后面是关联方式
		foreach ( $table as $k => $v ) {
			$vs = explode ( '+', $v );
			if (! empty ( $vs [1] )) {
				$this->db->join ( $k, $vs [0], $vs [1] );
			} else {
				$this->db->join ( $k, $vs [0] );
			}
		}
		if (! empty ( $conditions ))
			$this->db->where ( $conditions ); // 条件
		if (! empty ( $fields ))
			$this->db->select ( $fields ); // 查询字段
		if (! empty ( $order ))
			$this->db->order_by ( $order ); // 排序
		if (! empty ( $group ))
			$this->db->group_by ( $group ); // 分组
		if (! empty ( $having ))
			$this->db->having ( $having );
		if (! empty ( $pagesize )) {
			$this->db->limit ( $pagesize, ! empty ( $page ) ? ($page - 1) * $pagesize : 0 ); // (10, 20) LIMIT 20, 10
		}
		$query = $this->db->get ( $this->table_name );
		$item = $query->result_array ();
		$query->free_result (); // 释放
		
		if (! empty ( $pagesize )) { // 是否启用分页
			$count = $this->count ( $conditions, $group, $having, $table ); // 获取总数
			if(!empty($mobile)){//是否是手机端
				$end = (int) ceil($count / $pagesize)-$page;
				$this->pagemenu = array('end'=>$end>0?$end:0,'start'=>$page+1);
			}else{
				$pages = pages ( $count, $pagesize ); // 获取分页
				$this->pagemenu = $pages; // 控制器直接调用
			}
		}
		return $item;
	}
	
	/**
	 * 更新数据
	 *
	 * @param
	 *        	$data
	 * @param
	 *        	$conditions
	 * @return mixed
	 */
	public function updates($data, $conditions) {
		$this->db->where ( $conditions );
		if (is_array ( $data )) {
			foreach ( $data as $k => $v ) {
				switch (substr ( $v, 0, 2 )) {
					case '+=' :
						$this->db->set ( $k, $k . "+" . str_replace ( "+=", "", $v ), false );
						unset ( $data [$k] );
						break;
					case '-=' :
						$this->db->set ( $k, $k . "-" . str_replace ( "-=", "", $v ), false );
						unset ( $data [$k] );
						break;
					case '<>' :
						$this->db->set ( $k, $k . "<>" . $v, false );
						unset ( $data [$k] );
						break;
					case '<=' :
						$this->db->set ( $k, $k . "<=" . $v, false );
						unset ( $data [$k] );
						break;
					case '>=' :
						$this->db->set ( $k, $k . ">=" . $v, false );
						unset ( $data [$k] );
						break;
					case '^1' :
						$this->db->set ( $k, $k . "^1", false );
						unset ( $data [$k] );
						break;
					case 'in' :
						if (substr ( $v, 0, 3 ) == "in(") {
							$this->db->where_in ( $k, $v, false );
							unset ( $data [$k] );
						} else {
							$this->db->set ( $k, $v, true );
							unset ( $data [$k] );
						}
						break;
					case 'sq' :
						$this->db->set ( $k, str_replace ( "sq", "", $v ), false );
						unset ( $data [$k] );
						break;
					default :
						$this->db->set ( $k, $v, true );
				}
			}
			return $this->db->update ( $this->table_name );
		} else {
			return $this->db->update ( $this->table_name, check_input ( $data ) );
		}
	}
	
	/**
	 * 批量更新
	 * $key 键名
	 */
	function update_batchs($data, $key) {
		return $this->db->update_batch($this->table_name, $data, $key);
	}
	
	/**
	 * 添加数据
	 * $return_insert_id 是否返回ID
	 */
	public function add($data, $return_insert_id = true) {
		if (is_array ( $data )) {
			$this->db->set ( $data, '', true );
			$this->db->insert ( $this->table_name );
			if ($return_insert_id)return $this->db->insert_id ();
		} else {
			$this->db->insert ( $this->table_name, check_input ( $data ) );
			if ($return_insert_id)return $this->db->insert_id ();
		}
	}
	
	/**
	 * 批量添加数据
	 * data 二维数据
	 */
	public function add_batch($data){
		return $this->db->insert_batch($this->table_name,$data);
	}
	
	/**
	 * 删除数据
	 */
	public function deletes($conditions) {
		$this->db->where ( $conditions );
		return $this->db->delete ( $this->table_name );
	}
	
	//事物
	public function start(){
		$this->db->trans_start();
	}
	
	public function complete(){
		$this->db->trans_complete();
	}
	/**
	 * 执行查询
	 */
	public function querys($sql) {
		$query = $this->db->query ( $sql );
		$items = $query->result_array ();
		$query->free_result ();
		return $items;
	}
}

