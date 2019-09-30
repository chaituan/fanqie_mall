<div class="hr_70"></div>
<div class="weui-tab" style="bottom: 0;width: 100%;position: fixed;height: 0;z-index: 510;">
	<div class="weui-tabbar footer">
	                <a href="<?php echo site_url('mobile/news/index')?>" class="weui-tabbar__item">
	                    <span style="display: inline-block;position: relative;">
	                        <svg class="icon" aria-hidden="true"><use xlink:href="#icon-fanhui1"></use></svg>
	                         <?php if($cart_num){?><span class="weui-badge" style="position: absolute;top: -2px;right: -13px;"><?php echo $cart_num;?></span><?php }?>
	                    </span>
	                    <p class="weui-tabbar__label">返回</p>
	                </a>
	                <a id="message" class="weui-tabbar__item <?php if($action=='news')echo 'menu_select';?>">
	                    <svg class="icon" aria-hidden="true"><use xlink:href="#icon-liuyan"></use></svg>
	                    <p class="weui-tabbar__label">留言</p>
	                </a>
	                <a href="<?php echo site_url('mobile/mall/index')?>" class="weui-tabbar__item <?php if($action=='mall')echo 'menu_select';?>">
	                    <span style="display: inline-block;position: relative;">
	                        <svg class="icon" aria-hidden="true"><use xlink:href="#icon-dianpu"></use></svg>
	                    </span>
	                    <p class="weui-tabbar__label">商城</p>
	                </a>
	                
	</div>
</div>
<script src="<?php echo JS_PATH.'mobile/font/iconfont.js'?>"></script>
</div><!-- end container -->
</body>
</html>