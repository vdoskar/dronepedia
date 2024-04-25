<header style="background-image: url('{$bgImg}');">
    <h1 class="text-center">
        {$title}
    </h1>
</header>

<div class="content halfBody">
    <h2>Drony: Revoluce ve vzduchu</h2>
    <p>Drony, nebo-li bezpilotní letouny, představují revoluční spojení moderní technologie a letectví, které transformuje mnoho aspektů současného života. Od průmyslových inspekcí až po zábavné závody a profesionální fotografii, drony si našly své místo ve 21. století, otevírajíce nové možnosti v mnoha odvětvích.</p>
    <br>
    <h4>Co jsou drony?</h4>
    <p>Drony jsou autonomní, dálkově řízené nebo předem naprogramované letouny, které se mohou pohybovat bez lidského pilota na palubě. Jejich účel a podoba se liší v závislosti na kategorii a účelu, pro který jsou navrženy. Svoji popularitu získaly díky své schopnosti provádět širokou škálu úkolů, od průzkumu a monitorování po zábavné aktivity a profesionální služby.</p>
    <hr>
    <br>
    <h3>Kategorie dronů</h3>
    <p>Každý dron spadá do své vlastní kategorie. Kromě formálních leteckých kateogií (OPEN, ..) lze drony řadit i podle jejich využití a náročnosti na provoz.</p>
    <div class="tabs">
        <a class="tab" href="#tab_miniDrones">Mini drony</a>
        <a class="tab" href="#tab_fpvDrones">FPV drony</a>
        <a class="tab" href="#tab_profiDrones">Profesionální drony</a>
        <a class="tab" href="#tab_armyDrones">Armádní drony</a>
        <a class="tab" href="#tab_specialDrones">Speciální drony</a>
    </div>
    <br>
    <section id="droneCategories">
        {include file="drones_categories.tpl"}
    </section>
    <hr>
    <br>
    <h4>Drony a budoucnost</h4>
    <p>Vývoj dronů do budoucna je neustále v pohybu, přičemž technologické inovace a pokroky otevírají nové možnosti a možnosti využití. Jedním z klíčových trendů je integrace umělé inteligence do dronů, což umožňuje těmto zařízením provádět složitější úkoly autonomně a efektivněji.</p>
    <p>Umělá inteligence umožňuje dronům analyzovat data v reálném čase, rozpoznávat vzory a objekty, a reagovat na různé situace bez potřeby neustálé lidské interakce. To může vést k vývoji autonomních dronů, které jsou schopny provádět širokou škálu úkolů, od průzkumu a monitorování po dodávání zásob a záchranné operace.</p>
    <p>Dalším směrem vývoje je miniaturizace a zlepšování výkonu baterií, což umožní dronům létat déle a dále bez potřeby častého dobíjení. Tím se zvýší jejich efektivita a využití v různých odvětvích, jako je například průmyslová inspekce, zemědělství a doprava.</p>
</div>

<script>
    tabs.init();
</script>