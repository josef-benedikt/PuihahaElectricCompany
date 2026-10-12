<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

    <!-- Page Header Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-bolt text-warning me-2"></i>Puihaha Electric Portal
                    </h1>
                    <p class="lead">Sign in to access your account dashboard and manage your electricity services.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Form Section -->
    <section class="section-padding bg-light-custom">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <div class="card shadow-lg border-0 p-4">
                        <div class="card-body">

                            <div class="text-center mb-4">
                                <div class="feature-icon mb-3" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto;">
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <h3 class="text-primary-custom fw-bold">Customer & Admin Login</h3>
                                <p class="text-muted small">Please enter your credentials to proceed</p>
                            </div>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <form action="<?= base_url('login/authenticate'); ?>" method="POST" id="loginForm">
                                <?= csrf_field() ?>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= esc(old('email')) ?>" placeholder="name@example.com" required autofocus>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter password" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>Log In
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="text-muted">Don't have an account? <a href="<?= base_url('register') ?>" class="text-primary-custom fw-semibold text-decoration-none">Register here</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>