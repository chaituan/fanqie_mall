<?php $data['definedcss'] = array(CSS_PATH.'fileinput/fileinput.min'); echo template('admin/header',$data); echo template('admin/sider');?>

<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a></span> <i class="fa fa-plus fa-fw"></i> 添加
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="form-group">
							<label class="col-sm-2 control-label">文章分组</label>
							<div class="col-sm-10">
								<select name="data[catid]" data-toggle="select" id="menu-group-select" class="form-control select select-default">
					            <?php foreach ($cat as $v){?>
					            	<option value="<?php echo $v['id'];?>"> <?php echo str_repeat('├',$v['level']).' '.$v['catname'];?></option>
					            <?php }?>
					        </select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">文章标题</label>
							<div class="col-sm-10">
								<input type="text" name="data[title]" class="form-control" placeholder="文章标题" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">购买链接</label>
							<div class="col-sm-10">
								<input type="text" name="data[buy_url]" class="form-control" placeholder="购买链接" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">文章图片</label>
							<div class="col-sm-10">
								<input name="thumb" id="file-zh" class="file" type="file" multiple data-min-file-count="1" /> <input name="data[thumb]" id="thumb" type="hidden" />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">文章内容</label>
							<div class="col-sm-10">
								<script type="text/plain" id="editor" style="width: 100%; height: 500px;" name="data[content]">
							</script>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">内容摘要</label>
							<div class="col-sm-10">
								<textarea rows="2" cols="2" name="data[summary]" id="summary" class="form-control" placeholder="内容摘要"></textarea>
								<p class="help-block">
									<a href="javascript:void(0)" id="hqtext">从内容中获取摘要</a>
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">位置</label>
							<div class="col-sm-10">
								<div class="radio">
									<label class="i-checks"> <input type="radio" name="state" value="1"> <i></i> 热点推荐
									</label>&nbsp;&nbsp;&nbsp;&nbsp; <label class="i-checks"> <input type="radio" name="state" value="2"> <i></i> 首页推荐
									</label>&nbsp;&nbsp;&nbsp;&nbsp; <label class="i-checks"> <input type="radio" name="state" value="0" checked="checked"> <i></i> 无
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">访问量</label>
							<div class="col-sm-10">
								<input type="text" name="data[hits]" class="form-control" placeholder="访问量" value="0" dtype='number'>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<a href="<?php echo site_url($add_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post","location":"<?php echo site_url($index_url)?>"}'>保存修改</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo '/res/plugin/ueditor/ueditor.config.js'?>"></script>
<script src="<?php echo '/res/plugin/ueditor/ueditor.all.min.js'?>"></script>
<script src="<?php echo '/res/plugin/ueditor/lang/zh-cn/zh-cn.js'?>"></script>
<?php echo template('admin/script');?>
<script type="text/javascript">
$(function(){
	 $('#file-zh').fileinput({
		 	uploadUrl:"<?php echo site_url('images/upload');?>",
	        language: 'zh',
	        allowedFileExtensions : ['jpg', 'png','gif'],
	        resizeImage: true,
	        maxImageWidth: 200,
	        maxImageHeight: 200,
	        resizePreference: 'width'
	    }).on("fileuploaded",function(event, data){
	    	if(data.response.state==1){
	    		$('#thumb').val('/'+data.response.data.url);
		    }
		});
	    //延迟1秒初始化编辑器
	  setTimeout(function(){
		  var ue = UE.getEditor('editor');
		  $("#hqtext").click(function(){
		    	$("#summary").val($.trim(ue.getContentTxt().substr(0,100))+'...');
		   });
 		},1000);
	 
    
});
</script>

<script src="<?php echo JS_PATH.'fileinput/plugins/canvas-to-blob.min.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/fileinput.js'?>"></script>
<script src="<?php echo JS_PATH.'fileinput/locales/zh.js'?>"></script>

<?php echo template('admin/footer');?>