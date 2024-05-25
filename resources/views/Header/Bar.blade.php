<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="/" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header" id="notification-header">0 Notifications</span>
                <div id="notification-items">
                </div>
                <div class="dropdown-divider"></div>
                <a href="/Notifikasi" class="dropdown-item dropdown-footer">Lihat Semua</a>
            </div>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() {
        $.ajax({
            url: '/notifications',
            method: 'GET',
            success: function(data) {
                let newProducts = data.new_products;
                let expiringProducts = data.expiring_products;
                let totalNewProducts = newProducts.length;
                let totalExpiringProducts = expiringProducts.length;
                let totalNotifications = totalNewProducts + totalExpiringProducts;

                $('#notification-count').text(totalNotifications);
                $('#notification-header').text(totalNotifications + ' Notifications');

                let notificationItems = '';
                if (totalNewProducts > 0) {
                    notificationItems += `
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> ${totalNewProducts} Barang Masuk
                        </a>
                        <div class="dropdown-divider"></div>
                    `;
                }
                if (totalExpiringProducts > 0) {
                    notificationItems += `
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> ${totalExpiringProducts} Barang Akan Kedaluwarsa
                        </a>
                        <div class="dropdown-divider"></div>
                    `;
                }

                $('#notification-items').html(notificationItems);
            },
            error: function(error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    $(document).ready(function() {
        fetchNotifications();
        setInterval(fetchNotifications, 60000);
    });
</script>
