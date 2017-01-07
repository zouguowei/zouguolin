<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：EcModel.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：模型类，加载了外部的数据库驱动类和缓存类
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */

/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class EcModel {

    public $db = NULL; // 当前数据库操作对象
    public $cache = NULL; //缓存对象
    public $sql = ''; //sql语句，主要用于输出构造成的sql语句
    public $pre = ''; //表前缀，主要用于在其他地方获取表前缀
    public $config = array(); //配置
    protected $options = array(); // 查询表达式参数	

    /**
     * 构造函数
     * @param unknown $config
     */
    public function __construct($config = array()) {
        $this->config = array_merge(C('DB'), $config); //参数配置	
        $this->options['field'] = '*'; //默认查询字段
        $this->pre = $this->config['DB_PREFIX']; //数据表前缀
        $this->connect();
    }

    /**
     * 连接数据库
     */
    public function connect() {
        $dbDriver = 'Ec' . ucfirst($this->config['DB_TYPE']);
        require_once( dirname(__FILE__) . '/driver/db/' . $dbDriver . '.class.php' );
        $this->db = new $dbDriver($this->config); //实例化数据库驱动类	  
    }

    /**
     * 设置表，$$ignore_prefix为true的时候，不加上默认的表前缀
     * @param unknown $table
     * @param string $ignorePre
     * @return EcModel
     */
    public function table($table, $ignorePre = false) {
        if ($ignorePre) {
            $this->options['table'] = $table;
        } else {
            $this->options['table'] = $this->config['DB_PREFIX'] . $table;
        }
        return $this;
    }

    /**
     * 回调方法，连贯操作的实现
     * @param unknown $method
     * @param unknown $args
     * @throws Exception
     * @return EcModel
     */
    public function __call($method, $args) {
        $method = strtolower($method);
        if (in_array($method, array('field', 'data', 'where', 'group', 'having', 'order', 'limit', 'cache'))) {
            $this->options[$method] = $args[0]; //接收数据
            if ($this->options['field'] == '')
                $this->options['field'] = '*';
            return $this; //返回对象，连贯查询
        } else {
            throw new Exception($method . '方法在EcModel.class.php类中没有定义');
        }
    }

    /**
     * 执行原生sql语句，如果sql是查询语句，返回二维数组
     * @param unknown $sql
     * @param unknown $params
     * @param string $is_query
     * @return boolean|unknown|Ambigous <multitype:, unknown>
     */
    public function query($sql, $params = array(), $is_query = false) {
        if (empty($sql))
            return false;
        $sql = str_replace('{pre}', $this->pre, $sql); //表前缀替换
        $this->sql = $sql;
        //判断当前的sql是否是查询语句
        if ($is_query || stripos(trim($sql), 'select') === 0) {
            $data = $this->_readCache();
            if (!empty($data)){
                return $data;
            }
            $query = $this->db->query($this->sql, $params);
            while ($row = $this->db->fetchArray($query)) {
                $data[] = $row;
            }
            if (!is_array($data)) {
                $data = array();
            }
            $this->_writeCache($data);
            return $data;
        } else {
            return $this->db->execute($this->sql, $params); //不是查询条件，直接执行
        }
    }

    /**
     * 统计行数
     * @return Ambigous <boolean, unknown>|unknown
     */
    public function count() {
        $table = $this->options['table']; //当前表
        $field = 'count(*)'; //查询的字段
        $where = $this->_parseCondition(); //条件
        $this->sql = "SELECT $field FROM $table $where"; //这不是真正执行的sql，仅作缓存的key使用

        $data = $this->_readCache();
        if (!empty($data))
            return $data;

        $data = $this->db->count($table, $where);
        $this->_writeCache($data);
        $this->sql = $this->db->sql; //从驱动层返回真正的sql语句，供调试使用
        return $data;
    }

    /**
     * 只查询一条信息，返回一维数组
     * @return boolean
     */	
    public function find() {
        $this->options['limit'] = 1; //限制只查询一条数据
        $data = $this->select();
        return isset($data[0]) ? $data[0] : false;
    }

    /**
     * 返回一个字段
     * @return boolean
     */
    public function getOne() {
        $this->options['limit'] = 1; //限制只查询一条数据
        $field = $this->options['field'];
        $data = $this->select();
        return isset($data[0][$field]) ? $data[0][$field] : false;
    }

    /**
     * 返回指定列
     * @return Ambigous <boolean, unknown>
     */
    public function getCol() {
        $field = $this->options['field'];
        $data = $this->select();
        foreach($data as $vo){
            $arr[] = $vo[$field];
        }
        return isset($arr) ? $arr : false;
    }
    
    /**
     * 查询多条信息，返回数组
     */
    public function select() {
        $table = $this->options['table']; //当前表
        $field = $this->options['field']; //查询的字段
        $where = $this->_parseCondition(); //条件
        return $this->query("SELECT $field FROM $table $where", array(), true);
    }

    /**
     * 获取一张表的所有字段
     * @return Ambigous <boolean, unknown>|unknown
     */
    public function getFields() {
        $table = $this->options['table'];
        $this->sql = "SHOW FULL FIELDS FROM {$table}"; //这不是真正执行的sql，仅作缓存的key使用

        $data = $this->_readCache();
        if (!empty($data))
            return $data;

        $data = $this->db->getFields($table);
        $this->_writeCache($data);
        $this->sql = $this->db->sql; //从驱动层返回真正的sql语句，供调试使用
        return $data;
    }

    /**
     * 插入数据
     * @param string $replace
     * @return unknown|boolean
     */
    public function insert($replace = false) {
        $table = $this->options['table']; //当前表
        $data = $this->_parseData('add'); //要插入的数据
        $INSERT = $replace ? 'REPLACE' : 'INSERT';
        $this->sql = "$INSERT INTO $table $data";
        $query = $this->db->execute($this->sql);
        if ($this->db->affectedRows()) {
            $id = $this->db->lastId();
            return empty($id) ? $this->db->affectedRows() : $id;
        }
        return false;
    }

    /**
     * 替换数据
     * @return Ambigous <unknown, boolean, unknown>
     */
    public function replace() {
        return $this->insert(true);
    }

    /**
     * 修改更新
     * @return boolean
     */
    public function update() {
        $table = $this->options['table']; //当前表
        $data = $this->_parseData('save'); //要更新的数据
        $where = $this->_parseCondition(); //更新条件
        if (empty($where))
            return false; //修改条件为空时，则返回false，避免不小心将整个表数据修改了

        $this->sql = "UPDATE $table SET $data $where";
        $query = $this->db->execute($this->sql);
        return $this->db->affectedRows();
    }

    /**
     * 删除
     * @return boolean
     */
    public function delete() {
        $table = $this->options['table']; //当前表
        $where = $this->_parseCondition(); //条件
        if (empty($where))
            return false; //删除条件为空时，则返回false，避免数据不小心被全部删除

        $this->sql = "DELETE FROM $table $where";
        $query = $this->db->execute($this->sql);
        return $this->db->affectedRows();
    }

    /**
     * 数据过滤
     * @param unknown $value
     */
    public function escape($value) {
        return $this->db->escape($value);
    }

    /**
     * 返回sql语句
     * @return string
     */
    public function getSql() {
        return $this->sql;
    }

    /**
     * 删除数据库缓存
     * @return boolean
     */
    public function clear() {
        if ($this->initCache()) {
            return $this->cache->clear();
        }
        return false;
    }

    /**
     * 初始化缓存类，如果开启缓存，则加载缓存类并实例化
     * @return boolean
     */
    public function initCache() {
        if (is_object($this->cache)) {
            return true;
        } else if ($this->config['DB_CACHE_ON']) {
            require_once( dirname(__FILE__) . '/EcCache.class.php' );
            $this->cache = new EcCache($this->config, $this->config['DB_CACHE_TYPE']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 读取缓存
     * @return boolean|unknown
     */
    private function _readCache() {
        isset($this->options['cache']) or $this->options['cache'] = $this->config['DB_CACHE_TIME'];
        //缓存时间为0，不读取缓存
        if ($this->options['cache'] == 0)
            return false;
        if ($this->initCache()) {
            $data = $this->cache->get($this->sql);
            if (!empty($data)) {
                unset($this->options['cache']);
                return $data;
            }
        }
        return false;
    }

    /**
     * 写入缓存
     * @param unknown $data
     * @return boolean
     */
    private function _writeCache($data) {
        //缓存时间为0，不设置缓存
        if ($this->options['cache'] == 0)
            return false;
        if ($this->initCache()) {
            $expire = $this->options['cache'];
            unset($this->options['cache']);
            return $this->cache->set($this->sql, $data, $expire);
        }
        return false;
    }

    /**
     * 解析数据
     * @param unknown $type
     * @return unknown
     */  
    private function _parseData($type) {
        $data = $this->db->parseData($this->options, $type);
        $this->options['data'] = '';
        return $data;
    }

    /**
     * 解析条件
     * @return unknown
     */
    private function _parseCondition() {
        $condition = $this->db->parseCondition($this->options);
        $this->options['where'] = '';
        $this->options['group'] = '';
        $this->options['having'] = '';
        $this->options['order'] = '';
        $this->options['limit'] = '';
        $this->options['field'] = '*';
        return $condition;
    }

}
