<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Config.php.
 *
 * Part of Overtrue\WeChat.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    overtrue <i@overtrue.me>
 * @copyright 2015
 *
 * @see      https://github.com/overtrue/wechat
 * @see      http://overtrue.me
 */

namespace EasyWeChat\Foundation;

use EasyWeChat\Support\Collection;

/**
 * Class Config.
 */
class Config extends Collection
{
	function __construct($items){
		$data = array('debug'=>false,'app_id'=>WX_APPID,'secret'=>WX_APPSecret,'log'=>['level'=>'All','permission' => 0777,'file'=> APPPATH.'cache/wechat/fanqie_'.date('Ymd').'.log']);
		parent::__construct($data);
		$result = $this->merge($items);
		return $result;
	}
}
