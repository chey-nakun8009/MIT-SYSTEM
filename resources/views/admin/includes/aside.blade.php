<aside class="admin-sidebar" id="admin-sidebar">
    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-graph-up"></i>
                        <span>ផ្ទាងគ្រប់គ្រង</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                        href="{{ route('categories.index') }}">
                        <i class="bi bi-grid"></i>
                        <span>ប្រភេទផលិតផល</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}"
                        href="{{ route('brands.index') }}">
                        <i class="bi bi-award"></i>
                        <span>ម៉ាកផលិតផល</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}"
                        href="{{ route('units.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span>ឯកតាទំនិញ</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                        <i class="bi bi-box"></i>
                        <span>ផលិតផល</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory-transactions.*') ? 'active' : '' }}"
                        href="{{ route('inventory-transactions.index') }}">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                        <span>នាំចូលផលិតផល</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock"></i>
                        <span>Roles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-people"></i>
                        <span>អ្នកប្រើប្រាស់</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports', 'reports.*', 'orders.index') ? 'active' : '' }}"
                        href="{{ route('reports') }}">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                        <span>របាយការណ៍</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('campuses.*') ? 'active' : '' }}"
                        href="{{ route('campuses.index') }}">
                        <i class="bi bi-building"></i>
                        <span>កំណត់សាខា</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('system-settings.*') ? 'active' : '' }}"
                        href="{{ route('system-settings.index') }}">
                        <i class="bi bi-tools"></i>
                        <span>System settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['expense_revenue_category_index', 'expense-categories.*', 'revenue-categories.*']) ? 'active' : '' }}"
                        href="{{ route('expense_revenue_category_index') }}">
                        <i class="bi bi-people"></i>
                        <span>ប្រភេទចំណូលចំណាយ</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
