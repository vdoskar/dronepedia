<div class="post-card" onclick="location.href = '/forum/post?p={$post.slug}'; ">
    <div class="pc-author post-card-item">
        <img class="rounded-circle" src="{$post.author_avatar|default:"https://www.ef.tul.cz/content/files/images/zamestnanci/135-th.jpg"}" alt="John Doe Image">
        <span class="pc-author-name mt-1">
            <strong>{$post.author}</strong>
        </span>
    </div>
    <div class="pc-content post-card-item">
        <h4>{$post.title}</h4>
        <div>{$post.short_summary}</div>
    </div>
    <div class="pc-category post-card-item">
        <h4>Kategorie</h4>
        <span class="badge badge-neutral">
            <a href="/forum//categories?c={$post.category}" style="text-decoration: none; color: var(--secondaryYellow)">{$post.category}</a>
        </span>
    </div>
    <div class="pc-date post-card-item">
        <h4>Vytvořeno</h4>
        <span class="badge badge-neutral">{$post.date_created|date_format:"%d.%m.%Y"}</span>
    </div>
    <div class="pc-status post-card-item">
        {if $post.status == "ACTIVE"}
            <span class="badge badge-success">AKTIVNÍ</span>
        {else}
            <span class="badge badge-danger">UZAVŘEN</span>
        {/if}
    </div>
</div>
<br>