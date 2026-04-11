<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
       import { createInertiaApp } from '@inertiajs/svelte';
    import OffreDeStage from './OffreDeStage.svelte';
    import Modal from './Modal.svelte';
    import Login from './Login.svelte';

    import logo from './img/logo.png';

    let { offres }= $props();

    let showModal= $state(false);

    let showLogin= $state(false);

    function modal() {
        showModal=!showModal;
    }

    function login() {
        showLogin=!showLogin;
    }

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>

<header>
    <p>Cy stage </p>

    <button onclick={modal}>Publier une offre</button>

    <a class="profile-link" href="/profil">Mon profil</a>
    <button onclick={login}>login</button>

    <div class="modal">
        {#if showModal}
            <Modal bind:showModal={showModal}/>
        {/if}
    </div>

    <div class="login">
        {#if showLogin}
            <Login bind:showLogin={showLogin}/>
        {/if}
    </div>
</header>

<center>
    <img src={logo} alt="Le logo Cystage" width="300em">
    <p>{phraseInspirante}</p>
    <br>
    {#each offres as o}
        
        <OffreDeStage offre={o}/>
    {/each}

    <style>
        * {
            font-family: "Plus Jakarta Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        h1 {
            font-size: 2em;
        }

        .modal {
            height: 100%;
            width: 100%;
        }

        .profile-link {
            margin-left: auto;
            text-decoration: none;
            font-weight: 600;
            color: #2563eb;
        .login {
            height: 100%;
            width: 100%;
        }
    </style>

</center>