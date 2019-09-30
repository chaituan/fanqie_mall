<div id="crop-avatar">
	<form class="avatar-form" action="<?php echo site_url('images/crop');?>" enctype="multipart/form-data" method="post">
		<!-- Cropping modal -->
		<div class="modal fade" id="avatar-modal" data-backdrop="static" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="avatar-modal-label">修改头像</h4>
					</div>
					<div class="modal-body">
						<div class="avatar-body">
							<div class="avatar-upload">
								<label for="avatarInput"> <input type="hidden" class="avatar-src" name="avatar_src"> <input type="hidden" class="avatar-data" name="avatar_data"> <input type="file" class="avatar-input sr-only" id="avatarInput" name="avatar_file" accept="image/*" /> <span class="btn btn-primary " title="" data-toggle="tooltip">上传图片</span>
								</label>
							</div>
							<div class="avatar-wrapper center-black"></div>
							<div class="avatar-btns text-center">
								<button type="submit" class="btn btn-primary avatar-save">裁剪并提交</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- /.modal -->
	<!-- Loading state -->
	<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
</div>