<!-- Contact Form Starts -->
<section class="contact-form section-padding4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-5 mb-lg-0 form-contact-details">
                <div class="d-flex">
                    <div class="into-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="info-text">
                        <h5>London, United Kingdom</h5>
                        <p>20 Fenchurch St, EC3M 3BY</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="into-icon">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="info-text">
                        <h5>+44 7654 321 123</h5>
                        <p>Open 24/7</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="into-icon">
                        <i class="fa fa-envelope-o"></i>
                    </div>
                    <div class="info-text">
                        <h5>info@radsoltan.net</h5>
                        <p>Feel free to email us.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <form method="post" action="">
                    <div class="left">
                        <input type="text" name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" autocomplete="off" required
                               value="<?php echo escape(Input::getValue('name')) ?>">
                        <input type="email" name="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" autocomplete="off" required
                               value="<?php echo escape(Input::getValue('email')) ?>">
                        <input type="text" name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'" autocomplete="off" required
                               value="<?php echo escape(Input::getValue('subject')) ?>">
                    </div>
                    <div class="right">
                        <textarea name="message" placeholder="Enter Message" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" required></textarea>
                    </div>
                    <div class="contact-form-button-wrapper">
                        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <input type="submit" class="template-btn" value="send message">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Form End -->