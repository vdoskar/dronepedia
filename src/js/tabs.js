const tabs = {
    // nastaveni
    tabList: [],
    tabListLinks: [],
    tabSections: [],
    activeTab: null,
   
    init() {
        // pro kazdej seznam tabu najdu vsechny odkazy a ulozim je do pole
        this.tabList = document.querySelectorAll('.tabs');
        this.tabList.forEach(tabListItem => {
            const links = [];
            const tabLinks = tabListItem.querySelectorAll('a');
            tabLinks.forEach(link => {
                links.push(link);
            });
            this.tabListLinks.push(links);
        });

        this.tabSections = document.querySelectorAll('.tab-section');

        // nastavim aktivni tab pokud je v url adrese hash, jinak to bude prvni tab
        if (window.location.hash) {
            this.activeTab = (window.location.hash).substring(1);
        } else {
            this.activeTab = this.tabSections[0].id;
        }

        // schovam vsechny sekce krome aktivni
        this.tabSections.forEach(tabSection => {
            const tabSectionId = tabSection.id;
            if (this.activeTab != tabSectionId) {
                tabSection.style.display = 'none';
            }
        });

        // pridam dunkce na kliknuti na odkazy
        this.tabListLinks.forEach(tabLinks => {
            tabLinks.forEach(link => {
                link.onclick = () => this.toggleTab(link.hash);
            });
        });

    },

    toggleTab(tabId = "") {
        // pokud je tab prazdny, tak se nic nestane
        if (tabId == "") {
            return;
        }

        // schovam vsechny sekce krome aktivni
        this.tabSections.forEach(tabSection => {
            if (tabId != ("#" + tabSection.id)) {
                tabSection.style.display = 'none';
            } else {
                tabSection.style.display = 'flex';
            }
        });
    },
}