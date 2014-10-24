<form action="{{ $form['action'] }}" method="{{ $form['method'] }}">
	{{ Form::token() }}
	<div class="nav-tabs-custom">
	    <ul class="nav nav-tabs">
	        <li class="active"><a href="#tab_{{ $form['slug'] }}" data-toggle="tab">{{ $form['name'] }}</a></li>
			@foreach($form['forms'] as $f)
		        <li><a href="#tab_{{ $f['slug'] }}" data-toggle="tab">{{ $f['name'] }}</a></li>
			@endforeach
	    </ul>
	    
		<div class="tab-content">
	        <div class="tab-pane active" id="tab_{{ $form['name']}}">
	        	@foreach($form['fields'] as $name => $field)
	        	<div class="form-group">
                    <label class="control-label" for="{{ $name }}">{{ $field['label'] }}</label>
	        		{{ $field['html'] }}
                </div>
				@endforeach   
	        </div><!-- /.tab-pane -->
        @foreach($form['forms'] as $f)
	        <div class="tab-pane" id="tab_{{ $f['slug'] }}">
	        	@foreach($f['fields'] as $name => $field)
	        	<div class="form-group">
                    <label class="control-label" for="{{ $name }}">{{ $field['label'] }}</label>
	        		{{ $field['html'] }}
                </div>
				@endforeach   	        	
	        </div><!-- /.tab-pane -->
		@endforeach
	    </div>
	</div>
</form>
