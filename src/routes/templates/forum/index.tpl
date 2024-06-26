<header style="background-image: url('{$bgImg}');">
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content forum-wrapper">
    {if $currentUser}
        <div class="group">
            <a class="btn btn-secondary" href="/forum/create-post">
                <i class="fa-regular fa-square-plus"></i>
                &nbsp;Vytvořit příspěvek
            </a>
        </div>
    {/if}
    <br>
    <div class="group">
        <h2>Poslední příspěvky</h2>
        <br>
        <section class="forum-section">
            {if $latestPosts|count > 0 }
                {foreach $latestPosts as $post}
                    {include file="list-item.tpl" post=$post}
                {/foreach}
            {else}
                <p><i>Zatím zde nejsou žádné příspěvky. Buď první, kdo nějaký vytvoří!</i></p>
            {/if}
        </section>
    </div>

    {if $currentUser}
        <br>
        <div class="group">
            <h2>Moje aktivní příspěvky</h2>
            <br>
            <section class="forum-section">
                {if $myPosts|count > 0 }
                    {foreach $myPosts as $post}
                        {include file="list-item.tpl" post=$post}
                    {/foreach}
                {else}
                    <p><i>Zatím jste nevytvořil/a žádný příspěvek, tak hurá do toho!</i></p>
                {/if}
            </section>
        </div>
    {/if}
</div>