<div class="content halfBody">
    <h1>Nový dron</h1>

    <div class="group">
        <a href="/profile?u={$currentUser.username}" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            Zpět na profil
        </a>
    </div>

    <div class="group">
        <form method="POST" id="addDroneForm"  action="/api/profile/drones/add">
            <div class="form-group">
                <label for="drone_name">Název dronu</label>
                <input type="text"
                       class="form-control"
                       id="drone_name"
                       name="drone_name"
                       required
                >
            </div>

            <br>
            <div class="form-group">
                <label for="drone_description">Popis dronu</label>
                <textarea class="form-control"
                          id="drone_description"
                          name="drone_description"
                          required
                ></textarea>
            </div>

            <br>
            <div class="form-group">
                <label for="drone_img">URL na obrázek dronu</label>
                <input type="text"
                       class="form-control"
                       id="drone_img"
                       name="drone_img"
                       required
                >
                <div id="droneImgPreviewWrapper" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <label for="params">Přidat parametry dronu</label>
                <div id="params"></div>
                <div id="paramButtons" class="mt-2"></div>
            </div>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Přidat dron
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

    // TODO: remove this script before prod
    document.getElementById("drone_name").value = "DJI Mini 2 SE";
    document.getElementById("drone_description").value = "Mám ten dron strašně rád uwu";
    document.getElementById("drone_img").value = "https://cdn.mos.cms.futurecdn.net/BgUuYtgcrLjPoETNiPBGUU-1200-80.jpg";
    document.getElementById("drone_img").dispatchEvent(new Event("input"));
</script>