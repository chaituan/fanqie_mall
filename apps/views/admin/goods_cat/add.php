<?php $data['definedcss'] = array(CSS_PATH.'fileinput/fileinput.min'); echo template('admin/header',$data);template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="alert alert-warning alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span><span class="sr-only">Close</span>
			</button>
			<strong>注：本系统只支持二级分类，添加多级不会显示，如需多级请联系客服开发</strong>
		</div>
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"> <i class="fa fa-arrow-circle-left fa-fw"></i> 返回
					</a> </span> <i class="fa fa-plus fa-fw"></i> 添加状态
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label"> 上级</label>
							<div class="col-sm-10">
								<select name="data[parent_id]" data-toggle="select" class="form-control select select-default" required>
									<option value="0">顶级</option>
                                	<?php foreach($parent as $v){?>
                                	<option value="<?php echo $v['id'];?>"> <?php echo str_repeat('├',$v['level']).' '.$v['names'];?></option>
                                	<?php }?>
                            </select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类名称</label>
							<div class="col-sm-10">
								<input type="text" name="data[names]" class="form-control" cname="分类名称" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类图片</label>
							<div class="col-sm-10">
								<input name="thumb" class="file file-one" type="file" data-bs='1' data-initial-preview-config='<?php echo get_fileinput_initview('',true)?>' /> <input name="data[thumb]" id="thumburl-1" type="hidden" />
								<p class="help_block">图片大小：(建议尺寸: 100*100或正方型图片)</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类广告图片</label>
							<div class="col-sm-10">
								<input name="thumbadv" class="file file-one" type="file" data-bs='2' /> <input name="data[thumbadv]" id="thumburl-2" type="hidden" />
								<p class="help_block">图片大小：(建议尺寸: 640*400px)</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类广告URL</label>
							<div class="col-sm-10">
								<input type="text" name="data[thumbadvurl]" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 分类描述</label>
							<div class="col-sm-10">
								<input type="text" name="data[description]" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 首页推荐</label>
							<div class="col-sm-10">
								<label class="i-checks"> <input type="radio" name="isrecommand" value="1"> <i></i> 是
								</label>&nbsp;&nbsp;&nbsp;&nbsp; <label class="i-checks"> <input type="radio" name="isrecommand" value="0" checked="checked"> <i></i> 否
								</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 是否显示</label>
							<div class="col-sm-10">
								<div class="radio">
									<label class="i-checks m-t-xs m-r"> <input type="radio" name="enabled" value="1" checked="checked"> <i></i> 是
									</label> <label class="i-checks m-t-xs m-r"> <input type="radio" name="enabled" value="0"> <i></i> 否
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 排序</label>
							<div class="col-sm-10">
								<input type="text" name="data[sort]" class="form-control" value="<?php echo $sort?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url($add_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post" ,"location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<script type="text/javascript">
var fileinput_edit = false;
</script>
<script src="<?php echo JS_PATH.'fileinput_common.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/fileinput.min.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/locales/zh.js'?>"></script>
<?php echo template('admin/footer');?>