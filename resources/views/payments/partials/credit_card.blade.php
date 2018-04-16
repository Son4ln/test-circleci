{{--
// Usage:
@component('payments.partials.credit_card', [
'action' => 'http://example.com/subcribe',
'method' => 'POST',
'submit' => 'Subcribe',
'allowCoupon' => true,
])
<input type="hidden" name="plan" value="{{ $plan->id }}">
@endcomponent
--}}

{!! Form::open([
'url'    => $action,
'method' => $method ?? 'POST',
'class'  => 'form',
'id'     => 'payment-form',
'role'   => 'form',
'data-parsley-validate',
]) !!}

<div class="form-group control-required row card__number">
<div class="col-xs-12">
	<label class="control-label">@lang('projects.show.credit_number')</label>
	{!! Form::text(null, null, [
	'class'                      => 'form-control',
	'required'                   => true,
	'autocomplete'               => 'off',
	'maxlength'                  => 16,
	'data-stripe'                => 'number',
	'data-parsley-type'          => 'number',
	'data-parsley-trigger'       => 'change focusout',
	'data-parsley-class-handler' => '.card__number',
	]) !!}
</div>
</div>

<div class="row">
<div class="col-xs-4">
	<div class="form-group control-required card__cvc">
	<label class="control-label">@lang('projects.show.security_code')</label>
	{!! Form::text(null, null, [
		'class'                      => 'form-control',
		'required'                   => true,
		'autocomplete'               => 'off',
		'maxlength'                  => 4,
		'data-stripe'                => 'cvc',
		'data-parsley-type'          => 'number',
		'data-parsley-trigger'       => 'change focusout',
		'data-parsley-class-handler' => '.card__cvc',
	]) !!}
	</div>
</div>
<div class="col-xs-4 card_">
	<div class="form-group control-required card__month">
	<label class="control-label">@lang('projects.show.expiration_month')</label>
	{!! Form::selectMonth(null, null, [
		'class'                      => 'form-control',
		'required'                   => true,
		'placeholder'                => 'MM',
		'data-stripe'                => 'exp-month',
		'data-parsley-type'          => 'number',
		'data-parsley-trigger'       => 'change focusout',
		'data-parsley-class-handler' => '.card__month',
	], '%m') !!}
	</div>
</div>
<div class="col-xs-4">
	<div class="form-group control-required card__year">
	<label class="control-label">@lang('projects.show.expiration_year')</label>
	{!! Form::selectYear(null, date('Y'), date('Y') + 20, null, [
		'class'                      => 'form-control',
		'required'                   => true,
		'placeholder'                => 'YYYY',
		'data-stripe'                => 'exp-year',
		'data-parsley-type'          => 'number',
		'data-parsley-trigger'       => 'change focusout',
		'data-parsley-class-handler' => '.card__year',
	]) !!}
	</div>
</div>
</div>

@if ($allowCoupon or false)
<div class="form-group margin-top5 row card__coupon">
	<label class="col-xs-6 control-label text-right">@lang('projects.show.coupon_code')</label>
	<div class="col-xs-6">
	{!! Form::text('coupon', null, [
		'class'                      => 'form-control',
		'data-parsley-pattern'       => '/^[a-zA-Z0-9]*$/',
		'data-parsley-minlength'     => '3',
		'data-parsley-maxlength'     => '12',
		'data-parsley-trigger'       => 'change focusout',
		'data-parsley-class-handler' => '.card__coupon',
	]) !!}
	</div>
</div>
@endif

{{ $slot }}

<div class="form-group row">
<div class="col-xs-12 margin-top5">
	{!! Form::hidden('token') !!}
	{!! Form::submit($submit ?? 'Pay', ['class' => 'btn background-229393 color-white color-white-hover btn-lg btn-block']) !!}
</div>
</div>

<div class="alert alert-danger hidden">
<p><strong>エラー: </strong><span id="payment-errors"></span></p>
</div>
{!! Form::close() !!}

@push('scripts')
<script src="//js.stripe.com/v2/"
	data-locale="ja"></script>
<script>
	window.ParsleyConfig = {
	errorsWrapper: '<div class="help-block"></div>',
	errorTemplate: '<p></p>',
	errorClass: 'has-error',
	successClass: 'has-success'
	};
</script>
<script src="{{ asset('adminlte/plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/parsley/i18n/ja.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function () {
	// Initial Stripe
	Stripe.setPublishableKey("{{ config('services.stripe.key') }}");

	var $form = $('#payment-form');
	var $error = $('#payment-errors');

	var errorMessages = {
		incorrect_number: '@lang('projects.show.errors.incorrect_number')',
		invalid_number: '@lang('projects.show.errors.invalid_number')',
		invalid_expiry_month: '@lang('projects.show.errors.invalid_expiry_month')',
		invalid_expiry_year: '@lang('projects.show.errors.invalid_expiry_year')',
		invalid_cvc: '@lang('projects.show.errors.invalid_cvc')',
		expired_card: '@lang('projects.show.errors.expired_card')',
		incorrect_cvc: '@lang('projects.show.errors.incorrect_cvc')',
		incorrect_zip: '@lang('projects.show.errors.incorrect_zip')',
		card_declined: '@lang('projects.show.errors.card_declined')',
		missing: '@lang('projects.show.errors.missing')',
		processing_error: '@lang('projects.show.errors.processing_error')',
		rate_limit: '@lang('projects.show.errors.rate_limit')'
	};

	function stripeResponseHandler(status, response) {
		if (response.error) {
		// Problem!
		// Show the errors on the form:
		if (response.error.type == 'card_error') {
			$error.text(errorMessages[response.error.code]).parents('.alert').removeClass('hidden');
		} else {
			$error.text(response.error.message).parents('.alert').removeClass('hidden');
		}
		// Re-enable submission
		$form.find('input[type="submit"]').prop('disabled', false);

		} else {
		// Token was created!
		// Insert the token ID into the form so it gets submitted to the server:
		$form.find('input[name="token"]').val(response.id);

		// Submit the form:
		$form.get(0).submit();
		}
	}

	$form.on('submit', function (e) {
		e.preventDefault();

		// Before passing data to Stripe, trigger Parsley Client side validation
		$form.parsley().subscribe('parsley:form:validate', function (formInstance) {
		this.validationResult = false;
		return false;
		});

		// Disable the submit button to prevent repeated clicks:
		$form.find('input[type="submit"]').prop('disabled', true);

		// Hide old the errors on the form:
		$error.parents('.alert').addClass('hidden');
		// Request a token from Stripe:
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:
		return false;
	});

	});
</script>
@endpush

@push('styles')
<style>
.control-required label::after {
	content: '*';
	color: red;
	margin-left: 0.3em;
}
</style>
@endpush
