<?php
// $config must be set before including. Expects $active_nav.
$active_nav = $active_nav ?? 'home';
$year = date('Y');
?>
<div class="position-relative">
    <div class="shape overflow-hidden bg-footer">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>

<footer class="footer footer-simple">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <a href="index.php" class="brand-text brand-text-light">A.M<span class="brand-dot">.</span></a>
                <p class="my-3 mb-1 fw-medium text-white"><?= e($config['name']) ?></p>
                <p class="text-white-50 mt-0 mb-1">Software Developer / Product Builder</p>
                <p class="footer-tagline mt-0">Builds software products for startups, businesses and organizations.</p>
            </div>
            <div class="col-lg-7">
                <ul class="list-inline footer-nav mb-0 text-lg-end">
                    <li class="list-inline-item"><a href="index.php">Home</a></li>
                    <li class="list-inline-item"><a href="projects.php">Projects</a></li>
                    <li class="list-inline-item"><a href="<?= e($config['github']) ?>" target="_blank" rel="noopener">GitHub</a></li>
                    <li class="list-inline-item"><a href="index.php#contact">Get in Touch</a></li>
                    <li class="list-inline-item"><a href="assets/files/Stephen-Williams-CV.pdf" download>Download CV</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<div class="footer-alt">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <p>&copy; <?= e($year) ?> <?= e($config['name']) ?>. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/feather.js"></script>
<script src="js/app.js"></script>
<script src="js/contact.js"></script>
<!-- WhatsApp chat widget (GetButton). Alternative contact method; floats bottom-left. -->
<script type="text/javascript">
(function () {
    var options = {
        whatsapp: "2349032035127",
        call_to_action: "Message me",
        position: "left",
        pre_filled_message: "Hello Stephen, I found your portfolio and would like to discuss a software project with you."
    };

    var proto = document.location.protocol,
        host = "getbutton.io",
        url = proto + "//static." + host;

    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url + '/widget-send-button/js/init.js';

    s.onload = function () {
        WhWidgetSendButton.init(host, proto, options);
    };

    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
})();
</script>
</body>
</html>
