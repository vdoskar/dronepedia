<header style="background-image: url('{$user.header_picture}');">

</header>

<div class="content">
    <div class="userContainer">

        <div class="userContainerCol userDetails">
            <div class="userImage text-center">
                <img class="rounded-circle shadow" src="{$user.profile_picture}" alt="{$user.username}">
            </div>
            <div class="details">
                <h1 class="text-center mb-4 text-bold">{$user.name}</h1>
                <div>
                    <p>
                        <i class="fa-solid fa-user"></i>
                        &nbsp; @{$user.username}
                    </p>
                    <p>
                        <i class="fa-solid fa-calendar-days"></i>
                        &nbsp; Registrován/a od {$user.registered}
                    </p>
                    <p>
                        <i class="fa-solid fa-message"></i>
                        &nbsp; {$user.post_count} příspěvků
                    </p>
                    <p>
                        <i class="fa-solid fa-comment"></i>
                        &nbsp; {$user.comment_count} komentářů
                    </p>
                </div>
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
                        {foreach $drones as $drone}
                            <div class="drone">
                                <a href="#">
                                    <h3>{$drone.name}</h3>
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
                <div id="tab_posts" class="tab-section">
                    <h2 class="text-bold">Příspěvky</h2>
                    <div class="posts">
                        {foreach $posts as $post}
                            <div class="post">
                                <a href="#">
                                    <h3>{$post.title}</h3>
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    tabs.init();
</script>