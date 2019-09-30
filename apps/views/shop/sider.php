<!-- aside -->
<aside id="aside" class="app-aside hidden-xs bg-dark">
	<div class="aside-wrap">
		<div class="navi-wrap">
			<!-- nav -->
			<nav ui-nav class="navi clearfix">
			<ul class="nav">
				<li class="line dk"></li>
                <li class="active"'>
                	<a href="" class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i>
						</span> <i class="fa fa-cog"></i> <span>系统功能</span>
					</a>
					<ul class="nav nav-sub dk">
						<li <?php if($class_active=='center') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/center/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>系统首页</span>
	                  		</a>
						</li>
	                  	<li <?php if($class_active=='set') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/set/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>店铺设置</span>
	                  		</a>
						</li>
						<li <?php if($class_active=='goods') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/goods/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>商品管理</span>
	                  		</a>
						</li>
						<li <?php if($class_active=='comment') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/comment/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>商品评价</span>
	                  		</a>
						</li>
						<li <?php if($class_active=='order') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/order/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>订单管理</span>
	                  		</a>
						</li>
						<li <?php if($class_active=='income') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/income/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>收益管理</span>
	                  		</a>
						</li>
						<li <?php if($class_active=='mall') echo 'class="active"';?>>
	                  		<a href="<?php echo site_url('shop/mall/index');?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i>
	                  			<span>商城二维码</span>
	                  		</a>
						</li>
	                </ul>
		        </li>
              <li class="line dk hidden-folded"></li>
			</ul>
			</nav>
			<!-- nav -->
		</div>
	</div>
</aside>


