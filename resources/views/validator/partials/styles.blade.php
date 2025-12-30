<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background: #f1f5f9;
        min-height: 100vh;
    }
    
    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: linear-gradient(180deg, #1e3a5f 0%, #152a45 100%);
        padding: 24px 16px;
        overflow-y: auto;
        z-index: 100;
    }
    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 8px 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 24px;
    }
    .sidebar-logo-icon {
        width: 40px;
        height: 40px;
        background: #f97316;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sidebar-logo-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }
    .sidebar-logo-text {
        color: white;
        font-size: 20px;
        font-weight: 700;
    }
    .sidebar-logo-text span {
        color: #f97316;
    }
    .sidebar-section {
        margin-bottom: 24px;
    }
    .sidebar-section-title {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0 12px;
        margin-bottom: 8px;
    }
    .sidebar-nav {
        list-style: none;
    }
    .sidebar-nav-item {
        margin-bottom: 4px;
    }
    .sidebar-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        color: #cbd5e1;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .sidebar-nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: white;
    }
    .sidebar-nav-link.active {
        background: rgba(249, 115, 22, 0.2);
        color: #f97316;
    }
    .sidebar-nav-link svg {
        width: 20px;
        height: 20px;
    }
    .sidebar-nav-badge {
        margin-left: auto;
        background: #ef4444;
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .sidebar-nav-link.active .sidebar-nav-badge {
        background: #f97316;
    }
    .sidebar-footer {
        margin-top: auto;
        padding-top: 24px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        min-height: 100vh;
    }
    .header {
        background: white;
        padding: 16px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 50;
    }
    .header-title {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }
    .header-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-user-info {
        text-align: right;
    }
    .header-user-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .header-user-role {
        font-size: 12px;
        color: #64748b;
    }
    .header-user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
    }

    /* Content */
    .content {
        padding: 24px 32px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-card-icon svg {
        width: 24px;
        height: 24px;
        color: white;
    }
    .stat-card-icon.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .stat-card-icon.verified {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .stat-card-icon.rejected {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    .stat-card-icon.sellers {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }
    .stat-card-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
    }
    .stat-card-label {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Sections */
    .section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
    }
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }
    .section-link {
        color: #f97316;
        font-size: 14px;
        text-decoration: none;
        font-weight: 500;
    }
    .section-link:hover {
        text-decoration: underline;
    }

    /* Table */
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th,
    .table td {
        padding: 14px 16px;
        text-align: left;
    }
    .table th {
        background: #f8fafc;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table th:first-child {
        border-radius: 8px 0 0 8px;
    }
    .table th:last-child {
        border-radius: 0 8px 8px 0;
    }
    .table td {
        font-size: 14px;
        color: #475569;
        border-bottom: 1px solid #f1f5f9;
    }
    .table tr:last-child td {
        border-bottom: none;
    }
    .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .product-image {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: #f3f4f6;
    }
    .product-name {
        font-weight: 500;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .product-category {
        font-size: 12px;
        color: #94a3b8;
    }
    .seller-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .seller-avatar {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 11px;
        font-weight: 600;
    }

    /* Action Buttons */
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .action-btn svg {
        width: 18px;
        height: 18px;
    }
    .action-btn.view {
        background: #e0f2fe;
        color: #0284c7;
    }
    .action-btn.view:hover {
        background: #0284c7;
        color: white;
    }
    .action-btn.approve {
        background: #d1fae5;
        color: #059669;
    }
    .action-btn.approve:hover {
        background: #059669;
        color: white;
    }
    .action-btn.reject {
        background: #fee2e2;
        color: #dc2626;
    }
    .action-btn.reject:hover {
        background: #dc2626;
        color: white;
    }

    /* Alert */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #64748b;
    }
    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }
    .empty-state p {
        font-size: 14px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    .pagination-wrapper nav {
        display: flex;
        gap: 4px;
    }
    .pagination-wrapper a,
    .pagination-wrapper span {
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 14px;
        text-decoration: none;
    }
    .pagination-wrapper a {
        background: white;
        color: #475569;
        border: 1px solid #e5e7eb;
    }
    .pagination-wrapper a:hover {
        background: #f8fafc;
    }
    .pagination-wrapper span.current {
        background: #1e3a5f;
        color: white;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        .main-content {
            margin-left: 0;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
