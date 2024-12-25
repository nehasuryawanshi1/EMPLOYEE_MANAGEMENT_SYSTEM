<div class="sidebar bg-primary text-light vh-100 d-flex flex-column" id="sidebar">
    <div class="sidebar-inner overflow-auto">
        <div id="sidebar-menu" class="p-3">
            <ul class="list-unstyled">
                <li class="mb-3 text-uppercase small fw-bold border-bottom pb-2">
                    <span>Main Menu</span>
                </li>
                <li class="mb-2">
                    <a href="index.php" class="d-flex align-items-center text-light text-decoration-none p-2 rounded sidebar-link">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="registereduser.php" class="d-flex align-items-center text-light text-decoration-none p-2 rounded sidebar-link">
                        <i class="fas fa-user"></i>
                        <span>Registered Info</span>
                    </a>
                </li>
                <li class="mb-2">
                    <a href="employee-attendance.php" class="d-flex align-items-center text-light text-decoration-none p-2 rounded sidebar-link">
                        <i class="fas fa-calendar-check"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                <li class="mb-3 text-uppercase small fw-bold border-bottom pb-2">
                    <span>Management</span>
                </li>
                <li class="submenu mb-2">
                    <a href="javascript:void(0);" class="d-flex align-items-center text-light text-decoration-none p-2 rounded sidebar-link justify-content-between" data-bs-toggle="collapse" data-bs-target="#authSubmenu">
                        <span>
                            <i class="fas fa-shield-alt"></i>
                            Authentication
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="collapse list-unstyled ms-3" id="authSubmenu">
                        <li>
                            <a href="changepassword.php" class="d-flex align-items-center text-light text-decoration-none p-2 rounded sidebar-link">
                                Change Password
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    /* Sidebar Styles */
    .sidebar {
        background: linear-gradient(45deg, #3b5998, #8b9dc3);
        color: #fff;
        font-family: 'Roboto', Arial, sans-serif;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .sidebar-link {
        transition: background 0.3s, color 0.3s;
    }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .sidebar-link.active {
        background: rgba(255, 255, 255, 0.2);
        font-weight: bold;
        color: #f1f1f1;
    }

    /* Icon Styles */
    .sidebar-link i {
        font-size: 1.2rem;
        color: rgb(253, 253, 251);
        margin-right: 10px; /* Space between icon and text */
    }

    .sidebar-link.active i {
        color: #ffdd59;
    }

    /* Collapse Arrow Rotation */
    .submenu a[data-bs-toggle="collapse"][aria-expanded="true"] i {
        transform: rotate(180deg);
        transition: transform 0.3s;
    }
</style>

<!-- Bootstrap JS and dependencies (for collapse functionality) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
