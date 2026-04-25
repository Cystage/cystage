<script lang="ts">
    import Modal from "./Modal.svelte";
    import "./ModalPoste.svelte";
    import ModalPoste from "./ModalPoste.svelte";
    import { createInertiaApp,page } from '@inertiajs/svelte';

    let { offre = $bindable(), entreprise = $bindable(), doms , skills, etudiant = $bindable()}= $props();
//'user_id','nom','siret','adresse','code_postal','ville','pays','num_tel'
//'nom','ent_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc'
    let showModalPostuler = $state(false);
    function modalPostuler() {
        console.log("test");
        showModalPostuler=!showModalPostuler;
    }

    let user = $derived($page.props.auth?.user);


</script>
    <div class="main">
       <header>
        <h1><b>{offre.nom}</b></h1>
        de {entreprise.nom}
         <div class="location">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          <p class="information">{entreprise.adresse}, {entreprise.code_postal}, {entreprise.ville}, {entreprise.pays}<br></p>
         </div>
       </header>
       <hr>
       <h2>Informations utiles: <br></h2>
            <p>Durée de travail : {offre.nb_week} semaines</p>
            <p>par semaine: {offre.week_hour}h payées {offre.paye_hour} € </p>
            <p>Télétravail: {#if offre.teletrav}✅{:else}❌{/if}</p>
       <br>

        <p>Tâches: {offre.poste_desc}<br></p>
        <br>
        <p>Qualités requises: {offre.profil_desc}<br></p>
        <br>
        <p>Pour plus d'information, appeler le {entreprise.num_tel}<p>
        <br>
        <p>Compétences demandées :<p>
        <p> {#each skills as s}
            {s.name}&nbsp;
        {/each}</p>
        <br>
        {#each doms as d}
            <p>#{d.name}</p>
        {/each}

        {#if user.id ==3}
            <input type="submit" class="button" value="Postuler" onclick={modalPostuler}/>

            {#if showModalPostuler}
                <ModalPoste etudiant={etudiant} bind:showModalPostuler={showModalPostuler} offre={offre}/>
            {/if}
        {/if}


    </div>

    <style>
        h1 {
            font-size: 2em;
        }
        h2 {
            font-size: 1.2em;
        }
        div.main {
            padding: 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-left: 15%;
            margin-right: 15%;
        }

        div.location {
            display: flex;
            align-items: left;
            vertical-align: bottom;
            gap:5px;
        }
        div.location svg {
            margin-top: 2px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.7rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
            margin-top: 0.25rem;
        }

        p.information {
            color:grey;
        }

        @media (max-width: 600px) {
            div.main {
                margin:0;
            }
        }
    </style>