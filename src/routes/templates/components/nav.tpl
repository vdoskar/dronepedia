<nav class="navbar navbar-dark">

    <a class="navbar-brand mb-1 mt-1" style="margin-right: 4rem" href="/" title="Domů | DronePedia" id="logoLink">
        <img src="https://cdn.dronepedia.krisp1k.eu/favicon/favicon_yellow.svg" alt="Dronepedia Logo" id="logoImage">
    </a>

    <div class="navbar-half">
        <ul class="navbar-nav">
            {foreach $menu as $link => $item}
                {if $item.inNav}
                    <li class="nav-item" title="{$item.label} | DronePedia">
                        <a class="nav-link {if $activeTab == $link}active{/if}" href="{$link}">
                            &nbsp; <i class="fa-solid {$item.icon}"></i>
                            &nbsp; {$item.label} &nbsp;
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </div>

    <div class="navbar-half">
        <ul class="navbar-nav">
            {if $loggedIn}
                {if $isAdmin}
                    <li class="nav-item">
                        <a class="nav-link {if $activeTab == "/admin"}active{/if}" href="/admin">
                            &nbsp; <i class="fa-solid fa-code"></i>
                            &nbsp;Administrace &nbsp;
                        </a>
                    </li>
                {/if}
                <li class="nav-item">
                    <a class="nav-link {if $activeTab == "/profile"}active{/if}" href="/profile">
                        &nbsp; <i class="fa-solid fa-user"></i>
                        &nbsp;Profil &nbsp;
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/api/auth/logout">
                        &nbsp; <i class="fa-solid fa-right-from-bracket"></i>
                        &nbsp;Odhlásit &nbsp;
                    </a>
                </li>
            {else}
                <li class="nav-item">
                    <a class="nav-link {if $activeTab == "/login"}active{/if}" href="/login">
                        &nbsp; <i class="fa-solid fa-sign-in"></i>
                        &nbsp; Přihlásit &nbsp;
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {if $activeTab == "/register"}active{/if}" href="/register">
                        &nbsp;<i class="fa-solid fa-user-plus"></i>
                        &nbsp; Registrovat &nbsp;
                    </a>
                </li>
            {/if}
        </ul>
    </div>

    <div id="hamburger">
        <button class="btn btn-secondary" onclick="utils.toggleNav();">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</nav>