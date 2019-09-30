<?php  echo template('admin/header');template('admin/sider');?>
<div id="content" class="app-content" role="main">
	<div class="app-content-body ">
		<div class="wrapper-md">
			<div class="panel panel-default">
				<div class="panel-heading font-bold">
					<span class="pull-right"><a href="<?php echo $index_url;?>"><i class="fa fa-arrow-circle-left fa-fw"></i> 返回</a></span> <i class="fa fa-edit fa-fw"></i> 发货
				</div>
				<div class="panel-body">
					<form class="form-horizontal" autocomplete="off" id="content_add_form">
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 快递公司</label>
							<div class="col-sm-10">
								<input type="text" name="data[exp_company]" class="form-control" cname="名称" value="<?php echo $item['names'];?>" required>
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> 快递单号</label>
							<div class="col-sm-10">
								<input type="text" name="data[exp_no]" class="form-control" value="<?php echo $item['code'];?>">
							</div>
						</div>
						<div class="line line-dashed b-b line-lg pull-in"></div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="hidden" name="id" value="<?php echo $items['item']['ids']?>">
								<a href="<?php echo site_url($edit_url)?>" class="btn btn-sm btn-primary ajaxproxy" data-loading-text="正在提交……" proxy='{"formId":"content_add_form", "method":"post" ,"location":"<?php echo site_url($index_url)?>"}'>发货</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template('admin/script');?>
<?php echo template('admin/footer');?>