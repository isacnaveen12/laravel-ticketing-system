<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Support Ticketing System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .hero-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
        }
        
        .brand-logo {
            font-size: 4rem;
            color: #667eea;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 40px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 50px;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            padding: 15px 40px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 50px;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
        }
        
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .particle {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
    </style>
</head>
<body>
    <!-- Floating Particles Background -->
    <div class="floating-particles">
        <div class="particle" style="left: 10%; width: 20px; height: 20px; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; width: 15px; height: 15px; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; width: 25px; height: 25px; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; width: 18px; height: 18px; animation-delay: 1s;"></div>
        <div class="particle" style="left: 50%; width: 22px; height: 22px; animation-delay: 3s;"></div>
        <div class="particle" style="left: 60%; width: 16px; height: 16px; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; width: 28px; height: 28px; animation-delay: 1.5s;"></div>
        <div class="particle" style="left: 80%; width: 14px; height: 14px; animation-delay: 3.5s;"></div>
        <div class="particle" style="left: 90%; width: 20px; height: 20px; animation-delay: 2.5s;"></div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-card text-center">
                        <div class="brand-logo mb-4">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h1 class="display-4 fw-bold mb-4">Support Ticketing System</h1>
                        <p class="lead mb-5 text-muted">
                            Get the help you need, when you need it. Our advanced ticketing system 
                            ensures your issues are tracked, prioritized, and resolved efficiently.
                        </p>
                        
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('customer.login') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-box-arrow-in-right"></i> Customer Login
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('customer.register') }}" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-person-plus"></i> Create Account
                                </a>
                            </div>
                        </div>
                        
                        <div class="row text-start">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>24/7 Support</strong><br>
                                        <small class="text-muted">Round-the-clock assistance</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-lightning-charge-fill text-warning me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>Fast Response</strong><br>
                                        <small class="text-muted">Quick resolution times</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check-fill text-primary me-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>Secure</strong><br>
                                        <small class="text-muted">Your data is protected</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" style="background: rgba(255,255,255,0.1);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="text-white fw-bold">Why Choose Our Support System?</h2>
                    <p class="text-white-50">Modern features designed for excellent customer experience</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                        <h4>Smart Ticketing</h4>
                        <p class="text-muted">
                            Intelligent ticket routing and prioritization ensures your issues 
                            reach the right person quickly.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h4>Real-time Updates</h4>
                        <p class="text-muted">
                            Stay informed with instant notifications and real-time status 
                            updates on your support requests.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4>Track Progress</h4>
                        <p class="text-muted">
                            Monitor your ticket status, view conversation history, and 
                            track resolution progress easily.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>
                        <h4>File Attachments</h4>
                        <p class="text-muted">
                            Easily attach screenshots, documents, and files to help our 
                            support team understand your issue better.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-device-ssd"></i>
                        </div>
                        <h4>Mobile Friendly</h4>
                        <p class="text-muted">
                            Access your support tickets from any device - desktop, tablet, 
                            or mobile phone with our responsive design.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4>Advanced Search</h4>
                        <p class="text-muted">
                            Find your tickets quickly with powerful search and filtering 
                            options by status, priority, and category.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white fw-bold mb-4">Ready to Get Started?</h2>
                    <p class="text-white-50 mb-4">
                        Join thousands of satisfied customers who trust our support system 
                        to resolve their issues quickly and efficiently.
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('customer.register') }}" class="btn btn-outline-light btn-lg w-100" style="border: 2px solid rgba(255,255,255,0.8); padding: 15px 40px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 50px;">
                                <i class="bi bi-person-plus"></i> Create Free Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4" style="background: rgba(0,0,0,0.2);">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        &copy; {{ date('Y') }} Support Ticketing System. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-white-50 mb-0">
                        Need help? <a href="mailto:support@example.com" class="text-white">Contact Support</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>