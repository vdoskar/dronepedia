<div class="content halfBody">
    <div class="group">
        <a href="/forum" class="btn btn-secondary">
            <i class="fa-solid arrow-back"></i>
            Zpět na fórum
        </a>
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
        <form id="commentGroup" method="POST" action="/api/posts/comments/create">

        </form>
    </div>
</div>