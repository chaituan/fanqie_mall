
<!-- aside -->
<aside id="aside" class="app-aside hidden-xs bg-dark">
	<div class="aside-wrap">
		<div class="navi-wrap">
			<!-- nav -->
			<nav ui-nav class="navi clearfix">
				<ul class="nav">
					<li class="line dk"></li>
              
              <?php
														$i = 0;
														foreach ( $__menuGroups as $key => $val ) {
															if (empty ( $systemMenu [$val ['tkey']] )) {
																continue;
															}
															?>
                <li <?php if($val['tkey'] == $mgroup || ($i == 0 && $mgroup=='')){ echo 'class="active"';}?>><a  class="auto"> <span class="pull-right text-muted"> <i class="fa fa-fw fa-angle-right text"></i> <i class="fa fa-fw fa-angle-down text-active"></i>
						</span> <i class="fa fa-<?php echo $val['icon']; ?>"></i> <span><?php echo $val['name']; ?></span>
					</a>

						<ul class="nav nav-sub dk">
		                  <?php  $k = $val['tkey']; foreach ($systemMenu["$k"] as $keys=>$group){    ?>
		                  <li class="nav-sub-header"><a href="#"> <span><?php echo $group['name']; ?></span>
							</a></li>
		                  <?php foreach($group['sub'] as $v){?>
		                  <li <?php if($v['url']==$currentOpt || $mid==$v['id']){ echo 'class="active"';}?>><a href="<?php echo site_url($v['url'].'/m-'.$v['id'])?>" style="padding-left: 40px;"> <i class="fa fa-fw fa-circle-o" style="width: 20px; font-size: 10px;"></i><span><?php echo $v['name']; ?></span>
							</a></li>
		                  <?php }}?>
		                </ul></li>
             <?php $i++;}?>
              <li class="line dk hidden-folded"></li>
				</ul>
			</nav>
			<!-- nav -->
		</div>
	</div>
</aside>


