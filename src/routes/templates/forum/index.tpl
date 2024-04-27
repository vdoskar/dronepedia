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
            {for $i=0 to 5}
                {include file="post-item.tpl"}
            {/for}
        </section>
    </div>

    <div class="group">
        <h2>Moje aktivní příspěvky</h2>
    </div>

    <div class="group">
        <h2>Všechny kategorie</h2>
    </div>
</div>