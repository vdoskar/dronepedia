const dialog = {

    isDialogOpen: false,

    // Show dialog
    open(elementContent) {
        if (this.isDialogOpen) {
            return;
        }

        const dialog = document.createElement('div');
        dialog.id = 'dialog';
        dialog.innerHTML = elementContent;

        // css style
        dialog.style.transition = 'all 0.3s ease-in-out';
        dialog.style.position = 'fixed';
        dialog.style.top = '0';
        dialog.style.left = '0';
        dialog.style.width = '100%';
        dialog.style.height = '100%';
        dialog.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        dialog.style.display = 'flex';
        dialog.style.justifyContent = 'center';
        dialog.style.alignItems = 'center';
        dialog.style.zIndex = '1000';
        dialog.style.overflow = 'auto';
        dialog.style.transform = 'scale(0)';

        // close dialog button
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>';
        closeButton.style.position = 'absolute';
        closeButton.style.top = '2rem';
        closeButton.style.right = '2rem';
        closeButton.style.padding = '5px 10px';
        closeButton.style.border = 'none';
        closeButton.style.backgroundColor = 'red';
        closeButton.style.color = 'white';
        closeButton.style.cursor = 'pointer';
        closeButton.style.borderRadius = "var(--borderRadiusPrimary)";
        closeButton.addEventListener('click', () => this.close());

        dialog.appendChild(closeButton);
        document.body.appendChild(dialog);

        // animate dialog
        setTimeout(() => {
            dialog.style.transform = 'scale(1)';
            this.isDialogOpen = true;
        }, 100);
    },

    close() {
        const dialog = document.getElementById('dialog');
        dialog.style.transform = 'scale(0)';
        setTimeout(() => {
            dialog.remove();
            this.isDialogOpen = false;
        }, 200);
    },

    initKeydownListener() {
        const that = this;
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && that.isDialogOpen) {
                that.close();
            }
        });
    }
}