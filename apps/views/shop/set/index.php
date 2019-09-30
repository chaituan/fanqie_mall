<?php $data['definedcss'] = array(CSS_PATH.'fileinput/fileinput.min',JS_PATH.'jquery/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min'); echo template('shop/header',$data);echo template('shop/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<i class="fa fa-edit fa-fw"></i> 配置
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
					<div class="form-group">
							<label class="col-sm-2 control-label">店铺名字</label>
							<div class="col-sm-10">
								<input type="text" name="data[shop_name]" value="<?php echo $loginUser['shop_name']?>" max-length='6' cname='店铺名字' class="form-control" required>
								<p class="help_block">店铺名字最长6个汉字</p>
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
					<div class="form-group">
							<label class="col-sm-2 control-label">公司名字</label>
							<div class="col-sm-10">
								<input type="text" name="data[company]" value="<?php echo $loginUser['company']?>" cname='公司名字' max-length='18' class="form-control" required>
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
					<div class="form-group">
							<label class="col-sm-2 control-label"> 商品主图</label>
							<div class="col-sm-10">
								<?php if($loginUser['thumb']){?>
								<input name="thumb" type="file" class="file file-one" data-bs='1' data-max-image-width='120'  data-max-image-height='120'  data-initial-preview='<?php echo get_fileinput_initview($loginUser['thumb']);?>'  data-initial-preview-config=<?php echo get_fileinput_initview($loginUser['thumb'],true)?> /> 
								<input name="data[thumb]" id="thumburl-1" type="hidden" value="<?php echo $loginUser['thumb']?>" />
								<?php }else{?>
								<input name="thumb" type="file" class="file file-one" data-bs='1' data-max-image-width='120'  data-max-image-height='120'  /> 
								<input name="data[thumb]" id="thumburl-1" type="hidden" />
								<?php }?>
								<p class="help_block">图片大小：一定要是正方形，建议尺寸（100*100px）或其他正方形图片</p>
								
							</div>
					</div>
					<div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url('shop/set/edit')?>" class="btn btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post", "location":"reload"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('shop/script');?>
<script>
<?php if($loginUser['thumb']){?>
var fileinput_edit = true;
<?php }else{?>
var fileinput_edit = false;
<?php }?>
</script>
<script src="<?php echo JS_PATH.'fileinput_common.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/fileinput.min.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/plugins/canvas-to-blob.min.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/locales/zh.js'?>"></script>
<?php echo template('shop/footer');?>
