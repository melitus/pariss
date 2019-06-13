<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div id="landing_page">

<div class="welcome-section">
    <div class="container"><div class="row">
        <div class="col-md-12">
            <div class="welcome-post">
            <?php
            if($cfg && ($page = $cfg->getLandingPage()))
                echo $page->getBodyWithImages();
            else
                echo  '<h1>'.__('Welcome to the Support Center').'</h1>';
            ?>
            </div>
        </div>
    </div></div>
</div>

<div class="cta-box-cover">
    <div class="container">
        <div class="row">
            <?php
                if ($cfg->getClientRegistrationMode() != 'disabled'
                    || !$cfg->isClientLoginRequired()) { ?>
                    <div class="col-md-12">
                        <div id="new_ticket" class="action-box">
                            <div class="row row-no-padding row-eq-height">
                                <div class="col-md-6 act-pic">

                                </div>
                                <div class="col-md-6">
                                    <div class="act-text">
                                        <h3><?php echo __('Open a New Ticket');?></h3>
                                        <div><?php echo __('Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, please login.');?></div>
                                        <p>
                                            <a href="open.php" class="green button"><?php echo __('Open a New Ticket');?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            <?php } ?>

            <div class="col-md-12">
                <div id="check_status" class="action-box">

                    <div class="row row-no-padding row-eq-height">
                        <div class="col-md-6">
                            <div class="act-text">
                                <h3><?php echo __('Check Ticket Status');?></h3>
                                <div><?php echo __('We provide archives and history of all your current and past support requests complete with responses.');?></div>
                                <p>
                                    <a href="<?php if(is_object($thisclient)){ echo 'tickets.php';} else {echo 'view.php';}?>" class="blue button"><?php echo __('Check Ticket Status');?></a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 act-pic">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>

    <div class="kb-home-cover">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <p><?php echo sprintf(
                        __('Be sure to browse our %s before opening a ticket'),
                        sprintf('<a href="kb/index.php">%s</a>',
                            __('Frequently Asked Questions (FAQs)')
                        )); ?>
                    </p>

                    <div class="kb-search-form form-inline">
                        <form method="get" action="kb/faq.php">
                        <input type="hidden" name="a" value="search"/>
                        <input type="text" name="q" class="search form-control" placeholder="<?php echo __('Search our knowledge base'); ?>"/>
                        <button type="submit" class="btn btn-default"><?php echo __('Search'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
