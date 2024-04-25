<div class="group">
    <ul class="navbar-nav">
        <a class="navbar-brand mb-1 mt-1" style="margin-right: 4rem" href="/" title="Domů | DronePedia">
            <img src="/src/assets/logo.webp" data-copyright="https://www.vectorstock.com/royalty-free-vector/drone-icon-in-trendy-flat-style-isolated-vector-36097984" style="max-width: 60px;">
        </a>
        {foreach $menu as $link => $item}
            {if $item.inNav}
                <li class="nav-item" title="{$item.label} | DronePedia">
                    <a class="nav-link {if $activeTab == $link}active{/if}" href="{$link}">
                        {$item.label}
                    </a>
                </li>
            {/if}
        {/foreach}
    </ul>
</div>
<div class="group">
    <ul class="navbar-nav">
        {if $loggedIn}
            <li class="nav-item">
                <a class="nav-link" href="/contribute">
                    <i class="fa-regular fa-square-plus"></i>
                    Přidat
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/profile">
                    <i class="fa-solid fa-user"></i>
                    Profil
                </a>
            </li>
        {else}
            <li class="nav-item">
                <a class="nav-link" href="/login">
                    <i class="fa-solid fa-sign-in"></i>
                    Přihlásit
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/register">
                    <i class="fa-solid fa-user-plus"></i>
                    Registrovat
                </a>
            </li>
        {/if}
    </ul>
</div>