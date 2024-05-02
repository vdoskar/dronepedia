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

        const activeLink = document.querySelector(`a[href="#${this.activeTab}"]`);
        activeLink.classList.add('active');

        // schovam vsechny sekce krome aktivni
        this.tabSections.forEach(tabSection => {
            const tabSectionId = tabSection.id;
            if (this.activeTab !== tabSectionId) {
                tabSection.style.display = 'none';
            }
        });

        // pridam funkce na kliknuti na odkazy
        this.tabListLinks.forEach(tabLinks => {
            tabLinks.forEach(link => {
                link.onclick = (event) => this.toggleTab(link);
            });
        });

    },

    toggleTab(link) {
        // zrusim aktivni tridu u vsech odkazu a nasledne nastavim aktivni tridu u kliknuteho odkazu
        this.tabListLinks.forEach(tabLinks => {
            tabLinks.forEach(link => {
                link.classList.remove('active');
            });
        });
        link.classList.add('active');

        // pokud je tab prazdny, tak se nic nestane
        if (link.hash === "") {
            return;
        }

        // schovam vsechny sekce krome aktivni
        this.tabSections.forEach(tabSection => {
            if (link.hash !== ("#" + tabSection.id)) {
                tabSection.style.display = 'none';
            } else {
                tabSection.style.display = 'flex';
            }
        });
    },
}