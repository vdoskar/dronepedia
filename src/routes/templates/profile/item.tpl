<header style="background-image: url('{$settings.pic_banner}');"></header>

<div class="content">
    <div class="userContainer">

        <div class="userContainerCol userDetails">
            <div class="userImage text-center">
                <img class="rounded-circle shadow" src="{$settings.pic_profile}" alt="{$user.username}">
            </div>
            <div class="details">
                <h1 class="text-center mb-4 text-bold">{$user.label}</h1>
                <div>
                    <p>
                        <i class="fa-solid fa-user"></i>
                        &nbsp; @{$user.username}
                    </p>
                    <p>
                        <i class="fa-solid fa-calendar-days"></i>
                        &nbsp; Registrován/a od {$user.date_registered|date_format:"%d.%m.%Y"}
                    </p>
                    <p>
                        <i class="fa-solid fa-message"></i>
                        &nbsp; {$posts|count} příspěvků
                    </p>
                    <p>
                        <i class="fa-solid fa-comment"></i>
                        &nbsp; {$comments|count} komentářů
                    </p>
                </div>
                {if $user.uuid == $currentUser.uuid}
                    <div class="text-center mt-4">
                        <a href="/profile/edit" class="btn btn-secondary">
                            <i class="fa-solid fa-gear"></i>
                            Upravit profil
                        </a>
                    </div>
                {/if}
            </div>
        </div>

        <div class="userContainerCol userOverview">
            <div class="tabs">
                <a href="#tab_drones">
                    <i class="fa-solid fa-shuttle-space"></i>
                    <span>Drony</span>
                </a>
                <a href="#tab_posts">
                    <i class="fa-solid fa-message"></i>
                    <span>Příspěvky</span>
                </a>
            </div>

            <div class="userOverviewSections">

                <div id="tab_drones" class="tab-section">
                    <h2 class="text-bold">Drony</h2>
                    <div class="drones">
                        {if $drones|count > 0}
                            {foreach $drones as $drone}
                                <div class="drone">
                                    <a href="#">
                                        <h3>{$drone.name}</h3>
                                    </a>
                                </div>
                            {/foreach}
                        {else}
                            <p">Tento uživatel zatím nepřidal žádné své drony.</p>
                        {/if}
                    </div>
                </div>

                <div id="tab_posts" class="tab-section">
                    <h2 class="text-bold mb-4">Příspěvky</h2>
                    <div class="posts">
                        {if $posts|count > 0}
                            {foreach $posts as $post}
                                {include file="post-item.tpl" post=$post}
                            {/foreach}
                        {else}
                            <p>Tento uživatel zatím nepřidal žádné příspěvky.</p>
                        {/if}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    tabs.init();
</script>