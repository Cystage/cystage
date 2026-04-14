<script lang="ts">
    import Header from '@/components/Header.svelte';  
    import AppHead from '@/components/AppHead.svelte';
    import { createInertiaApp } from '@inertiajs/svelte';
    import OffreDeStage from './OffreDeStage.svelte';
    import Modal from './Modal.svelte';
    import Login from './Login.svelte';

    import logo from './img/logo.png';

    let { entreprises, offres }= $props();

    let showModal= $state(false);
    let showLogin= $state(false);

    function entofoffre(e,o){
        return e[o.ent_id-1].nom;
    }

    function modal() {
        showModal=!showModal;
    }

    function login() {
        showLogin=!showLogin;
    }

    let ListePhraseInspirante = [
        "Trouvez votre futur ici",
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>


<Header bind:showModal={showModal} bind:showLogin={showLogin}/>
<main>
    <div class="hero">
        <img src={logo} alt="Le logo Cystage" width="260">
        <p class="phrase">{phraseInspirante}</p>
    </div>

    <div class="offres-list">
        {#each offres as o}
            <OffreDeStage offre={o} entreprise={entreprises[o.ent_id-1]}/>
        {/each}
    </div>
</main>

{#if showModal}
    <Modal bind:showModal={showModal}/>
{/if}

{#if showLogin}
    <Login bind:showLogin={showLogin}/>
{/if}

<style>
    * {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 1rem;
    }

    .hero {
        text-align: center;
        margin-bottom: 2rem;
    }

    .hero img {
        margin-bottom: 1rem;
    }

    .phrase {
        font-size: 1.1rem;
        color: #64748b;
        font-style: italic;
    }

    .offres-list {
        width: 100%;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
</style>