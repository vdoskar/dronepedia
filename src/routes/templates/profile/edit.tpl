<div class="content halfBody">
    <h1 class="text-center">Úprava profilu</h1>

    <div class="group">
        <a href="/profile?u={$currentUser.username}" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            &nbsp;Zpět na profil
        </a>
    </div>

    <div class="group">
        <h2>Osobní údaje</h2>
        <br>

        <form method="POST" class="authForm" action="/api/profile/contacts/change-name">
            <div class="form-group">
                <label for="new_name">Nové jméno (aktuální: <strong>{$currentUser.label}</strong>)</label>
                <input type="text" class="form-control" id="new_name" name="new_name" required placeholder="Sem napište své nové jméno">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Změnit jméno</button>
        </form>

        <br>
        <form method="POST" class="authForm" action="/api/profile/contacts/change-email">
            <div class="form-group">
                <label for="new_email">Nový email (aktuální: <strong>{$currentUser.email}</strong>)</label>
                <input type="email" class="form-control" id="new_email" name="new_email" required placeholder="Sem napište svůj nový e-mail">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Změnit email</button>
        </form>

        <br>
        <form method="POST" class="authForm" action="/api/profile/contacts/change-password">
            <div class="form-group">
                <label for="new_password">Nové heslo</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Sem napište své nové heslo">
            </div>
            <button type="submit" class="btn btn-primary mt-2">Změnit heslo</button>
        </form>

        <br><br>
        <h2>Přizpůsobení profilu</h2>

        <br>
        <form method="POST" class="authForm" action="/api/profile/settings/change">
            <div class="form-group">
                <label for="banner-input">Odkaz na banner profilu</label>
                <input type="text" class="form-control" name="banner" id="banner-input" value="{$settings.pic_banner|default:""}">
                <div id="bannerPreviewWrapper" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <label for="avatar-input">Odkaz na avatar profilu</label>
                <input type="text" class="form-control" name="avatar" id="avatar-input" value="{$settings.pic_profile|default:""}">
                <div id="avatarPreviewWrapper" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea class="form-control" name="bio" id="bio" rows="5">{$settings.bio|default:""}</textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Uložit změny</button>
        </form>

    </div>
</div>
<script>

    utils.previewImage(
        document.getElementById("avatar-input").value,
        "avatarPreviewWrapper"
    )

    utils.previewImage(
        document.getElementById("banner-input").value,
        "bannerPreviewWrapper"
    )

    const avatarInput = document.getElementById("avatar-input");
    const bannerInput = document.getElementById("banner-input");

    avatarInput.addEventListener("input", function() {
        utils.previewImage(
            avatarInput.value,
            "avatarPreviewWrapper"
        )

        if (!utils.regex.isValidUrl(avatarInput.value)) {
            avatarInput.setCustomValidity('Neplatná URL adresa');
        } else {
            avatarInput.setCustomValidity('');
        }
    })

    bannerInput.addEventListener("input", function() {
        utils.previewImage(
            bannerInput.value,
            "bannerPreviewWrapper"
        )

        if (!utils.regex.isValidUrl(bannerInput.value)) {
            bannerInput.setCustomValidity('Neplatná URL adresa');
        } else {
            bannerInput.setCustomValidity('');
        }
    })

</script>