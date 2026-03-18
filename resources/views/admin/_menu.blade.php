<div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
    <a href="{{ route('admin.dashboard') }}" class="btn-admin">Dashboard</a>
    <a href="{{ route('admin.orders') }}" class="btn-admin">Orders</a>
    <a href="{{ route('admin.customers.index') }}" class="btn-admin">Customers</a>
    <a href="{{ route('admin.products.index') }}" class="btn-admin">Products</a>
    <a href="{{ route('admin.inventory.index') }}" class="btn-admin">Inventory</a>
    <a href="{{ route('admin.inventory.movements') }}" class="btn-admin">Movements</a>
    <a href="{{ route('admin.inventory.alerts') }}" class="btn-admin">Low Stock Alerts</a>
    <a href="{{ route('admin.reports.stock-levels') }}" class="btn-admin">Reports</a>
</div>