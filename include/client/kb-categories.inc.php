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
        <?php
            $categories = Category::objects()
                ->exclude(Q::any(array(
                    'ispublic'=>Category::VISIBILITY_PRIVATE,
                    Q::all(array(
                            'faqs__ispublished'=>FAQ::VISIBILITY_PRIVATE,
                            'children__ispublic' => Category::VISIBILITY_PRIVATE,
                            'children__faqs__ispublished'=>FAQ::VISIBILITY_PRIVATE,
                            ))
                )))
                //->annotate(array('faq_count'=>SqlAggregate::COUNT('faqs__ispublished')));
                ->annotate(array('faq_count' => SqlAggregate::COUNT(
                                SqlCase::N()
                                ->when(array(
                                        'faqs__ispublished__gt'=> FAQ::VISIBILITY_PRIVATE), 1)
                                ->otherwise(null)
                )))
                ->annotate(array('children_faq_count' => SqlAggregate::COUNT(
                                SqlCase::N()
                                ->when(array(
                                        'children__faqs__ispublished__gt'=> FAQ::VISIBILITY_PRIVATE), 1)
                                ->otherwise(null)
                )));

            // ->filter(array('faq_count__gt' => 0));
            if ($categories->exists(true)) { ?>
                    <div><?php echo __('Click on the category to browse FAQs.'); ?></div>
                    <ul id="kb">
            <?php
                    foreach ($categories as $C) { 
                                    // Don't show subcategories with parents.
            if (($p=$C->parent)
            && ($categories->findFirst(array(
                        'category_id' => $p->getId()))))
        continue;

    $count = $C->faq_count + $C->children_faq_count;?>
                        <li><i></i>
                        <div>
                        <h4><?php echo sprintf('<a href="faq.php?cid=%d">%s %s</a>',
                $C->getId(), Format::htmlchars($C->getFullName()),
                $count ? "({$count})": ''
                ); ?></h4>
                        <span>
                            <?php echo Format::safe_html($C->getLocalDescriptionWithImages()); ?>
                        </span>
            <?php     
             if (($subs=$C->getPublicSubCategories())) {
                echo '<p/><div style="padding-bottom:15px;">';
                foreach ($subs as $c) {
                    echo sprintf('<div><i class="icon-folder-open"></i>
                            <a href="faq.php?cid=%d">%s (%d)</a></div>',
                            $c->getId(),
                            $c->getLocalName(),
                            $c->faq_count
                            );
                }
                echo '</div>';
            }  
            foreach ($C->faqs
                                ->exclude(array('ispublished'=>FAQ::VISIBILITY_PRIVATE))
                                ->limit(5) as $F) { ?>
                            <div class="popular-faq"><i class="icon-file-alt"></i>
                            <a href="faq.php?id=<?php echo $F->getId(); ?>">
                            <?php echo $F->getLocalQuestion() ?: $F->getQuestion(); ?>
                            </a></div>
            <?php       } ?>
                        </div>
                        </li>
            <?php   } ?>
                   </ul>
            <?php
                } else {
                    echo __('NO FAQs found');
                }
            ?>
        </div>
    </div>

</div></div>
</div>
