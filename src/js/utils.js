const utils = {
    // create a slug from a text
    slugify(text) {
        const charMap = {
            'á': 'a', 'č': 'c', 'ď': 'd', 'é': 'e', 'ě': 'e', 'í': 'i', 'ň': 'n', 'ó': 'o', 'ř': 'r', 'š': 's', 'ť': 't', 'ú': 'u', 'ů': 'u', 'ý': 'y', 'ž': 'z',
            'Á': 'A', 'Č': 'C', 'Ď': 'D', 'É': 'E', 'Ě': 'E', 'Í': 'I', 'Ň': 'N', 'Ó': 'O', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ú': 'U', 'Ů': 'U', 'Ý': 'Y', 'Ž': 'Z'
        };

        // normalize and convert to lowercase
        text = text.normalize('NFD').replace(/[\u0300-\u036F]/g, '').toLowerCase();

        // replace spaces and special characters with "-"
        text = text.replace(/[^\w\s]/g, '-')
            .replace(/\s+/g, '-');

        // replace diacritics with their base characters
        text = text.replace(/./g, c => charMap[c] || c);

        if (text.startsWith('-'))
            text = text.slice(1);

        if (text.endsWith('-'))
            text = text.slice(0, -1);

        return text;
    },

    // preview image from URL
    previewImage(imageUrl, wrapperElementId) {
        const imageElement = document.createElement('img');
        imageElement.src = imageUrl;
        imageElement.alt = 'Náhled obrázku';
        imageElement.classList.add('img-fluid');

        imageElement.onerror = function() {
            imageElement.alt = "Obrázek není k dispozici";
            imageElement.src = "";
        };

        const wrapperElement = document.getElementById(wrapperElementId);
        if (wrapperElement) {
            wrapperElement.innerHTML = '';
            wrapperElement.appendChild(imageElement);
        } else {
            console.error("Wrapper element with id '" + wrapperElementId + "' not found.");
        }
    },

    // set the title of the page based on the content
    setPageTitle() {
        // Homepage
        if (window.location.pathname === "/") {
            document.title = "Domů | DronePedia";
            return;
        }

        // any other page
        if (document.querySelector("h1")) {
            document.title = document.querySelector("h1").innerText + " | DronePedia";
            return;
        }

        // 404 page
        document.title = "Nenalezeno | DronePedia";
    },

    // for testing regex
    regex: {
        isValidEmail(email) {
            const regex = new RegExp('^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$');
            return regex.test(email)
        },
        isValidUrl(url) {
            const regex = new RegExp('^(http|https):\\/\\/[a-zA-Z0-9]+(\\.[a-zA-Z0-9]+)*(:[0-9]+)?(\\/\\S*)?$', 'i');
            return regex.test(url);
        },
    }
}