<script lang="ts">
    let { offre = $bindable(), entreprise = $bindable() }= $props();
//'user_id','nom','siret','adresse','code_postal','ville','pays','num_tel'
//'nom','ent_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc'
</script>
    <div>
        <h1>{offre.nom}<br></h1>
        <h1>{entreprise.nom}<br></h1>
        <h1>{entreprise.adresse}, {entreprise.code_postal}, {entreprise.ville}, {entreprise.pays}<br></h1>
        <h1>{offre.nb_week} semaines de {offre.week_hour} heures, rémunérées {offre.paye_hour} chacune<br></h1>
        {#if offre.teletrav == true}
            <h1>télétravail possible<br></h1>
        {:else}
            <h1>tout en présentiel<br></h1>
        {/if}
        <h1>{offre.poste_desc}<br></h1>
        <br>
        <h1>{offre.profil_desc}<br></h1>
        <br>

    </div>

    <style>
        h1 {
            font-size: 2em;
        }
        div {
            border: 1px solid black;
            border-radius: 1%;
            margin-left: 20%;
            margin-right: 20%;
        }
    </style>