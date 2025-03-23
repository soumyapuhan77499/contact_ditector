<!-- main-sidebar -->
<div class="sticky">
	<aside class="app-sidebar">
		<div class="main-sidebar-header active">
			<a class="header-logo active" href="{{url('admin/dashboard')}}">
				<img style="margin-top: -80px;width: 200px;height: 200px" src="{{asset('assets/img/brand/jagannath.png')}}" class="main-logo desktop-logo" alt="logo">
				<img src="{{asset('assets/img/brand/nijoga.png')}}" class="main-logo desktop-dark" alt="logo">
				<img src="{{asset('assets/img/brand/nijoga.png')}}" class="main-logo mobile-logo" alt="logo">
				<img src="{{asset('assets/img/brand/nijoga.png')}}" class="main-logo mobile-dark" alt="logo">
			</a>
		</div>

		<div class="main-sidemenu">
			<div class="slide-left disabled" id="slide-left">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
					<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/>
				</svg>
			</div>

			<ul class="side-menu">

				<!-- ❌ Disabled menu item -->
				<li class="slide">
					<a class="side-menu__item disabled-link" href="javascript:void(0);" title="This section is disabled">
						<i class="fas fa-ban" style="color: #999; margin-right: 10px;"></i>
						<span class="side-menu__label">CONTACT DITECTOR</span>
					</a>
				</li>
			
				<!-- ✅ Dashboard -->
				<li class="slide">
					<a class="side-menu__item" href="{{url('/')}}">
						<i class="fas fa-home" style="color: #007bff; margin-right: 10px;"></i>
						<span class="side-menu__label">Dashboard</span>
					</a>
				</li>
			
				<!-- ✅ Manage Contact -->
				<li class="slide">
					<a class="side-menu__item" href="{{url('admin/manage-contact')}}">
						<i class="fas fa-address-book" style="color: #28a745; margin-right: 10px;"></i>
						<span class="side-menu__label">Contact</span>
					</a>
				</li>
			
				<!-- ✅ Assign Group -->
				<li class="slide">
					<a class="side-menu__item" href="{{url('admin/assign-group')}}">
						<i class="fas fa-user-plus" style="color: #17a2b8; margin-right: 10px;"></i>
						<span class="side-menu__label">Assign Group</span>
					</a>
				</li>
			
				<!-- ✅ Manage Assign Group -->
				<li class="slide">
					<a class="side-menu__item" href="{{url('admin/manage-assign-group')}}">
						<i class="fas fa-users-cog" style="color: #ffc107; margin-right: 10px;"></i>
						<span class="side-menu__label">Groups</span>
					</a>
				</li>
			
				<!-- ✅ Manage Group -->
				<li class="slide">
					<a class="side-menu__item" href="{{url('admin/manage-group')}}">
						<i class="fas fa-layer-group" style="color: #6610f2; margin-right: 10px;"></i>
						<span class="side-menu__label">Manage Group</span>
					</a>
				</li>

					<!-- ✅ Manage Group -->
					<li class="slide">
						<a class="side-menu__item" href="{{url('/yatri/list')}}">
							<i class="fas fa-user" style="color: #075a2b; margin-right: 10px;"></i>
							<span class="side-menu__label"> Yatri</span>
						</a>
					</li>
			
			</ul>
			

			<div class="slide-right" id="slide-right">
				<svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
					<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/>
				</svg>
			</div>
		</div>
	</aside>
</div>
<!-- main-sidebar -->
