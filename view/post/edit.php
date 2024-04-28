<?php

use App\Check\Controller\Post\Edit;
use App\Check\Model\Post;

/**
 * @var $this Edit
 */

/** @var $post Post*/
$post =  $this->post;
?>

<div class="edit-post">
    <form action="/post/save" method="POST">
        <input type="text" required maxlength="255" name="title" placeholder="Title:" value="<?=$post->getTitle()?>">
        <br>
        <textarea name="content" maxlength="1024" placeholder="Content"><?=$post->getContent()?></textarea>
        <button type="submit">Save post</button>

        <input type="hidden" name="postId" value="<?=$post->getId()?>">
    </form>
</div>
