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

    // TODO: render param buttons for edit form
    renderParamButonsEdit() {

    },

    // create a new param input field
    addParam(event) {
        event.preventDefault();

        // wrapper
        const wrapper = document.createElement("div");
        wrapper.classList.add('form-group');
        wrapper.classList.add('drone-param-item');

        // param input field
        const param = event.target.getAttribute("data-param-add-button");
        const paramInput = document.createElement("input");
        paramInput.classList.add("form-control", "mb-2");
        paramInput.style.maxWidth = 'calc(100% - 60px)';
        paramInput.style.display = 'inline-block';
        paramInput.setAttribute("name", "params[" + param + "]");
        paramInput.setAttribute("required", "true");
        paramInput.setAttribute("data-param", param);
        paramInput.setAttribute("placeholder", droneForm.availableParams[param]);

        // also a remove param button
        const removeButton = document.createElement("button");
        removeButton.classList.add("btn", "btn-danger");
        removeButton.style.marginLeft = '0.5rem';
        removeButton.innerHTML = "<i class='fa-solid fa-trash-can'></i>";
        removeButton.onclick = () => {
            wrapper.remove();
            // show the button again
            document.querySelector("button[data-param-add-button=" + param + "]").style.display = "inline-block";
        }

        wrapper.appendChild(paramInput);
        wrapper.appendChild(removeButton);
        document.getElementById("params").appendChild(wrapper);

        // hide from available params list
        document.querySelector("button[data-param-add-button=" + param + "]").style.display = "none";
    },
}