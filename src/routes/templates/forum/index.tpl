<header style="background-image: url('{$bgImg}');">
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content forum-wrapper">
    <div class="group">
        <a class="btn btn-secondary" href="/forum/create-post">
            <i class="fa-regular fa-square-plus"></i>
            &nbsp;Přidat příspěvek
        </a>
    </div>

    <br>
    <div class="group">
        <h2>Nejnovější příspěvky</h2>
        <br>
        <section class="forum-section">
            {if $latestPosts|count > 0 }
                {foreach $latestPosts as $post}
                    {include file="list-item.tpl" post=$post}
                {/foreach}
            {/if}
        </section>
    </div>

    <div class="group">
        <h2>Moje aktivní příspěvky</h2>
        <br>
        <section class="forum-section">
            {if $myPosts|count > 0 }
                {foreach $latestPosts as $post}
                    {include file="list-item.tpl" post=$post}
                {/foreach}
            {/if}
        </section>
    </div>

    <div class="group">
        <h2>Všechny kategorie</h2>
    </div>
</div>