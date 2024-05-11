const droneForm = {
    availableParams: {
        vaha: "Váha",
        cena: "Cena",
        max_vyska: "Maximální výška",
        max_vzdalenost: "Maximální vzdálenost",
        max_rychlost: "Maximální rychlost",
        avg_doba_letu: "Průměrná doba letu",
        max_doba_letu: "Maximální doba letu",
        max_sila_vetru: "Maximální síla větru",
        gps: "Obsahuje GPS ve výbavě?",
        camera: "Obsahuje kameru ve výbavě?",
        obstacle_detection: "Obsahuje systém detekce překážek?",
        follow_me: "Podpora funkce Follow Me",
        return_home: "Podpora funkce Return Home",
        waypoints: "Podpora funkce Waypoints",
        live_stream: "Podpora funkce Live Stream",
        vr_glasses: "Podpora VR brýlí",
        battery_capacity: "Kapacita baterie",
        // more params can be added in the future
    },

    // render param buttons
    renderParamButtons() {
        const btnContainer = document.getElementById("paramButtons");
        for (const [key, value] of Object.entries(this.availableParams)) {
            // create buttons and append them to the container
            const button = document.createElement("button");
            button.classList.add("btn", "btn-secondary");
            button.style.margin = "0.25rem";
            button.innerText = value;
            button.setAttribute("data-param-add-button", key);
            button.addEventListener("click", (event) => {
                event.preventDefault();
                this.addParam(key, null);
            });

            // check if the param is already in the form
            const existingInput = document.querySelector("input[data-param=" + key + "]") ?? null;
            if (existingInput) {
                button.style.display = "none";
            }

            btnContainer.appendChild(button);
        }
    },

    // create a new param input field
    addParam(paramKey, paramValue) {
        // wrapper
        const wrapper = document.createElement("div");
        wrapper.classList.add('form-group');
        wrapper.classList.add('drone-param-item');
        wrapper.setAttribute("data-param", paramKey);

        // param input field
        const paramInput = document.createElement("input");
        paramInput.classList.add("form-control", "mb-2");
        paramInput.style.maxWidth = 'calc(100% - 60px)';
        paramInput.style.display = 'inline-block';
        paramInput.setAttribute("name", "params[" + paramKey + "]");
        paramInput.setAttribute("required", "true");
        paramInput.setAttribute("data-param", paramKey);
        paramInput.setAttribute("placeholder", droneForm.availableParams[paramKey]);
        if (paramValue) {
            paramInput.value = paramValue;
        }

        // remove param button
        const removeButton = document.createElement("button");
        removeButton.classList.add("btn", "btn-danger");
        removeButton.style.marginLeft = '0.5rem';
        removeButton.innerHTML = "<i class='fa-solid fa-trash-can'></i>";
        removeButton.onclick = (event) => {
            event.preventDefault();
            this.removeParam(paramKey)
        };

        // append elements
        wrapper.appendChild(paramInput);
        wrapper.appendChild(removeButton);
        document.getElementById("params").appendChild(wrapper);

        // hide from available params list
        const addButton = document.querySelector("button[data-param-add-button=" + paramKey + "]") ?? null;
        if (addButton) {
            addButton.style.display = "none";
        }
    },

    removeParam(paramKey) {
        document.querySelector("div.drone-param-item[data-param=" + paramKey + "]").remove();
        document.querySelector("button[data-param-add-button=" + paramKey + "]").style.display = "inline-block";
    }
}