        </div>
    </div>

    <div id="footer-columns">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-column"> <!-- footer column One -->
                            <h3> About Paris </h3>
                            <p> Welcome to Paris osTicket theme. This is a customized osTicket software skin. This theme makes the client section of your
                                osTicket responsive, mobile ready and visually more appealing than the dull default style. </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-column"> <!-- footer column Two -->
                            <h3> Important Links </h3>
                            <ul>
                                <li>Text with no link </li>
                                <li><a href="#"> Custom link 1 </a></li>
                                <li><a href="#"> Custom link 2 </a></li>
                                <li><a href="#"> Custom link 3 </a></li>
                                <li><a href="#"> Custom link 4</a></li>

                            </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-column"> <!-- footer column Three -->
                            <h3> Contact us </h3>
                            <p> Company Name <br>
                                221, 2nd floor <br>
                                Baker street, London, <br>
                                England</p>
                            <p>  <i class="icon-phone-sign"></i>  1800-9876-5432  <br>
                                 <i class="icon-envelope"></i> mymail@company.com </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
    <div class="container">
            <div class="row">
                <div class="col-md-12">
        <p><?php echo __('Copyright &copy;'); ?> <?php echo date('Y'); ?> <?php
        echo Format::htmlchars((string) $ost->company ?: 'osTicket.com'); ?> - <?php echo __('All rights reserved.'); ?></p>
        <a id="poweredBy" href="http://osticket.com" target="_blank"><?php echo __('Helpdesk software - powered by osTicket'); ?></a>
                </div>
            </div>
        </div>
    </div>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>
</body>
</html>
