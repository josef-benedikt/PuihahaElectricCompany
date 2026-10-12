<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electric Company - Customer Accounts</title>
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
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-section h1 {
            color: #667eea;
            font-weight: bold;
        }
        .stats-card {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
        }
        .stats-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }
        .stats-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .card-total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-active { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .card-inactive { background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); }
        .card-suspended { background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%); }
        .search-filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .table-container {
            overflow-x: auto;
        }
        .badge-active { background-color: #28a745; }
        .badge-inactive { background-color: #dc3545; }
        .badge-suspended { background-color: #ffc107; color: #000; }
        .pagination {
            margin-top: 20px;
        }
        .pagination a,
        .pagination span {
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="main-container">

        <!-- Header Section -->
        <div class="header-section">
            <h1><i class="bi bi-lightning-charge-fill text-warning"></i> Puihaha Electric Company</h1>
            <p class="text-muted">Customer Account Management System</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card card-total">
                    <h3><?= $total_accounts ?? 0 ?></h3>
                    <p>Total Accounts</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card-active">
                    <h3><?= $active_accounts ?? 0 ?></h3>
                    <p>Active Accounts</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card-inactive">
                    <h3><?= $inactive_accounts ?? 0 ?></h3>
                    <p>Inactive Accounts</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card card-suspended">
                    <h3><?= $suspended_accounts ?? 0 ?></h3>
                    <p>Suspended Accounts</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <form method="GET" action="<?= base_url('admin') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="Search by name, account, email, phone..." value="<?= esc($search_keyword ?? '') ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="active" <?= ($filter_status ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($filter_status ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= ($filter_status ?? '') == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= base_url('admin') ?>" class="btn btn-secondary w-100"><i class="bi bi-arrow-counterclockwise"></i> Reset Filters</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- CRUD Action Header & Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="<?= base_url('admin/create') ?>" class="btn btn-success me-2"><i class="bi bi-plus-circle me-1"></i> Add New Account</a>
                <!-- Back to Main Homepage Button -->
                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary"><i class="bi bi-house-door-fill me-1"></i> Back to Homepage</a>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>Account #</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Contact Info</th>
                    <th>Meter / Type</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($accounts)): ?>
                    <?php foreach ($accounts as $acc): ?>
                        <tr>
                            <td><strong><?= esc($acc['account_number']) ?></strong></td>
                            <td><?= esc($acc['customer_name']) ?></td>
                            <td><?= esc($acc['address']) ?></td>
                            <td>
                                <div><i class="bi bi-telephone text-muted"></i> <?= esc($acc['phone']) ?></div>
                                <div><i class="bi bi-envelope text-muted"></i> <?= esc($acc['email']) ?></div>
                            </td>
                            <td>
                                <div><?= esc($acc['meter_number']) ?></div>
                                <span class="badge bg-secondary"><?= ucfirst(esc($acc['connection_type'])) ?></span>
                            </td>
                            <td>
                                <?php $badgeClass = 'badge-' . esc($acc['status']); ?>
                                <span class="badge <?= $badgeClass ?> fs-6"><?= ucfirst(esc($acc['status'])) ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/edit/' . $acc['id']) ?>" class="btn btn-sm btn-primary" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                <a href="<?= base_url('admin/delete/' . $acc['id']) ?>" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this customer account?');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No customer accounts found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <div class="d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>