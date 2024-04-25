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
        <a class="tab" href="#tab_armyDrones">Armádní a vojenské drony</a>
    </div>
    <br>
    <section id="droneCategories">
        {include file="drones_categories.tpl"}
    </section>
</div>

<script>
    tabs.init();
</script>