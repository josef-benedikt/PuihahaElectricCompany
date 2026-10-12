<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Puihaha Electric Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px auto;
            max-width: 700px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-section h1 {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="main-container">
        <div class="header-section">
            <h1><i class="bi bi-pencil-square text-warning"></i> Edit Customer Account</h1>
            <p class="text-muted">Puihaha Electric Company Management</p>
        </div>

        <form method="POST" action="<?= base_url('admin/update/' . $account['id']) ?>">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Account Number *</label>
                    <input type="text" class="form-control" name="account_number" value="<?= esc($account['account_number']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Name *</label>
                    <input type="text" class="form-control" name="customer_name" value="<?= esc($account['customer_name']) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Address *</label>
                    <input type="text" class="form-control" name="address" value="<?= esc($account['address']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone Number *</label>
                    <input type="text" class="form-control" name="phone" value="<?= esc($account['phone']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Address *</label>
                    <input type="email" class="form-control" name="email" value="<?= esc($account['email']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Meter Number *</label>
                    <input type="text" class="form-control" name="meter_number" value="<?= esc($account['meter_number']) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Connection Type *</label>
                    <select class="form-select" name="connection_type" required>
                        <option value="residential" <?= $account['connection_type'] === 'residential' ? 'selected' : '' ?>>Residential</option>
                        <option value="commercial" <?= $account['connection_type'] === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                        <option value="industrial" <?= $account['connection_type'] === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="active" <?= $account['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $account['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="suspended" <?= $account['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>

                <div class="col-12 mt-4 text-center">
                    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle me-2"></i>Update Account</button>
                    <a href="<?= base_url('admin') ?>" class="btn btn-secondary px-4 ms-2"><i class="bi bi-arrow-left me-2"></i>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>