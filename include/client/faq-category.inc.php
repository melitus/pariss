<?php
if(!defined('OSTCLIENTINC') || !$category || !$category->isPublic()) die('Access Denied');
?>

<div class="page-title">
    <div class="container"> <div class="row"> <div class="col-md-12">
    <h1><?php echo $category->getFullName(); ?></h1>
    <p>
<?php echo Format::safe_html($category->getLocalDescriptionWithImages()); ?>
</p>
<?php

if (($subs=$category->getSubCategories(array('public' => true)))) {
    echo '<div>';
    foreach ($subs as $c) {
        echo sprintf('<div><i class="icon-folder-open-alt"></i>
                <a href="faq.php?cid=%d">%s (%d)</a></div>',
                $c->getId(),
                $c->getLocalName(),
                $c->getNumFAQs()
                );
    }
    echo '</div>';
} ?>
    </div></div></div>
</div>

<div class="cover">
    <div class="container"> <div class="row"> <div class="col-md-12">

        <div class="faq-list">
            <?php
            $faqs = FAQ::objects()
                ->filter(array('category'=>$category))
                ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                ->annotate(array('has_attachments' => SqlAggregate::COUNT(SqlCase::N()
                    ->when(array('attachments__inline'=>0), 1)
                    ->otherwise(null)
                )))
                ->order_by('-ispublished', 'question');

            if ($faqs->exists(true)) {
                echo '
                     <h2>'.__('Frequently Asked Questions').'</h2>
                     <div id="faq">
                        <ol>';
            foreach ($faqs as $F) {
                    $attachments=$F->has_attachments?'<span class="Icon file"></span>':'';
                    echo sprintf('
                        <li><a href="faq.php?id=%d" >%s &nbsp;%s</a></li>',
                        $F->getId(),Format::htmlchars($F->question), $attachments);
                }
                echo '  </ol>
                     </div>
                     <p><a class="back" href="index.php">&laquo; '.__('Go Back').'</a></p>';

            }elseif (!$category->children) {
                echo '<strong>'.__('This category does not have any FAQs.').' <a href="index.php">'.__('Back To Index').'</a></strong>';
            }
            ?>
        </div>

    </div></div></div>
</div>
