<div class="page-title">
    <div class="container"> <div class="row"> <div class="col-md-12">
        <h1><?php echo __('Frequently Asked Questions');?></h1>
    </div></div></div>
</div>

<div class="cover">
<div class="container"> <div class="row row-no-padding row-eq-height">

    <div class="col-md-4 kb-search">
        <form method="get" action="faq.php" id="kb-search">
            <div class="form-group">
                <input type="hidden" name="a" value="search"/>
                <select class="form-control" name="topicId"  style="width:100%;max-width:100%">
                <option value="">—<?php echo __("Help Topics"); ?>—</option>
                <?php
                $topics = Topic::objects()
                    ->annotate(array('has_faqs'=>SqlAggregate::COUNT('faqs')))
                    ->filter(array('has_faqs__gt'=>0));
                foreach ($topics as $T) { ?>
                        <option value="<?php echo $T->getId(); ?>"><?php echo $T->getFullName();
                            ?></option>
                <?php } ?>
                </select>
                <input type="text" name="q" class="form-control search" placeholder="<?php
                    echo __('Search our knowledge base'); ?>"/>
                <input class="btn btn-default" id="searchSubmit" type="submit" value="<?php echo __('Search');?>">
            </div>
        </form>
    </div>

    <div class="col-md-8 kb-box-cover">
        <div class="kb-box">
            <div><strong><?php echo __('Search Results'); ?></strong></div>
        <?php
            if ($faqs->exists(true)) {
                echo '<div id="faq">'.sprintf(__('%d FAQs matched your search criteria.'),
                    $faqs->count())
                    .'<ol>';
                foreach ($faqs as $F) {
                    echo sprintf(
                        '<li><a href="faq.php?id=%d" class="previewfaq">%s</a></li>',
                        $F->getId(), $F->getLocalQuestion(), $F->getVisibilityDescription());
                }
                echo '</ol></div>';
            } else {
                echo '<strong class="faded">'.__('The search did not match any FAQs.').'</strong>';
            }
        ?>
        </div>
    </div></div>


</div></div>
</div>
