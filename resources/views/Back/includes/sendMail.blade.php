<!-- Basic modal -->
<div id="view_send_mail_model" class="modal fade" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title" style="float: right;">@lang('backend.send-mail')</h5>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						{!! Form::open(['url'=>route('send-mail-post'),'method'=>'POST']) !!}
						<div class="form-group {{ $errors->first('to' , 'has-error') }}">
							<div class="form-valid floating">
								{!! Form::text('to',null,['placeholder'=>trans('backend.to'),'dir' => direction(),'class'=>'form-control wow fadeInUp form-data','id' =>'to']) !!}
								{!! $errors->first('to','<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
							</div>
						</div>
						<div class="form-group {{ $errors->first('subject' , 'has-error') }}">
							<div class="form-valid floating">
								{!! Form::text('subject',null,['placeholder'=>trans('backend.subject'),'dir' => direction(),'class'=>'form-control wow fadeInUp form-data','id' =>'subject']) !!}
								{!! $errors->first('subject','<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
							</div>
						</div>
						<div class="form-group {{ $errors->first('message' , 'has-error') }}">
							<div class="form-valid floating">
								{!! Form::textarea('message',null,['placeholder'=>trans('backend.message'),'dir' => direction(),'class'=>'form-control wow fadeInUp form-data','id' =>'message']) !!}
								{!! $errors->first('message','<div class="help-block text-right animated fadeInDown val-error">:message</div>') !!}
							</div>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-primary" style="float: {{ floating('right', 'left') }}" value="@lang('backend.send')">
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('backend.close')</button>
			</div>
		</div>
	</div>
</div>
<!-- /basic modal -->
