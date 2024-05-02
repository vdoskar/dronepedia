<div class="post-card" onclick="location.href = '/forum/post?p={$post.slug}'; ">
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
            <span class="badge badge-success">{$post.status}</span>
        {else}
            <span class="badge badge-danger">{$post.status}</span>
        {/if}
    </div>
</div>
<br>