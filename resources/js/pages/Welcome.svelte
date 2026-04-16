<script lang="ts">
    import Header from '@/components/Header.svelte';  
    import AppHead from '@/components/AppHead.svelte';
    import { createInertiaApp,page } from '@inertiajs/svelte';
    import OffreDeStage from './OffreDeStage.svelte';
    import Modal from './Modal.svelte';
    import Login from './Login.svelte';

    import logo from './img/logo.png';

    let { entreprises=$bindable(), offres, competences=$bindable(), domaines=$bindable(), links_offres_competences, links_offres_domaines }= $props();

    let showModal= $state(false);
    let showLogin= $state(false);

    function getdoms(o,o_d,d){
        let doms = $state([]);
        for(let l of o_d){
            if(o.id == l.offre_id){
                doms.push(d[l.dom_id-1]);
            }
        }
        return doms;
    }

    function getent(o,ents){
        for(let e of ents){
            if(o.ent_id == e.id){
                return e;
            }
        }
    }

    function getskills(o,o_c,c){
        let skills = $state([]);
        for(let l of o_c){
            if(o.id == l.offre_id){
                skills.push(c[l.skill_id-1]);
            }
        }
        return skills;
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

    let user = $derived($page.props.auth?.user);
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
    {#if user}
    <div class="offres-list">
        {#if user.role_id == 2}
            {#each offres as o}
                <OffreDeStage offre={o} entreprise={entreprises} doms={getdoms(o,links_offres_domaines,domaines)} skills={getskills(o,links_offres_competences,competences)}/>
            {/each}
        {:else}
            {#each offres as o}
                <OffreDeStage offre={o} entreprise={getent(o,entreprises)} doms={getdoms(o,links_offres_domaines,domaines)} skills={getskills(o,links_offres_competences,competences)}/>
            {/each}
        {/if}
    </div>
    {/if}
</main>

{#if showModal}
    <Modal bind:showModal={showModal} bind:domaines={domaines} bind:competences={competences} bind:entreprises={entreprises} user={user}/>
{/if}

{#if showLogin}
    <Login bind:showLogin={showLogin}/>
{/if}

<footer>
<center>
    <p>© CyStage Tout droit réservé 2026</p>
</center>

</footer>

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

    footer {
        background-color: rgb(223, 223, 223);
        padding-top: 50px;
        justify-content: center;
    }


</style>