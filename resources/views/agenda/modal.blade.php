<style>
	.ui-timepicker-container {
		z-index: 3500 !important;
	}
</style>
<div class="modal fade" id="modal-agenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-agenda">
				@csrf
				<input type="hidden" name="id" id="input-id">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="name">Tanggal</label>
								<input type="text" name="date_range" id="input-date-range" class="form-control daterange">
								<x-validation-error id="error-date_range"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="start_time">Jam Mulai</label>
								<input type="text" name="start_time" id="input-start-time" class="form-control timepicker">
								<x-validation-error id="error-start_time"/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="start_time">Jam Selesai</label>
								<input type="text" name="end_time" id="input-end-time" class="form-control timepicker">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="check-end-time">
									<label class="form-check-label" for="check-end-time">
									  s.d Selesai
									</label>
								</div>
								<x-validation-error id="error-end_time"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="name">Kegiatan</label>
						<input type="text" name="name" id="input-name" class="form-control">
						<x-validation-error id="error-name"/>
					</div>

					<div class="form-group">
						<label for="place">Tempat</label>
						<input type="text" name="place" id="input-place" class="form-control">
						<x-validation-error id="error-place"/>
					</div>

					<div class="form-group">
						<label for="executor">Pelaksana Kegiatan</label>
						<input type="text" name="executor" id="input-executor" class="form-control">
						<x-validation-error id="error-executor"/>
					</div>

					<div class="form-group">
						<label for="file">File</label>
						<input type="file" name="file" id="input-file" class="form-control">
						<x-validation-error id="error-file"/>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn-save btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>