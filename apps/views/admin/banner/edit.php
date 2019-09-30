<?php $data['definedcss'] = array(CSS_PATH.'fileinput/fileinput.min'); echo template('admin/header',$data);echo template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"> <a href="<?php echo $add_url;?>"><i class="fa fa-plus fa-fw"></i> 添加</a>&nbsp;&nbsp;&nbsp; <a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a>
					</span> <i class="fa fa-edit fa-fw"></i> 编辑
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">

						<div class="form-group">
							<label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 标题</label>
							<div class="col-sm-10">
								<input type="text" name="data[title]" class="form-control" placeholder="标题" value="<?php echo $item['title']?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 图片</label>
							<div class="col-sm-10">
								<input name="thumb" type="file" class="file file-one" data-bs='1'   data-initial-preview='<?php echo get_fileinput_initview($item['thumb']);?>'  data-initial-preview-config=<?php echo get_fileinput_initview($item['thumb'],true)?> /> 
								<input name="data[thumb]" id="thumburl-1" type="hidden" value="<?php echo $item['thumb']?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 内容摘要</label>
							<div class="col-sm-10">
								<textarea rows="2" cols="2" name="data[summary]" id="summary" class="form-control" placeholder="内容摘要"><?php echo $item['summary']?></textarea>
								<p class="help-block">
									<a href="javascript:void(0)" id="hqtext">从内容中获取摘要</a>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"> 说明</label>
							<div class="col-sm-10">
								<input type="text" name="data[mark]" class="form-control" placeholder="说明" value="<?php echo $item['mark']?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><i class="glyphicon glyphicon-asterisk"></i> 排序</label>
							<div class="col-sm-10">
								<input type="text" name="data[sort]" class="form-control" placeholder="说明" value="<?php echo $item['sort']?>">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $item['id']?>"> <a href="<?php echo site_url($edit_url)?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post","location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
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
var fileinput_edit = true;
</script>
<script src="<?php echo JS_PATH.'fileinput_common.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/fileinput.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/plugins/canvas-to-blob.min.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/locales/zh.js'?>"></script>
<?php echo template('admin/footer');?>