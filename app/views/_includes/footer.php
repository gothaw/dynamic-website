<!-- Footer Area Starts -->
    <footer class="footer-area <?php
            if($data['pageDetails']['pg_footer'] === 'dark') {echo 'footer';}
        ?> section-padding4">
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-widget-home mb-5 mb-lg-0">
                            <h5 class="mb-4">contact us</h5>
                            <p>20 Fenchurch St, London EC3M 1DT</p>
                            <span class="span-style">+44 7654 321 123</span>
                            <span class="span-style">info@radsoltan.net</span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="single-widget-home">
                            <h5 class="mb-4">newsletter</h5>
                            <p class="mb-4">Sign up to our newsletter. We send discount codes and only the best offers!</p>
                            <form action="#">
                                <input type="email" placeholder="Your email here" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your email here'" required>
                                <button type="submit" class="template-btn"><i class="fa fa-long-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row copyright-wrapper">
                    <div class="col-lg-8 col-md-6">
                        <div class="footer-disclaimer">
                            <p>Radoslaw Soltan &copy;<?php echo date("Y")?></p>
                            <p>This website was done as a part of portfolio project. It is not for commercial use and I do not own any of the assets shown on this website.</p>
                            <p>Website layout based on template by <a class="colorlib-link" href="https://colorlib.com" target="_blank">Colorlib</a> | Copyright &copy;<?php echo date("Y")?> | All rights reserved</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="social-icons">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->
    <!-- Javascript -->
    <script src="<?php echo DIST?>/js/vendor/jquery-3.4.1.min.js"></script>
    <script src="<?php echo DIST?>/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script src="<?php echo DIST?>/js/vendor/wow.min.js"></script>
    <script src="<?php echo DIST?>/js/bundle.js"></script>
    </body>
</html>