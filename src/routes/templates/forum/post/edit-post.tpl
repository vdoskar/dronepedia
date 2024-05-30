<div class="content halfBody">
    <h1>Upravit příspěvek</h1>
    <div class="group">
        <form action="/api/posts/delete" class="mt-2" method="POST">
            <input type="text" name="slug" value="{$post.slug}" hidden>
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-trash-can"></i>
                &nbsp; Smazat příspěvek
            </button>
        </form>
    </div>
    <div class="group">
        <form method="post" action="/api/posts/edit" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Název</label>
                <input type="text" class="form-control" id="title" name="title" required value="{$post.title}" disabled>
            </div>
            <br>
            <div class="form-group">
                <label for="short_summary">Krátké shrnutí</label>
                <input type="text" class="form-control" id="short_summary" name="short_summary" maxlength="150" required value="{$post.short_summary}">
            </div>
            <br>
            <div class="form-group">
                <label for="content">Obsah</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <br>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary" id="submit" name="submit">Upravit příspěvek</button>
            </div>
            <input type="text" name="slug" value="{$post.slug}" hidden>
            <input type="text" name="author" value="{$post.author}" hidden>
        </form>
    </div>
</div>

<script>
    editor.init('content');
    editor.setData('content', `{$post.content}`);
</script>