<?php

use App\Check\Controller\Home;

/**
 * @var $this Home
 */
//$totalPages = (int)ceil($totalArticleCount / self::ARTICLES_PER_PAGE);
?>

<h1><?= $this->getTitle() ?></h1>
<div class="posts">
    <?php foreach ($this->posts as $post): ?>
        <div class="post">
            <h3><a href="/post/view?id=<?=$post->getId()?>"><?= $post->getTitle() ?></a></h3>
            <div class="content"><?= $post->getContent() ?></div>
            <?php if ($this->isAuthor($post->getAuthorId())): ?>
                <a href="#" onclick="document.getElementById('editForm').submit(); return false;">
                    Edit Post
                </a>
                <form id="editForm" method="post" action="/post/edit">
                    <input type="hidden" name="postId" value="<?=$post->getId()?>">
                    <input type="hidden" name="authorId" value="<?=$post->getAuthorId()?>">
                </form>
            <?php endif ?>
        </div>
    <?php endforeach; ?>


</div>

