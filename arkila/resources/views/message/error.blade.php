@if (count($errors) > 0)
@foreach ($errors->all() as $error)
    <script type="text/javascript">
		$.notify({
			// options
			icon: 'fa fa-warning',
			message: '{{ $error }}'
		},{
			// settings
			type: 'danger',
			delay: '999900',
			placement: {
				from: 'bottom',
				align: 'right'
			},
			icon_type: 'class',
			animate: {
				enter: 'animated bounceIn',
				exit: 'animated bounceOut'
			}
		});


	</script>

@endforeach
@endif
