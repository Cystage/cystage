<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import OffreDeStage from './OffreDeStage.svelte';

    let { offre }= $props();


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
    <p>Trouver votre futur ici</p>

    <OffreDeStage {offre}/>

    <style>
        h1 {
            font-size: 2em;
        }
    </style>

</center>