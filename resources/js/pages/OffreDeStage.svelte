<script lang="ts">
    let { offre = $bindable() }= $props();
//'nom','ent_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc'
</script>
    <div>
        <h1>{offre.nom}<br></h1>
        <h1>{offre.nb_week} semaines de {offre.week_hour} heures, rémunérées {offre.paye_hour} chacune<br></h1>
        <h2>{offre.teletrav}</h2>
        <br>
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