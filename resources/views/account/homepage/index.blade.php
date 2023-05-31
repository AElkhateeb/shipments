@extends('account.layout.front') @section('content')
<div class="col-lg-9 col-md-12">
	<div class="dashboard-wraper">
		<!-- Basic Information -->
		<div class="form-submit">
			<h4>My Dashbord</h4>
			<div class="submit-section">
				<div class="row">
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/profile') }}">{{ trans('brackets/admin-auth::admin.profile_dropdown.profile') }}</a></h4> <a href="{{ url('account/profile') }}" class="bl-continue">Edit</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/shipments') }}">{{ trans('admin.shipment.title') }}</a></h4> <a href="{{ url('account/shipments') }}" class="bl-continue">{{ trans('admin.shipment.actions.index') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/calculate') }}">{{ trans('admin.shipment.actions.create') }}</a></h4> <a href="{{ url('account/shipments') }}" class="bl-continue">{{ trans('admin.shipment.actions.create') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/track') }}">{{ trans('admin.shipment.actions.track') }}</a></h4> <a href="{{ url('account/shipments') }}" class="bl-continue">{{ trans('admin.shipment.actions.track') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/wallets') }}">{{ trans('admin.wallet.title') }}</a></h4> <a href="{{ url('account/profile') }}" class="bl-continue">{{ trans('admin.wallet.title') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/place') }}">{{ trans('admin.place.actions.create') }}</a></h4> <a href="{{ url('account/shipments') }}" class="bl-continue">{{ trans('admin.place.actions.create') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/transaction') }}">{{ trans('admin.transaction.title') }}</a></h4> <a href="{{ url('account/shipments') }}" class="bl-continue">{{ trans('admin.transaction.actions.index') }}</a> </div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12">
						<div class="blog-wrap-grid">
							<div class="blog-body">
								<h4 class="bl-title"><a href="{{ url('account/password') }}">{{ trans('brackets/admin-auth::admin.profile_dropdown.password') }}</a></h4> <a href="{{ url('account/password') }}" class="bl-continue">{{ trans('brackets/admin-auth::admin.profile_dropdown.password') }}</a> </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> @stop