const editor = {
    init(elementId) {
        const elementToReplace = document.getElementById(elementId);
        if (!elementToReplace) {
            return;
        }

        CKEDITOR.replace(elementToReplace);
    },

    getData(editorInstanceName) {
        const editorInstance = CKEDITOR.instances[editorInstanceName];
        if (!editorInstance) {
            return "No editor instance found";
        }

        const data = editorInstance.getData();
        if (!data) {
            return "No data available";
        }

        return data;
    }
}