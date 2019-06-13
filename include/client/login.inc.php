<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getLocalName(), $content->getLocalBody()));
} else {
    $title = __('Sign In');
    $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>


<div class="page-title">
    <div class="container"> <div class="row"> <div class="col-md-12">
        <h1><?php echo Format::display($title); ?></h1>
        <p><?php echo Format::display($body); ?></p>
    </div></div></div>
</div>

<div class="cover login-cover">
    <div class="container"> <div class="row"> <div class="col-md-8 offset-md-2 col-sm-12">
        <div class="form-cover">
        <form action="login.php" method="post" id="clientLogin">
            <?php csrf_token(); ?>

            <div class="login-box">
            <strong><?php echo Format::htmlchars($errors['login']); ?></strong>
            <div class="form-group">
                <input class="form-control nowarn" id="username" placeholder="<?php echo __('Email or Username'); ?>" type="text" name="luser" size="30" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <input class="form-control nowarn"  id="passwd" placeholder="<?php echo __('Password'); ?>" type="password" name="lpasswd" size="30" value="<?php echo $passwd; ?>"></td>
            </div>
            <p>
                <input class="btn submit" type="submit" value="<?php echo __('Sign In'); ?>">
        <?php if ($suggest_pwreset) { ?>
                <a class="btn fgpass" href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
        <?php } ?>
            </p>
            </div>

        <div class="sublog">
        <?php
        $ext_bks = array();
        foreach (UserAuthenticationBackend::allRegistered() as $bk)
            if ($bk instanceof ExternalAuthentication)
                $ext_bks[] = $bk;

        if (count($ext_bks)) {
            foreach ($ext_bks as $bk) { ?>
        <div class="external-auth btn"><?php $bk->renderExternalLink(); ?></div><?php
            }
        }
        if ($cfg && $cfg->isClientRegistrationEnabled()) {
            if (count($ext_bks)) echo '<hr style="width:70%"/>'; ?>
            <div class="btn accreg">
            <?php echo __('Not registered?'); ?> <a href="account.php?do=create"><?php echo __('Create an account'); ?></a>
            </div>
        <?php } ?>
            <div class="btn aglog">
            <b><?php echo __("I'm an agent"); ?></b> —
            <a href="<?php echo ROOT_PATH; ?>scp/"><?php echo __('sign in here'); ?></a>
            </div>
            </div>
            </div>

        </form>
        <br>
        <p>
        <?php
        if ($cfg->getClientRegistrationMode() != 'disabled'
            || !$cfg->isClientLoginRequired()) {
            echo sprintf(__('If this is your first time contacting us or you\'ve lost the ticket number, please %s open a new ticket %s'),
                '<a href="open.php">', '</a>');
        } ?>
        </p>
</div>
</div>
</div></div></div>
