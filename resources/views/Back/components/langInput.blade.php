@if($type == 'text')
	<div class="form-group">
		<div class="{{ $class }}">
			<div class="form-valid">
				<label for="{{ $lang['locale'].'['.$name.']' }}">@lang($trans) ( @lang('back.'.$lang['locale']) )</label>
				{!! Form::text($lang['locale'].'['.$name.']',null,['class'=>'form-control form-data','id' => $lang['locale'].'['.$name.']', 'dir' => $lang['dir'] ]) !!}
            </div>
		</div>
	</div>
@else
	<div class="form-group">
		<div class="{{ $class }}">
			<div class="form-valid">
				<!-- CKEditor Container -->
				<label for="{{ $lang['locale'].'['.$name.']' }}">@lang($trans) ( @lang('back.'.$lang['locale']) )</label>

                @if($type == 'ckeditor')
                    <textarea class="form-data js-ckeditor" name="{{$lang['locale'].'['.$name.']'}}" id="{{$name}}{{$lang['locale']}}" rows="4" cols="4"></textarea>
                @else
                    {!!
                        Form::textarea($lang['locale'].'['.$name.']',null,[
                            'class' =>'form-control js-ckeditor form-data',
                            'id'   => $lang['locale'].'['.$name.']',
                            'style' => 'resize: vertical;',
                            'dir'  => $lang['dir']
                        ])
                    !!}
                @endif
			</div>
		</div>
	</div>
@endif
