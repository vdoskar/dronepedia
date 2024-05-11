<div class="content halfBody">
    <h1>Upravit dron</h1>

    <div class="group">
        <a href="/profile?u={$currentUser.username}" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            &nbsp;Zpět na profil
        </a>
        <br>
        <br>
        <form action="/api/profile/drones/delete" method="post">
            <input type="hidden" name="drone_id" value="{$drone.id}">
            <button class="btn btn-danger">
                <i class='fa-solid fa-trash-can'></i>
                &nbsp;Smazat dron
            </button>
        </form>
    </div>

    <div class="group">
        <form method="POST" id="addDroneForm" action="/api/profile/drones/edit">
            <div class="form-group">
                <label for="drone_name">Název dronu</label>
                <input type="text"
                       class="form-control"
                       id="drone_name"
                       name="drone_name"
                       value="{$drone.drone_name|default:""}"
                       required
                >
            </div>

            <br>
            <div class="form-group">
                <label for="drone_description">Popis dronu</label>
                <textarea class="form-control" id="drone_description" name="drone_description"
                          required>{$drone.drone_description|default:""}</textarea>
            </div>

            <br>
            <div class="form-group">
                <label for="drone_img">URL na obrázek dronu</label>
                <input type="text"
                       class="form-control"
                       id="drone_img"
                       name="drone_img"
                       value="{$drone.drone_img|default:""}"
                       required
                >
                <div id="droneImgPreviewWrapper" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <label for="params">Přidat parametry dronu</label>
                <div id="params">
                    {if $drone.drone_params|count > 0}
                        {foreach $drone.drone_params as $key => $value}
                            <script>
                                droneForm.addParam("{$key}", "{$value}");
                            </script>
                        {/foreach}
                    {/if}
                </div>
                <div id="paramButtons" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <input type="text" value="{$drone.id}" name="drone_id" hidden>
                <button type="submit" class="btn btn-primary">
                    Upravit dron
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    const droneImgInput = document.getElementById("drone_img");
    droneImgInput.addEventListener("input", function () {
        utils.previewImage(
            droneImgInput.value,
            "droneImgPreviewWrapper"
        )

        if (!utils.regex.isValidUrl(droneImgInput.value)) {
            droneImgInput.setCustomValidity('Neplatná URL adresa');
        } else {
            droneImgInput.setCustomValidity('');
        }
    })

    droneForm.renderParamButtons();
</script>