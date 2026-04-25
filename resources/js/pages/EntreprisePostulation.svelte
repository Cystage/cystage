<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';
    let { postulations=[] } = $props();
    
    function supprimer(id: number) {
        if (confirm("Etes vous sûr de voulour refuser ce candidat?")) {
            router.delete(`/postulation/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                }
            });
        }
    }
</script>

<AppHead title="Postulations"/>

<Header/>
<main class="page-container">
    <center>
        <br><br><br><br>
        <h1>Vous avez <b><span style="color:blue">{postulations.length} nouvelles</span> candidatures!</b></h1>
        <p>Consultez les maintenant!</p>
        <br><br>
    </center>
    {#each postulations as p}
        <div class="main">
            <h2>{p?.etudiant?.nom || "Nom de l'étudiant"} {p?.etudiant?.prenom || ""}</h2>
            <hr><br>
            <h3>{p?.motiv || "Motivation de l'étudiant"}</h3>
            <br>
            <h3>Voir cv : <span style="color:blue"><a href="/storage/{p.path}">ici</a></span></h3>
            <center>
              <button class="close" onclick={() => console.log(p)}><p>✅</p></button>
                <button class="close" onclick={() => supprimer(p.offre_id)}><p>❌</p></button>
            </center>
            </div>
    {/each}
</main>

<style>
        div.main {
            padding: 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-left: 15%;
            margin-right: 15%;
            margin-bottom: 30px;
            margin-top: 30px;
        }


        .close {
        
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: background 0.15s;
            margin-left: 40px;
        }

        .close:hover {
             background-color: rgba(201, 201, 201, 0.567);
             color: #1e293b;
        }

        h1 {
            font-size: 3em;

        }

        h2 {
            font-size: 1.5em;
        }

        p  {
            font-size: 1.2em;
        }
</style>

