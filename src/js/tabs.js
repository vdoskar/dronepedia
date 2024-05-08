const tabs = {
    // nastaveni
    tabList: [],
    tabListLinkElements: [],
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
            this.tabListLinkElements.push(links);
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
        this.tabListLinkElements.forEach(tabLinksElements => {
            tabLinksElements.forEach(tabLinkElement => {
                tabLinkElement.onclick = (event) => {
                    event.preventDefault();
                    this.toggleTab(tabLinkElement);
                }
            });
        });

    },

    toggleTab(linkElement) {
        // zrusim aktivni tridu u vsech odkazu a nasledne nastavim aktivni tridu u kliknuteho odkazu
        this.tabListLinkElements.forEach(tabLinksElements => {
            tabLinksElements.forEach(tabLinkElement => {
                tabLinkElement.classList.remove('active');
            });
        });
        linkElement.classList.add('active');

        // zmenim hash v url adrese
        window.history.pushState(null, null, linkElement.hash);

        // pokud je tab prazdny, tak se nic nestane
        if (linkElement.hash === "") {
            return;
        }

        // schovam vsechny sekce krome aktivni
        this.tabSections.forEach(tabSection => {
            if (linkElement.hash !== ("#" + tabSection.id)) {
                tabSection.style.display = 'none';
            } else {
                tabSection.style.display = 'flex';
            }
        });
    },
}