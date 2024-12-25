<?php
if (empty($_SESSION['admin_session'])) {
header('Location:login.php');

}
include_once '../dbconnection.php';
?>
<div class="header">
    <div class="header-left" style="background-color: #ffffff;">
        <a href="index.php" class="logo">
            <img src="../assets/images/pol/logo1.jpeg" alt="Logo">
        </a>
        <a href="index.php" class="logo logo-small">
            <img src="../assets/images/pol/logo1.jpeg" alt="Logo" width="60" height="30">
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-align-left"></i>
    </a>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav user-menu">
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <div class="avatar">
                        <?php $string= $_SESSION['admin_session']['username'];
                                      $firstLetter = substr($string, 0, 1);  ?>
                        <span class="avatar-title rounded-circle border border-white"><?php echo $firstLetter; ?></span>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <div class="avatar">
                            <span
                                class="avatar-title rounded-circle border border-white"><?php  echo $firstLetter;?></span>

                        </div>
                    </div>
                    <div class="user-text">
                        <h6><?php echo $_SESSION['admin_session']['username'] ?></h6>
                        <p class="text-muted mb-0">Administrator</p>
                    </div>
                </div>

                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</div>