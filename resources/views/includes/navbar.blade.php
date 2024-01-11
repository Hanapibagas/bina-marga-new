<div class="iq-top-navbar header-top-sticky">
    <div class="iq-navbar-custom">
        {{-- <div class="iq-sidebar-logo">
            <div class="top-logo">
                <a href="index.html" class="logo">
                    <img src="images/logo.png" class="img-fluid" alt="">
                    <span>XRay</span>
                </a>
            </div>
        </div> --}}
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-search-bar">
                <form action="#" class="searchbox">
                    <input type="text" class="text search-input" id="search-input" placeholder="Cari data anda">
                    <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                </form>
            </div>
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-more-fill"></i></div>
                    <div class="hover-circle"><i class="ri-more-2-fill"></i></div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">
                    <li class="nav-item iq-full-scree   n">
                        <a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-list">
                <li>
                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                        @if (Auth::check() && Auth::user()->picture)
                        <img style="margin-right: 10px;" src="{{ Storage::url($user->picture) }}" width="40"
                            class="rounded-circle">
                        @else
                        <img style="margin-right: 10px;" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                            width="40" class="rounded-circle" />
                        @endif
                        <div class="caption">
                            <h6 class="mb-0 line-height"> {{ Auth::user()->name }}</h6>
                        </div>
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hallo {{ Auth::user()->name
                                        }}</h5>
                                </div>
                                {{-- <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-file-user-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">My Profile</h6>
                                            <p class="mb-0 font-size-12">View personal profile details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-profile-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Edit Profile</h6>
                                            <p class="mb-0 font-size-12">Modify your personal details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-account-box-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Account settings</h6>
                                            <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-lock-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Privacy Settings</h6>
                                            <p class="mb-0 font-size-12">Control your privacy parameters.
                                            </p>
                                        </div>
                                    </div>
                                </a> --}}
                                <div class="d-inline-block w-100 text-center p-3">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="bg-primary iq-sign-btn" type="submit">
                                            <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                            Sign out <i class="ri-login-box-line ml-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>