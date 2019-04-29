<!-- Header Area Starts -->
<header class="header-area main-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo-area">
                    <a href="<?php echo ROOT ?>"><img src="<?php echo DIST ?>/img/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="custom-navbar">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="main-menu">
                    <ul>
                        <?php if (isset($data['navPages'])) {
                            foreach ($data['navPages'] as $page) { ?>
                                <li>
                                    <a class="menu-link
                                <?php if ($page['pg_name'] === $name) {
                                        echo "menu-link-active";
                                    } ?>" href="<?php echo ROOT . escape($page['pg_url']) ?>">
                                        <?php echo escape($page['pg_name']) ?>
                                    </a>
                                </li>
                            <?php }
                        }
                        if ($userIsLoggedIn) { ?>
                            <li class="menu-btn menu-btn-logged-in">
                                <a class="template-btn" href="<?php echo ROOT . 'dashboard/' ?>">My Account</a>
                                <a class="template-btn" href="<?php echo ROOT . 'dashboard/logout/' ?>">Log out</a>
                            </li>
                        <?php } else { ?>
                            <li class="menu-btn">
                                <a href="<?php echo ROOT . 'login/' ?>" class="template-btn">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End -->