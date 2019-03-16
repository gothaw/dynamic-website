<!-- Header Area Starts -->
<header class="header-area main-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo-area">
                    <a href="#"><img src="<?php echo DIST?>/img/logo.png" alt="logo"></a>
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
                        <?php if(isset($data['navPages'])) {
                            foreach ($data['navPages'] as $page) {?>
                            <li>
                                <a class="menu-link
                                <?php if($page['pg_name']===$name){echo "menu-link-active";}?>" href="<?php echo ROOT . $page['pg_url']?>">
                                   <?php echo $page['pg_name']?>
                                </a>
                            </li>
                        <?php }
                        }?>
                        <li class="menu-btn">
                            <a href="#" class="template-btn">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header Area End -->
