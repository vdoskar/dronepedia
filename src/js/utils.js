const utils = {
    slugify(text) {
        const charMap = {
            'á': 'a', 'č': 'c', 'ď': 'd', 'é': 'e', 'ě': 'e', 'í': 'i', 'ň': 'n', 'ó': 'o', 'ř': 'r', 'š': 's', 'ť': 't', 'ú': 'u', 'ů': 'u', 'ý': 'y', 'ž': 'z',
            'Á': 'A', 'Č': 'C', 'Ď': 'D', 'É': 'E', 'Ě': 'E', 'Í': 'I', 'Ň': 'N', 'Ó': 'O', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ú': 'U', 'Ů': 'U', 'Ý': 'Y', 'Ž': 'Z'
        };

        // 1. Normalize and convert to lowercase
        text = text.normalize('NFD') // Normalize for diacritics
            .replace(/[\u0300-\u036F]/g, '') // Remove accentuation
            .toLowerCase();

        // 2. Replace spaces and special characters with hyphen (-)
        text = text.replace(/[^\w\s]/g, '-')
            .replace(/\s+/g, '-');

        // 3. Replace diacritics with their base characters
        text = text.replace(/./g, c => charMap[c] || c);

        if (text.startsWith('-')) {
            text = text.slice(1);
        }

        if (text.endsWith('-')) {
            text = text.slice(0, -1);
        }

        return text;
    },
}