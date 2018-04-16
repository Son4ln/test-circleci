<div class="row margin-bottom80">
	<div class="col-md-7">
		<div class="step-0-txt-box">
			<h1 id="request_job_0" class="bold create-title">@lang('projects.create.title')</h1>
			<p>@lang('projects.create.alert_1')</p>
			<br/>
			<p>※@lang('projects.create.alert_2')
				@lang('projects.create.alert_3')
			</p>
		</div>
	</div>

	<div class="col-md-5">
		<img src="/images/step0-bg.jpg" class="img-responsive" width="100%">
	</div>
</div>

<div class="white-back table-responsive clear-both">
<table class="table dataTable" id="request_form_table">
	<thead>
	<tr>
	<th class="color-white text-center background-60bfb3">@lang('projects.create.name')</th>
	<th class="color-white text-center background-60bfb3" width="25%">@lang('projects.create.self_compe')</th>
	<th class="color-white text-center background-027e7f" width="25%">@lang('projects.create.cert_creator')</th>
	<th class="color-white text-center background-60bfb3">@lang('projects.create.pm')</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<th class="tb-request-title background-4d4d4d">@lang('projects.create.characeristic')</th>
	<td>@lang('projects.create.characeristic_1')</td>
	<td class="backgound-ececec">@lang('projects.create.characeristic_2')</td>
	<td>@lang('projects.create.characeristic_3')</td>
	</tr>
	<tr>
	<th class="tb-request-title background-4d4d4d">@lang('projects.create.deposit')</th>
	<td class="backgound-ececec">@lang('projects.create.deposit_1')</td>
	<td class="background-dddada">@lang('projects.create.deposit_2')</td>
	<td class="backgound-ececec">@lang('projects.create.deposit_3')</td>
	</tr>
	<tr>
	<th class="tb-request-title background-4d4d4d">@lang('projects.create.budget')</th>
	<td>@lang('projects.create.budget_1')</td>
	<td class="backgound-ececec">@lang('projects.create.budget_2')</td>
	<td>@lang('projects.create.budget_3')</td>
	</tr>
	<tr>
	<th class="tb-request-title background-4d4d4d">@lang('projects.create.overview')</th>
	<td class="backgound-ececec">
		@lang('projects.create.overview_1')
	</td>
	<td class="background-dddada">
		@lang('projects.create.overview_2')
	</td>
	<td class="backgound-ececec">
		@lang('projects.create.overview_3')
	</td>
	</tr>
	<tr>
	<th class="tb-request-title background-4d4d4d">@lang('projects.create.case')</th>
	<td>@lang('projects.create.case_1')</td>
	<td class="backgound-ececec">@lang('projects.create.case_2')</td>
	<td>@lang('projects.create.case_3')</td>
	</tr>
	<tr>
	<th class="tb-request-title background-4d4d4d white-space-nowrap">@lang('projects.create.person')</th>
	<td class="backgound-ececec">@lang('projects.create.person_1')</td>
	<td class="background-dddada">
		@lang('projects.create.person_2')
	</td>
	<td class="backgound-ececec">
		@lang('projects.create.person_3')
	</td>
	</tr>
	<tr id="request_form">
		<td></td>
		<td>
			<center>
				<div class="selected_message" id="self_competition">@lang('projects.create.selected')</div>
				<a href="#request_job_1" class="scrollarrow-blue50">
				<span class="hidden">セルフコンペ</span>
				</a>
			</center>
		</td>
		<td>
			<center>
				<div class="selected_message" id="certified_creator">@lang('projects.create.selected')</div>
				<a href="#request_job_1" class="scrollarrow-blue50">
				<span class="hidden">認定クリエイター</span>
				</a>
			</center>
		</td>
	</tr>
	</tbody>
</table>
</div>{{-- ./white-back --}}

<!-- <ul class="inline-block nextlink" id="request_form">
<li class="width27">
	<div class="selected_message" id="self_competition">@lang('projects.create.selected')</div>
	<a href="#request_job_1" class="scrollarrow-blue50">
	<span class="hidden">セルフコンペ</span>
	</a>
</li>
<li class="width27">
	<div class="selected_message" id="certified_creator">@lang('projects.create.selected')</div>
	<a href="#request_job_1" class="scrollarrow-blue50">
	<span class="hidden">認定クリエイター</span>
	</a>
</li>
</ul> -->
