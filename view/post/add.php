<div class="add-new-post">
    <form action="/post/save" method="POST">
        <input type="text" required maxlength="255" name="title" placeholder="Title:"/>
        <br>
        <textarea name="content" maxlength="1024" placeholder="Content"></textarea>
        <button type="submit">Add new post</button>
    </form>
</div>
