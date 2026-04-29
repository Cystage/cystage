<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm } from '@inertiajs/svelte';
    import { router } from '@inertiajs/svelte';
    let { postulations=[], profil} = $props();
    let nomOffres = $state({});
    function supprimer(id: number) {
        if (confirm("Etes vous sûr de voulour refuser ce candidat?")) {
            router.delete(`/postulation/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                }
            });
        }
    }


    function accepter(id: number) {
        if (confirm("Etes vous sûr de vouloir accepter ce candidat?")) {
            router.post(`/accepte/${id}`, {
                preserveScroll: true,
            });
        }
    }
    
    async function getNom(node: HTMLElement, id: number) {
        if (nomOffres[id]) return;
        const resp = await fetch(`/getNomOffre/${id}`);
        const data = await resp.json();
        nomOffres[id] = data.nom;
    }

</script>

<AppHead title="Postulations"/>


<main class="page-container">
    <section class="heading">
        {#if $profil?.type ==2}
            <h1>Vous avez <b><span>{postulations.length} nouvelles</span> candidatures</b> !</h1>
        {:else}
            <h1>Vous avez fait <b><span>{postulations.length} postulations</span></b> !</h1>
        {/if}
        <p>Consultez-les maintenant.</p>
    </section>
    {#each postulations as p}
        <div class="main" use:getNom={p.offre_id}>
            {#if $profil?.type ==2}
                <center><h2>{p?.etudiant?.nom || "Nom de l'étudiant"} {p?.etudiant?.prenom || ""}</h2></center>
            {:else}
                <center><h2>{nomOffres[p.offre_id]}</h2></center>
            {/if}
            <hr><br>

            <h3>Lettre de motivation : </h3>
            <h4>{p?.motiv || "Motivation de l'étudiant"}</h4>
            <br>
            <div class="cv">
                <h3>Voir cv : <span style="color:blue"><a href="/storage/{p.path}">
                     <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 512 512">
                    <g>
                        <path d="M 390.00 468.95 C381.80,470.26 129.95,470.17 122.00,468.86 C108.33,466.60 96.45,457.73 90.23,445.14 L 86.50 437.60 L 86.50 74.50 L 89.66 67.82 C93.50,59.72 99.49,53.01 106.43,49.04 C107.95,48.17 109.21,47.42 110.53,46.78 C118.32,43.00 127.95,43.00 205.25,43.00 C207.28,43.00 209.35,43.00 211.46,43.00 L 299.51 43.00 L 427.00 170.51 L 427.00 300.54 C427.00,306.20 427.00,311.63 427.00,316.83 C427.01,425.65 427.01,435.40 423.30,443.43 C422.76,444.60 422.14,445.74 421.43,447.15 C415.77,458.30 403.53,466.79 390.00,468.95 ZM 233.50 385.34 C249.82,386.31 267.83,383.68 277.02,378.99 C286.91,373.94 294.53,363.38 297.06,351.22 C298.98,341.98 297.84,328.61 294.50,321.17 C289.28,309.54 279.20,302.66 263.33,299.90 C256.53,298.71 226.14,299.18 224.00,300.50 C223.36,300.90 223.00,315.99 223.00,342.54 L 223.00 383.96 L 225.25 384.47 C226.49,384.75 230.20,385.14 233.50,385.34 ZM 278.00 139.50 L 278.00 192.00 L 384.49 192.00 L 332.00 139.50 C303.13,110.62 279.17,87.00 278.75,87.00 C278.34,87.00 278.00,110.62 278.00,139.50 ZM 150.00 343.10 L 150.00 385.08 L 159.25 384.79 L 168.50 384.50 L 168.78 369.50 L 169.05 354.50 L 177.28 354.31 C195.95,353.88 207.08,345.92 210.11,330.82 C212.32,319.82 207.47,308.35 198.48,303.31 C192.39,299.89 182.40,298.65 166.26,299.30 C158.43,299.61 151.57,300.15 151.01,300.49 C150.36,300.90 150.00,315.89 150.00,343.10 ZM 311.67 384.33 C312.03,384.70 316.31,385.00 321.17,385.00 L 330.00 385.00 L 330.00 351.05 L 345.25 350.78 L 360.50 350.50 L 361.08 335.05 L 330.50 334.50 L 330.21 324.75 L 329.93 315.00 L 363.00 315.00 L 363.00 300.00 L 311.00 300.00 L 311.00 341.83 C311.00,364.84 311.30,383.97 311.67,384.33 ZM 261.06 368.39 C255.86,370.02 248.79,370.83 244.73,370.25 L 241.97 369.86 L 242.50 314.50 L 252.00 314.54 C259.79,314.58 262.25,314.98 265.69,316.78 C271.34,319.74 274.61,324.33 276.59,332.04 C280.65,347.91 273.58,364.48 261.06,368.39 ZM 185.40 337.20 C182.10,339.13 170.99,340.72 169.75,339.44 C169.34,339.01 169.00,333.12 169.00,326.33 L 169.00 314.00 L 176.25 314.00 C185.63,314.01 189.41,316.09 191.05,322.17 C192.02,325.79 191.92,327.10 190.33,330.92 C189.18,333.69 187.30,336.09 185.40,337.20 Z" fill="rgb(0,0,0)"/>
                        <path d="M 0.00 256.00 L 0.00 0.00 L 256.00 0.00 L 512.00 0.00 L 512.00 256.00 L 512.00 512.00 L 256.00 512.00 L 0.00 512.00 L 0.00 256.00 ZM 390.00 468.95 C403.53,466.79 415.77,458.30 421.43,447.15 C427.24,435.67 427.00,442.03 427.00,300.54 L 427.00 170.51 L 363.25 106.75 L 299.51 43.00 L 211.46 43.00 C114.82,43.00 117.23,42.86 106.43,49.04 C99.49,53.01 93.50,59.72 89.66,67.82 L 86.50 74.50 L 86.50 256.05 L 86.50 437.60 L 90.23 445.14 C96.45,457.73 108.33,466.60 122.00,468.86 C129.95,470.17 381.80,470.26 390.00,468.95 ZM 233.50 385.34 C230.20,385.14 226.49,384.75 225.25,384.47 L 223.00 383.96 L 223.00 342.54 C223.00,315.99 223.36,300.90 224.00,300.50 C226.14,299.18 256.53,298.71 263.33,299.90 C279.20,302.66 289.28,309.54 294.50,321.17 C297.84,328.61 298.98,341.98 297.06,351.22 C294.53,363.38 286.91,373.94 277.02,378.99 C267.83,383.68 249.82,386.31 233.50,385.34 ZM 261.06 368.39 C273.58,364.48 280.65,347.91 276.59,332.04 C274.61,324.33 271.34,319.74 265.69,316.78 C262.25,314.98 259.79,314.58 252.00,314.54 L 242.50 314.50 L 242.23 342.18 L 241.97 369.86 L 244.73 370.25 C248.79,370.83 255.86,370.02 261.06,368.39 ZM 150.00 343.10 C150.00,315.89 150.36,300.90 151.01,300.49 C151.57,300.15 158.43,299.61 166.26,299.30 C182.40,298.65 192.39,299.89 198.48,303.31 C207.47,308.35 212.32,319.82 210.11,330.82 C207.08,345.92 195.95,353.88 177.28,354.31 L 169.05 354.50 L 168.78 369.50 L 168.50 384.50 L 159.25 384.79 L 150.00 385.08 L 150.00 343.10 ZM 185.40 337.20 C187.30,336.09 189.18,333.69 190.33,330.92 C191.92,327.10 192.02,325.79 191.05,322.17 C189.41,316.09 185.63,314.01 176.25,314.00 L 169.00 314.00 L 169.00 326.33 C169.00,333.12 169.34,339.01 169.75,339.44 C170.99,340.72 182.10,339.13 185.40,337.20 ZM 311.67 384.33 C311.30,383.97 311.00,364.84 311.00,341.83 L 311.00 300.00 L 337.00 300.00 L 363.00 300.00 L 363.00 307.50 L 363.00 315.00 L 346.46 315.00 L 329.93 315.00 L 330.21 324.75 L 330.50 334.50 L 345.79 334.78 L 361.08 335.05 L 360.79 342.78 L 360.50 350.50 L 345.25 350.78 L 330.00 351.05 L 330.00 368.03 L 330.00 385.00 L 321.17 385.00 C316.31,385.00 312.03,384.70 311.67,384.33 ZM 278.00 139.50 C278.00,110.62 278.34,87.00 278.75,87.00 C279.17,87.00 303.13,110.62 332.00,139.50 L 384.49 192.00 L 331.25 192.00 L 278.00 192.00 L 278.00 139.50 Z" fill="rgb(254,254,254)"/>
                    </g>
                </svg>           
                </a></span></h3><br>


            </div>
            <center>
                
                {#if $profil?.type ==2}
                    {#if p.state==1}
                        <button class="close" onclick={() => {accepter(p.id)}}><p>✅</p></button>
                        <button class="close" onclick={() => supprimer(p.id)}><p>❌</p></button>
                    {:else}
                        <p class="attente">En attente de la confirmation de l'étudiant</p>
                    {/if}

                {:else}
                    {#if p.state==1}
                        <p class="attente">En attente de validation de l'entreprise </p>
                    {:else}
                        <p>L'entreprise a validé</p>
                        <p>Voulez vous acceptez?</p>
                            <button class="close" ><p>✅</p></button>
                            <button class="close"><p>❌</p></button>
                    {/if}
                {/if}

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
        background: var(--surface-card);
        margin: 0 0 1rem 0;
        min-width: 70%;
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
        background: var(--surface-subtle);
        transition: background 0.15s, transform 0.15s;
    }

    .close:hover {
        background-color: var(--primary-50);
        transform: translateY(-1px);
    }

    .cv-link {
        color: var(--primary-600);
    }


    div.cv {
        display: inline-block;
    }

    div.cv svg {
        display: inline-block;
        width: 2em;
        height: 2em;
    }


    h2 {
        font-size: 2em;
    }

    h3 {
        font-size: 1.5em;
    }

    p.attente::after {
        content:'';
        animation: dotAnimation 1.5s infinite;
    }
    @keyframes dotAnimation {
        0%  {content: '';}
        33% {content: ' .';}
        66% {content: ' ..';}
        100% {content:' ...';}
    }

</style>

