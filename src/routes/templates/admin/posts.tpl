<form action="/api/admin/post/save-all" method="POST">
    <button class="btn btn-primary">
        Uložit vše
    </button>
    <table class="table adminTable">
        <thead>
        <tr>
            <th>Název</th>
            <th>Slug</th>
            <th>Autor</th>
            <th>Krátký popis</th>
            <th>Kategorie</th>
            <th>Status</th>
            <th>Vytvořeno</th>
            <th>Aktualizováno</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        {foreach $posts as $post}
            <tr>
                <td>
                    <input type="text" value="{$post.title}" name="post_data[{$post.slug}][title]">
                </td>
                <td>{$post.slug}</td>
                <td>{$post.author}</td>
                <td>
                    <input type="text" value="{$post.short_summary}" name="post_data[{$post.slug}][short_summary]">
                </td>
                <td>
                    <select id="post-category" name="post_data[{$post.slug}][category]">
                        {foreach $posts_categories as $category}
                            <option value="{$category.name}" {if $post.category == $category.name} selected {/if}>{$category.name}</option>
                        {/foreach}
                    </select>
                </td>
                <td>
                    <select id="post-status" name="post_data[{$post.slug}][status]">
                        <option value="ACTIVE" {if $post.status == "ACTIVE"} selected {/if}>ACTIVE</option>
                        <option value="CLOSED" {if $post.status == "CLOSED"} selected {/if}>CLOSED</option>
                    </select>
                </td>
                <td>{$post.date_created}</td>
                <td>{$post.date_updated}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</form>
