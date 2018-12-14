<?php
/**
 * 消息状态表数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class MessageState extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param  array $data
	 * @return int pk
	 */
	public function addMessageState($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param array $data
	 * @return boolean
	 */
	public function addMessageStateAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editMessageState($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delMessageState($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param array $condition 条件
	 * @return int
	 */
	public function getMessageStateCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取消息状态表单条数据
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getMessageStateInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得消息状态表列表
	 * @datetime 2017-06-04 18:34:14
	 * @author CM
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getMessageStateList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}
	/**
	 * 更新消息{已读，已删除}
	 * @param $user_id 用户id
	 * @param $ids 消息id
	 * @param $type 消息类型  1系统消息
	 */
	public function updateMessageState($user_id, $ids, $param) {
		if ($user_id > 0 && !empty($ids)) {
			$condition['to_user_id'] = $user_id;
			$condition['id']      			= array('in', $ids);
			return $this->where($condition)->update($param);
		} else {
			return false;
		}
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelMessageState($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>