<?php

use App\Check\Controller\Post\View;

/**
 * @var $this View
 */

?>
<div class="post">
    <h3><a href="/post/view"><?= $this->post->getTitle() ?></a></h3>
    <div class="content"><?= $this->post->getContent() ?></div>
    <?php if ($this->isAuthor($this->post->getAuthorId())): ?>
        <a href="#" onclick="document.getElementById('editForm').submit(); return false;">
            Edit Post
        </a>
        <form id="editForm" method="post" action="/post/edit">
            <input type="hidden" name="postId" value="<?=$this->post->getId()?>">
            <input type="hidden" name="authorId" value="<?=$this->post->getAuthorId()?>">
        </form>
    <?php endif ?>
</div>
