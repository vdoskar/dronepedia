<div class="content halfBody">
    <div class="group">
        <a href="/forum" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            &nbsp; Zpět na fórum
        </a>
        {if $post.status == "ACTIVE" && $currentUser.username == $post.author_tag}
            <a href="/forum/edit-post?p={$post.slug}" class="btn btn-success">
                <i class="fa-solid fa-pen-to-square"></i>
                &nbsp; Upravit příspěvek
            </a>
        {/if}
    </div>
    <br>
    <h1>{$title}</h1>
    <p>{$post.short_summary}</p>
    <div class="group">
        <p>Autor článku: <a href="/profile?u={$post.author_tag}">{$post.author}</a></p>
    </div>
    <hr>
    <div class="group">
        <div class="post-content-raw">
            {$post.content}
        </div>
    </div>
    <hr>
    <div class="group">
        <h3>Komentáře k příspěvku:</h3>
        {if $post.status == "ACTIVE"}
            <button class="btn btn-secondary" id="addComment">
                <i class="fa-regular fa-square-plus"></i>
                &nbsp;Přidat komentář
            </button>
        {/if}
        <form id="commentForm" method="POST" action="/api/posts/comments/create" style="display: none;">
            <input type="hidden" name="post_id" value="{$post.id}">
            <input type="hidden" name="author" value="{$currentUser.uuid}">
            <input type="hidden" name="redirectUrl" value="/forum/post?p={$post.slug}">
            <div class="form-group">
                <textarea class="form-control" id="comment_content" name="comment_content" rows="3"></textarea>
            </div>
            <br>
            <div>
                <p>Komentujete jako {$currentUser.label}</p>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Přidat</button>
            </div>
        </form>
    </div>
    <div class="group">
        {if $comments|count > 0}
            {foreach $comments as $comment}
                <div class="comment">
                    <div class="comment-header">
                        <a href="/profile?u={$comment.author_tag}">{$comment.author}</a>
                        <span>{$comment.date_created}</span>
                    </div>
                    <div class="comment-content-raw">
                        {$comment.content}
                    </div>
                </div>
            {/foreach}
        {else}
            <p><i>Zatím zde nejsou žádné komentáře. Buďte první, kdo příspěvek okomentuje!</i></p>
        {/if}
    </div>
</div>

<script>

    document.getElementById('addComment').addEventListener('click', function(ev) {
        ev.target.style.display = 'none';
        document.getElementById('commentForm').style.display = 'block';
        editor.init("comment_content");
    });

</script>

