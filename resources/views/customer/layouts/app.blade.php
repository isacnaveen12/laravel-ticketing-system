<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Portal') - {{ config('app.name', 'Ticketing System') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
        .status-badge {
            font-size: 0.8rem;
        }
        .priority-badge {
            font-size: 0.8rem;
        }
        .ticket-card {
            transition: transform 0.2s;
        }
        .ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card .card-body {
            padding: 1.5rem;
        }
        .attachment-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .file-drop-zone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 40px;
            transition: border-color 0.3s;
        }
        .file-drop-zone.dragover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <i class="bi bi-headset"></i> Support Portal
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                           href="{{ route('customer.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.tickets.*') ? 'active' : '' }}" 
                           href="{{ route('customer.tickets.index') }}">
                            <i class="bi bi-ticket-perforated"></i> My Tickets
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (hidden on mobile, visible on larger screens) -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" 
                               href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.tickets.index') ? 'active' : '' }}" 
                               href="{{ route('customer.tickets.index') }}">
                                <i class="bi bi-list-ul"></i> All Tickets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customer.tickets.create') ? 'active' : '' }}" 
                               href="{{ route('customer.tickets.create') }}">
                                <i class="bi bi-plus-circle"></i> Create Ticket
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3">
                    @include('customer.partials.alerts')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // File drop zone functionality
        document.addEventListener('DOMContentLoaded', function() {
            const dropZone = document.querySelector('.file-drop-zone');
            const fileInput = document.querySelector('#attachments');
            
            if (dropZone && fileInput) {
                dropZone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    dropZone.classList.add('dragover');
                });
                
                dropZone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    dropZone.classList.remove('dragover');
                });
                
                dropZone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    dropZone.classList.remove('dragover');
                    fileInput.files = e.dataTransfer.files;
                    updateFileList();
                });
                
                dropZone.addEventListener('click', function() {
                    fileInput.click();
                });
                
                fileInput.addEventListener('change', updateFileList);
            }
            
            function updateFileList() {
                const fileList = document.querySelector('#file-list');
                if (fileList && fileInput.files.length > 0) {
                    let html = '<h6>Selected Files:</h6><ul class="list-group">';
                    for (let i = 0; i < fileInput.files.length; i++) {
                        const file = fileInput.files[i];
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-file-earmark"></i> ${file.name}</span>
                            <span class="badge bg-secondary">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        </li>`;
                    }
                    html += '</ul>';
                    fileList.innerHTML = html;
                }
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>