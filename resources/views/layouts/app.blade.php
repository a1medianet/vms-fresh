<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('VMS-Fresh'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        [dir="rtl"] {
            direction: rtl;
            text-align: right;
        }
        [dir="ltr"] {
            direction: ltr;
            text-align: left;
        }
        .sidebar {
            min-height: 100vh;
            background: #f8f9fa;
        }
        .main-content {
            min-height: 100vh;
        }
    </style>
    @stack('styles')
</head>
<body>
    @auth
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <h5 class="px-3">{{ __('VMS-Fresh') }}</h5>
                        <hr>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}
                                </a>
                            </li>
                            @can('manage_users')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                                    <i class="bi bi-people"></i> {{ __('Users') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.roles.index') }}">
                                    <i class="bi bi-shield-check"></i> {{ __('Roles') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.permissions.index') }}">
                                    <i class="bi bi-key"></i> {{ __('Permissions') }}
                                </a>
                            </li>
                            @endcan
                            @can('manage_prearrival')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.pre-arrival.index') }}">
                                    <i class="bi bi-calendar-check"></i> {{ __('Pre-Arrival') }}
                                </a>
                            </li>
                            @endcan
                            @can('manage_visitors')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.visitors.index') }}">
                                    <i class="bi bi-person-badge"></i> {{ __('Visitors') }}
                                </a>
                            </li>
                            @endcan
                            @can('manage_housing')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.housing.buildings') }}">
                                    <i class="bi bi-building"></i> {{ __('Housing') }}
                                </a>
                            </li>
                            @endcan
                            @can('view_reports')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.reports.index') }}">
                                    <i class="bi bi-graph-up"></i> {{ __('Reports') }}
                                </a>
                            </li>
                            @endcan
                            @can('import_export')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard.import-export.index') }}">
                                    <i class="bi bi-upload"></i> {{ __('Import/Export') }}
                                </a>
                            </li>
                            @endcan
                        </ul>
                        <hr>
                        <div class="px-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('page-title', __('Dashboard'))</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <select class="form-select form-select-sm" onchange="window.location.href='?lang='+this.value">
                                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>العربية</option>
                                    <option value="it" {{ app()->getLocale() === 'it' ? 'selected' : '' }}>Italiano</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
