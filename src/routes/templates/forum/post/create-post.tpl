<div class="content halfBody">
    <h1>Nový příspěvek</h1>
    <form method="post" action="/api/posts/create" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Název</label>
            <input type="text" class="form-control" id="title" name="title" required>
            <input type="text" id="slug" name="slug" hidden>
            <p id="slugPreview" class="small mt-2 font-italic"></p>
        </div>
        <br>
        <div class="form-group">
            <label for="short_summary">Krátké shrnutí</label>
            <input type="text" class="form-control" id="short_summary" name="short_summary" maxlength="150" required>
        </div>
        <br>
        <div class="form-group">
            <label for="category">Kategorie</label>
            <select name="category" id="category" class="form-control" required>
                <option value="" disabled selected></option>
                {foreach $categories as $category}
                    <option value="{$category.name}">{$category.name}</option>
                {/foreach}
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="content">Obsah</label>
            <textarea class="form-control" id="content" name="content" required></textarea>
        </div>
        <br>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary" id="submit" name="submit">Přidat nový příspěvek</button>
        </div>
    </form>
</div>

<script>
    // init editor
    editor.init('content');

    // create slug from title
    document.getElementById('title').addEventListener('input', function(event) {
        document.getElementById('slug').value = utils.slugify(event.target.value);
        if (event.target.value.length > 0) {
            document.getElementById('slugPreview').innerText = 'URL příspěvku: ' + document.getElementById('slug').value
        } else {
            document.getElementById('slugPreview').innerText = '';
        }
    });
</script>