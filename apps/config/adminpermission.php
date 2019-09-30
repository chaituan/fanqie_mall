<?php
/**
 * 后台管理权限配置数组
 * @author chaituan@126.com
 */
$config ['adminpermission'] = array (
		/**
		 * *************** 系统模块 ********************
		 */
		'config' => array (
				'name' => '系统配置',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'delete' => '删除' 
				) 
		),
		'menu' => array (
				'name' => '后台菜单',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'quicksave' => '快速保存',
						'delete' => '删除' 
				) 
		),
		'menuGroup' => array (
				'name' => '菜单分组',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'quicksave' => '快速保存',
						'delete' => '删除' 
				) 
		),
		'admin' => array (
				'name' => '管理员',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'delete' => '删除' 
				) 
		),
		'role' => array (
				'name' => '管理员角色',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'quicksave' => '快速保存',
						'permission' => '查看权限',
						'updatePermission' => '修改权限',
						'delete' => '删除' 
				) 
		),
		/**
		 * *************** 会员模块 ********************
		 */
		'userGroup' => array (
				'name' => '会员分组',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'deletes' => '批量删除',
						'delete' => '删除' 
				) 
		),
		'userRole' => array (
				'name' => '会员角色',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'deletes' => '批量删除',
						'delete' => '删除' 
				) 
		),
		'user' => array (
				'name' => '会员',
				'methods' => array (
						'index' => '浏览',
						'insert' => '添加',
						'update' => '修改',
						'abort' => '封号',
						'unaborted' => '解封',
						'quickcheck' => '审核',
						'deletes' => '批量删除',
						'delete' => '删除',
						'sysmsg' => '消息浏览',
						'sysmsgs' => '系统消息浏览',
						'sendsysmsg' => '群发消息' 
				) 
		) 
);
