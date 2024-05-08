<div class="content halfBody">
    <h1 class="text-center">Nový dron</h1>

    <div class="group">
        <a href="/profile?u={$currentUser.username}" class="btn btn-secondary">
            <i class="fa-solid fa-circle-left"></i>
            Zpět na profil
        </a>
    </div>

    <div class="group">
        <form method="POST" id="form" action="/api/profile/drones/add-drone">
            <div class="form-group">
                <label for="drone_name">Název dronu</label>
                <input type="text"
                       class="form-control"
                       id="drone_name"
                       name="drone_name"
                       required
                >
            </div>
            <div class="form-group">
                <label for="drone_description">Popis dronu</label>
                <textarea class="form-control"
                          id="drone_description"
                          name="drone_description"
                          required
                ></textarea>
            </div>
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
            <div class="form-group">
                <label for="params">Parametry dronu</label>
                <div id="params"></div>
                <div id="paramButtons" class="mt-2"></div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Přidat dron
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    const droneImgInput = document.getElementById("drone_img");
    droneImgInput.addEventListener("input", function() {
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

</script>

<script>

    const droneForm = {

        availableParams: {
            max_vyska: "Maximální výška",
            max_vzdalenost: "Maximální vzdálenost",
            max_rychlost: "Maximální rychlost",
            vaha: "Váha",
            cena: "Cena",
            avg_doba_letu: "Průměrná doba letu",
            max_doba_letu: "Maximální doba letu",
            max_nosnost: "Maximální nosnost",
            max_sila_vetru: "Maximální síla větru",
            // more params can be added in the future
        },

        // render param buttons
        renderParamButtons() {
            const paramButtons = document.getElementById("paramButtons");
            for (const [key, value] of Object.entries(this.availableParams)) {
                const button = document.createElement("button");
                button.classList.add("btn", "btn-secondary");
                button.style.margin = 0.25 + "rem";
                button.innerText = value;
                button.setAttribute("data-param-add-button", key);
                button.addEventListener("click", this.addParam);
                paramButtons.appendChild(button);
            }
        },

        // create a new param input field
        addParam(event) {
            event.preventDefault();

            const param = event.target.getAttribute("data-param-add-button");
            const paramInput = document.createElement("input");
            paramInput.classList.add("form-control", "mb-2");
            paramInput.setAttribute("name", param);
            paramInput.setAttribute("placeholder", droneForm.availableParams[param]);
            document.getElementById("params").appendChild(paramInput);

            // also a remove param button
            const removeButton = document.createElement("button");
            removeButton.classList.add("btn", "btn-danger", "mr-2", "mb-2");
            removeButton.innerText = "X";
            removeButton.setAttribute("data-param-rm-button", param);
            removeButton.addEventListener("click", this.removeParam);
            document.getElementById("params").appendChild(removeButton);

            // hide from available params list
            document.querySelector("button[data-param-add-button=" + param + "]").style.display = "none";
        },

        // remove param input field
        removeParam(event) {
            event.preventDefault();

            const param = event.target.getAttribute("data-param-rm-button");
            const paramInput = document.querySelector("input[name=" + param + "]");
            paramInput.remove();

            // show the button again
            document.querySelector("button[data-param-add-button=" + param + "]").style.display = "inline-block";
        },

        // submit form
        submit(event) {

            // get all params
            const params = this.availableParams.forEach(param => {
                const value = document.querySelector("input[name=" + param + "]").value;
                console.log(param, value);
            });

            const formData = new FormData(document.getElementById("form"));
            formData.append("params", JSON.stringify(params));
            console.log(formData.get("params"));

            event.preventDefault();
        },
    }

    droneForm.renderParamButtons();

    // submitting the form
    document.getElementById("form").addEventListener("submit", (event) => {
        droneForm.submit(event)
    });
</script>