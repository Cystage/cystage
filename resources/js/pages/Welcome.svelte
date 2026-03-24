<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { createInertiaApp } from '@inertiajs/svelte';
    import OffreDeStage from './OffreDeStage.svelte';

    let { offre }= $props();

    let ListePhraseInspirante = ["Trouvez votre futur ici",
        "Débutez votre carrière profesionnelle!",
        "Votre futur commence aujourd'hui",
        "L'avenir est entre vos mains",
        "Reprenez votre destin en main",
        "Découvrez le monde profesionnel!",
        "N'arrêtez jamais d'apprendre!",
        "Construisons la génération de demain!",
    ]

    const phraseInspirante = ListePhraseInspirante[Math.floor(Math.random() * ListePhraseInspirante.length)];


</script>

<AppHead title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</AppHead>

<header>
    <p>Cy stage </p>

    <button>Publier une offre</button>
</header>

<center>
    <h1>Hello CyStage ! </h1><br>
    <p>{phraseInspirante}</p>
    <br>
    {#each offre as o}
        
        <OffreDeStage offre={o}/>
    {/each}

    <style>
        h1 {
            font-size: 2em;
        }
    </style>

</center>