<script lang="ts">
    import Modal from "./Modal.svelte";
    import "./ModalPoste.svelte";
    import ModalPoste from "./ModalPoste.svelte";
    import { createInertiaApp,page } from '@inertiajs/svelte';

    let { offre = $bindable(), entreprise = $bindable(), doms , skills }= $props();
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
        <h1>{offre.nom}<br></h1>
         <div class="location">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          <p>{entreprise.adresse}, {entreprise.code_postal}, {entreprise.ville}, {entreprise.pays}<br></p>
        <p>de {entreprise.nom}<br></p>
         </div>
       </header>
      <br><br>
      <p>{offre.nb_week} semaines de {offre.week_hour} heures, taux horaire de {offre.paye_hour} € <br></p>
        {#if offre.teletrav == true}
            <p>télétravail possible<br></p>
        {:else}
            <p>tout en présentiel<br></p>
        {/if}
        <p>{offre.poste_desc}<br></p>
        <br>
        <p>{offre.profil_desc}<br></p>
        <br>
        <p>Pour plus d'information, appeler le {entreprise.num_tel}<p>
        <br>
        {#each skills as s}
            <p>{s.name}</p>
        {/each}
        <br>
        {#each doms as d}
            <p>{d.name}</p>
        {/each}
        <input type="submit" class="button" value="Postuler" onclick={modalPostuler}/>

        {#if showModalPostuler && user.id==1}
            <ModalPoste bind:showModalPostuler={showModalPostuler} offre={offre}/>
        {/if}


    </div>

    <style>
        h1 {
            font-size: 2em;
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
    </style>