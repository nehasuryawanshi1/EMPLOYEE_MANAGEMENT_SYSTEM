<?php
if (empty($_SESSION['user1_session'])) {
    header('Location:login.php');
}
?>
<div class="header">
    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="assets/img/logo1.jpg" alt="Logo">
        </a>
        <a href="index.php" class="logo logo-small">
            <img src="assets/img/logo1.jpg" alt="Logo" width="30" height="30">
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-align-left"></i>
    </a>
    <!--  <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div> -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>
    <ul class="nav user-menu">
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <div class="avatar">
                        <?php $string = $_SESSION['user1_session']['name'];
                        $firstLetter = substr($string, 0, 1);  ?>
                        <span class="avatar-title rounded-circle border border-white"><?php echo $firstLetter; ?></span>
                    </div>
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <div class="avatar">
                            <span class="avatar-title rounded-circle border border-white"><?php echo $firstLetter; ?></span>

                        </div>
                    </div>
                    <div class="user-text">
                        <h6><?php echo $_SESSION['user1_session']['name'] ?></h6>
                        <!-- <p class="text-muted mb-0">Administrator</p> -->
                    </div>
                </div>
                <!--     <a class="dropdown-item" href="profile.php">My Profile</a>
                        <a class="dropdown-item" href="inbox.php">Inbox</a> -->
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </li>
    </ul>
</div>