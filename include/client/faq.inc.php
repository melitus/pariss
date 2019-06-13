<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>
<div class="page-title">
    <div class="container"> <div class="row"> <div class="col-md-12">
        <h1><?php echo __('Frequently Asked Questions');?></h1>

            <div id="breadcrumbs">
            <a href="index.php"><?php echo __('All Categories');?></a>
    &raquo; <a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php
    echo $category->getFullName(); ?></a>
            </div>

    </div></div></div>
</div>

<div class="cover">
    <div class="container"> <div class="row"> <div class="col-md-12">
         <div class="faq-item">
            <div class="quest-box">
                <h2> <?php echo $faq->getLocalQuestion() ?></h2>
            </div>
            <div class="threads-body">
            <?php echo $faq->getLocalAnswerWithImages(); ?>
            </div>
            <?php
            if ($faq->getHelpTopics()->count()) { ?>
                <div class="faq-ht">
                <strong><?php echo __('Help Topics: '); ?></strong>
            <?php foreach ($faq->getHelpTopics() as $T) { ?>
                <span><?php echo $T->topic->getFullName(); ?></span>
            <?php } ?>
                </div>
            <?php }  ?>
            <hr>

            <div class="article-meta">

                <?php
                    if ($attachments = $faq->getLocalAttachments()->all()) { ?>
                    <div class="attaches">
                <?php foreach ($attachments as $att) { ?>
                    <span>
                    <a href="<?php echo $att->file->getDownloadUrl(['id' => $att->getId()]);
    ?>" class="no-pjax">
                        <i class="icon-file"></i>
                        <?php echo Format::htmlchars($att->getFilename()); ?>
                    </a>
                </span>
                <?php } ?>
                    </div>
                <?php } ?>

            </div>
         </div>
         <br>
         <div class="faded">&nbsp;<?php echo sprintf(__('Last Updated %s'),
             Format::relativeTime(Misc::db2gmtime($faq->getUpdateDate()))); ?></div>
         </div></div></div>
</div>
