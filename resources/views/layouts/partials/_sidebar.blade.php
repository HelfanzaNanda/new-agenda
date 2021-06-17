<div class="app-sidebar sidebar-shadow">
	<div class="app-header__logo">
		<div class="logo-src"></div>
		<div class="header__pane ml-auto">
			<div>
				<button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</button>
			</div>
		</div>
	</div>
	<div class="app-header__mobile-menu">
		<div>
			<button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		</div>
	</div>
	<div class="app-header__menu">
		<span>
			<button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
				<span class="btn-icon-wrapper">
					<i class="fa fa-ellipsis-v fa-w-6"></i>
				</span>
			</button>
		</span>
	</div>    <div class="scrollbar-sidebar">
		<div class="app-sidebar__inner">
			<ul class="vertical-nav-menu">
				<li class="app-sidebar__heading">Dashboard</li>
				<li>
					<a href="{{ route('dashboard.index') }}" class="{{ request()->is('/') ? 'mm-active' : '' }}">
						<i class="metismenu-icon fas fa-home"></i>
						Dashboard
					</a>
				</li>
				<li class="app-sidebar__heading">Users</li>
				<li>
					<a href="{{ route('user.index') }}" class="{{ request()->is('users') ? 'mm-active' : '' }}">
						<i class="metismenu-icon fas fa-users"></i>
						Users
					</a>
				</li>
				<li class="app-sidebar__heading">Agenda</li>
				<li>
					<a href="{{ route('agenda.index') }}" class="{{ request()->is('agenda') ? 'mm-active' : '' }}">
						<i class="metismenu-icon fas fa-calendar"></i>
						Agenda
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>