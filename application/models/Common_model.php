<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	if (!class_exists('CI_Model')) { class CI_Model extends Model {} }

	class Common_model extends CI_Model {

		public function __construct() {
			parent::__construct();
			$this->load->database('default');
		}

		public function getTable($table) {
			$this->db->select('*')->from($table);
			$query = $this->db->get();
			return $query->result_array();
	    }

		public function getTableLimit($table, $limit = false, $offset = 0) {
			if ($limit != false) $this->db->limit($limit, $offset);
			$query = $this->db->get($table);
			return $query->result_array();
		}

	    public function getTableOrder($table, $order_by = '', $order_type = '') {
			$this->db->from($table)->order_by($order_by, $order_type);
			$query = $this->db->get();
			return $query->result_array();
	    }

		public function get_where_custom($table, $fieldName, $value) {
			$this->db->where($fieldName, $value);
			$result = $this->db->get($table)->result_array();
			return $result;
		}

		public function get_where_custom_and($table, $where) {
			$this->db->where($where);
			$result = $this->db->get($table)->result_array();
			return $result;
		}

		public function get_where_custom_field($table, $fieldName, $value, $field_select) {
			$this->db->select($field_select);
			$this->db->where($fieldName, $value);
			$result = $this->db->get($table)->result_array();
			return $result;
		}

		public function get_where_custom_order($table, $col, $value, $order_by, $ordertype) {
			$this->db->where($col, $value);
			$this->db->order_by($order_by,$ordertype);
			$result = $this->db->get($table)->result_array();
			return $result;
		}

		public function get_where_custom_and_order($table, $where,$order_by,$ordertype) {
			$this->db->where($where);
			$this->db->order_by($order_by,$ordertype);
			$result = $this->db->get($table)->result_array();
			return $result;
		}

	    public function get_with_limit($table,$order_by='',$order_type='',$limit,$offset) {
			$this->db->from($table)->limit($limit,$offset)->order_by($order_by, $order_type);
			$query = $this->db->get()->result_array();
			return $query;
	    }

		public function get_where_with_limit($table, $col, $value, $limit, $offset, $order_by,$ordertype) {
			$this->db->where($col, $value);
			if ($limit != false) $this->db->limit($limit, $offset);
			$this->db->order_by($order_by, $ordertype);
			return $this->db->get($table)->result_array();
		}

		public function get_where_with_limit_and($table, $where, $limit, $offset, $order_by,$ordertype) {
			$this->db->where($where);
			$this->db->limit($limit, $offset);
			$this->db->order_by($order_by, $ordertype);
			$query = $this->db->get($table)->result_array();
			return $query;
		}

		public function custom_query($mysql_query) {
			$query = $this->db->query($mysql_query);
			return $query->result_array();
		}
		public function query($mysql_query) {
			$query = $this->db->query($mysql_query);
			return $query;
		}

		public function insert($table, $data) {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}

		public function insert_batch($table, $data) {
			$this->db->insert_batch($table, $data);
		}

		public function update($table, $data, $condition) {
			$this->db->update($table, $data, $condition);
		}

	  	public function delete_where($tb_name, $column, $column_id) {
			$this->db->where($column, $column_id);
			$this->db->delete($tb_name);
	  	}

		public function bindings($sql, $arr) {
			return $this->db->query($sql, $arr);
		}

		public function insert_string($table,$data) {
			return $this->db->insert_string($table, $data);
		}

		public function update_string($table,$data,$where) {
			return $this->db->update_string($table, $data, $where);
		}

		public function having($arr) {
			return $this->db->having($arr);
		}

		public function or_having($arr) {
			return $this->db->or_having($arr);
		}

	}
?>