
<style>
    .tab-section {
        overflow-x: auto;
    }
</style>

<div class="content">
    <h1 class="text-center">Administrace v1</h1>

    <div class="group">
        <div class="tabs">
            <a href="#tab_users">
                <i class="fa-solid fa-user"></i>
                <span>Uživatelé</span>
            </a>
            <a href="#tab_posts">
                <i class="fa-solid fa-message"></i>
                <span>Příspěvky</span>
            </a>
        </div>
    </div>

    <div class="group">

        <div id="tab_users" class="tab-section">
            {if $users|count > 0}
                {include file='users.tpl'}
            {else}
                <p>Žádní uživatelé</p>
            {/if}
        </div>

        <div id="tab_posts" class="tab-section">
            {if $posts|count > 0}
                {include file='posts.tpl'}
            {else}
                <p>Žádné příspěvky</p>
            {/if}
        </div>

    </div>
</div>

<script>
    tabs.init();
</script>