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


<main class="page-container">
    <section class="heading">
        <h1>Vous avez <b><span>{postulations.length} nouvelles</span> candidatures</b> !</h1>
        <p>Consultez-les maintenant.</p>
    </section>
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

    .page-container {
        padding: 2rem 1rem 3rem;
        max-width: 1040px;
        margin: 0 auto;
    }

    .heading {
        text-align: center;
        margin: 1rem 0 2rem;
    }

    .heading h1 {
        margin: 0;
        font-size: clamp(1.4rem, 2.7vw, 2.1rem);
        color: var(--ink-900);
    }

    .heading h1 span {
        color: var(--primary-600);
    }

    .heading p {
        margin: 0.5rem 0 0;
        color: var(--ink-600);
    }

    div.main {
        padding: 1.2rem 1.4rem;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        border-radius: 14px;
        border: 1px solid var(--border-200);
        background: #fff;
        margin: 0 0 1rem 0;
    }

    .actions {
        display: flex;
        justify-content: center;
        gap: 0.8rem;
        margin-top: 0.8rem;
    }

    .close {
        border: 1px solid var(--border-200);
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0.35rem 0.8rem;
        border-radius: 8px;
        background: #f8fafc;
        transition: background 0.15s, transform 0.15s;
    }

    .close:hover {
        background-color: #eef2ff;
        transform: translateY(-1px);
    }

    .cv-link {
        color: var(--primary-600);
    }
</style>

