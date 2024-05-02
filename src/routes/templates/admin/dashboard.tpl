
<style>
    .tab-section {
        overflow-x: auto;
    }
    .adminTable {
        min-width: 1600px;
        border-collapse: collapse;
    }
</style>

<div class="content">
    <h1 class="text-center">Admin Dashboard</h1>

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
            <a href="#tab_comments">
                <i class="fa-solid fa-comments"></i>
                <span>Komentáře</span>
            </a>
        </div>
    </div>

    <div class="group">

        <div id="tab_users" class="tab-section">
            {if $users|count > 0}
                {include file='users.tpl'}
            {/if}
        </div>

        <div id="tab_posts" class="tab-section">
            {if $posts|count > 0}
                {include file='posts.tpl'}
            {/if}
        </div>

        <div id="tab_comments" class="tab-section">
            {if $comments|count > 0}
                {include file='comments.tpl'}
            {/if}
        </div>

    </div>
</div>

<script>
    tabs.init();
</script>