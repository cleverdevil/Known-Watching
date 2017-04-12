<article class="h-entry known-watching">
            
            <div class="p-item h-product">
                                
    <?php
        if ($attachments = $vars['object']->getAttachments()) {
            foreach ($attachments as $attachment) {
                $mainsrc = $attachment['url'];
                if (!empty($vars['object']->thumbnail_large)) {
                    $src = $vars['object']->thumbnail_large;
                } else if (!empty($vars['object']->thumbnail)) { // Backwards compatibility
                    $src = $vars['object']->thumbnail;
                } else {
                    $src = $mainsrc;
                }
                
                // Patch to correct certain broken URLs caused by https://github.com/idno/known/issues/526
                $src = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $src);
                $mainsrc = preg_replace('/^(https?:\/\/\/)/', \Idno\Core\site()->config()->getDisplayURL(), $mainsrc);
                
                ?>
                <a href="<?= $this->makeDisplayURL($mainsrc) ?>"><img src="<?= $this->makeDisplayURL($src) ?>" style="float: left; margin: 0 2em 1em 0; width: 150px" class="u-photo"/></a>
                <h2>
                    Watched <span class="p-name"><?= htmlentities(strip_tags($vars['object']->getTitle()), ENT_QUOTES, 'UTF-8'); ?></span>
                </h2>
            
            </div>
            <?php
            }
        }
    ?>
            
            <div class="e-content">
                <?= $this->__(['value' => $vars['object']->body, 'object' => $vars['object']])->draw('forms/output/richtext'); ?>
                
                <p style="font-style: italic">Watched on <?= $vars['object']->getPlayer() ?></p>
            </div>
            
            <div style="display: none;">
                <p class="h-card vcard p-author">
                    <a href="<?= $vars['object']->getOwner()->getURL(); ?>" class="icon-container">
                        <img class="u-logo logo u-photo photo" src="<?= $vars['object']->getOwner()->getIcon(); ?>"/>
                    </a>
                    <a class="p-name fn u-url url" href="<?= $vars['object']->getOwner()->getURL(); ?>"><?= $vars['object']->getOwner()->getName(); ?></a>
                    <a class="u-url" href="<?= $vars['object']->getOwner()->getURL(); ?>">
                        <!-- This is here to force the hand of your MF2 parser --></a>
                </p>
            </div>
</article>
