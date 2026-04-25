<script lang="ts">
    import Header from '@/components/Header.svelte'
    import AppHead from '@/components/AppHead.svelte'
    import { page } from '@inertiajs/svelte'
    import { onMount } from 'svelte'
    import OffreDeStage from './OffreDeStage.svelte'
    import Modal from './Modal.svelte'
    import Unconnect from './Unconnect.svelte';

    let showModal = $state(false)

    let { entreprises=$bindable(), offres=[], competences=$bindable([]), domaines=$bindable([]), links_offres_competences=[], links_offres_domaines=[], etudiant=$bindable() } = $props();

    // Filtres
    let recherche = $state('');
    let filtreDomaineIds: number[] = $state([]);
    let filtreSkillIds: number[] = $state([]);
    let filtreTeletrav = $state<boolean | null>(null);
    let filtreWeekMax = $state<number | null>(null);

    function toggleDomaine(id: number) {
        if (filtreDomaineIds.includes(id)) {
            filtreDomaineIds = filtreDomaineIds.filter(d => d !== id);
        } else {
            filtreDomaineIds = [...filtreDomaineIds, id];
        }
    }

    function toggleSkill(id: number) {
        if (filtreSkillIds.includes(id)) {
            filtreSkillIds = filtreSkillIds.filter(s => s !== id);
        } else {
            filtreSkillIds = [...filtreSkillIds, id];
        }
    }

    function resetFiltres() {
        recherche = '';
        filtreDomaineIds = [];
        filtreSkillIds = [];
        filtreTeletrav = null;
        filtreWeekMax = null;
    }

    let offresFiltrees = $derived(() => {
        if (!offres) return [];
        return offres.filter(offre => {
            // Recherche texte
            if (recherche) {
                const q = recherche.toLowerCase();
                const ent = recupEntreprise(offre, entreprises);
                if (
                    !offre.nom.toLowerCase().includes(q) &&
                    !(ent?.nom?.toLowerCase().includes(q))
                ) return false;
            }

            // Filtre domaines
            if (filtreDomaineIds.length > 0) {
                const domsOffre = recupDomaines(offre, links_offres_domaines, domaines).map(d => d?.id);
                if (!filtreDomaineIds.some(id => domsOffre.includes(id))) return false;
            }

            // Filtre compétences
            if (filtreSkillIds.length > 0) {
                const skillsOffre = recupCompetences(offre, links_offres_competences, competences).map(s => s?.id);
                if (!filtreSkillIds.some(id => skillsOffre.includes(id))) return false;
            }

            // Filtre télétravail
            if (filtreTeletrav !== null) {
                if (Boolean(offre.teletrav) !== filtreTeletrav) return false;
            }

            // Filtre durée max
            if (filtreWeekMax !== null) {
                if (offre.nb_week > filtreWeekMax) return false;
            }

            return true;
        });
    });

    function recupDomaines(offre, liens, listeDomaines) {
        let res: any[] = []
        for (let l of liens) {
            if (offre.id == l.offre_id) {
                res.push(listeDomaines[l.dom_id - 1])
            }
        }
        return res
    }

    function recupEntreprise(offre, listeEntreprises) {
        if (!listeEntreprises) return null;
        for (let e of listeEntreprises) {
            if (offre.ent_id == e.id) return e
        }
        return null;
    }

    function recupCompetences(offre, liens, listeCompetences) {
        let res: any[] = []
        for (let l of liens) {
            if (offre.id == l.offre_id) {
                res.push(listeCompetences[l.skill_id - 1])
            }
        }
        return res
    }

    let utilisateur = $derived($page?.props?.auth?.user ?? null)

    onMount(() => {
        let observer = new IntersectionObserver((entrees) => {
            entrees.forEach((entree) => {
                if (entree.isIntersecting) entree.target.classList.add('visible')
            })
        }, { threshold: 0.14 })

        let blocs = document.querySelectorAll('.apparition')
        blocs.forEach((b) => observer.observe(b))

        return () => observer.disconnect()
    })
</script>

<AppHead title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>

<Header bind:showModal={showModal} />

<main>
    {#if !utilisateur}
        <Unconnect />
    {:else}
        <section class="zoneOffres">
            <div class="titreBloc titreGauche">
                <span>Espace connecté</span>
                <h2>Offres disponibles</h2>
                <p>Retrouvez ici les offres actuellement présentes sur la plateforme.</p>
            </div>

            <div class="layout">
                <!-- Sidebar filtres -->
                <aside class="sidebar">
                    <div class="sidebar-header">
                        <h3>Filtres</h3>
                        {#if filtreDomaineIds.length > 0 || filtreSkillIds.length > 0 || filtreTeletrav !== null || filtreWeekMax !== null || recherche}
                            <button class="reset-btn" onclick={resetFiltres}>Réinitialiser</button>
                        {/if}
                    </div>

                    <!-- Recherche -->
                    <div class="filtre-section">
                        <div class="filtre-label">🔍 Recherche</div>
                        <input
                            type="text"
                            placeholder="Nom de l'offre, entreprise..."
                            bind:value={recherche}
                            class="search-input"
                        />
                    </div>

                    <!-- Télétravail -->
                    <div class="filtre-section">
                        <div class="filtre-label">🏠 Télétravail</div>
                        <div class="radio-group">
                            <button
                                class="radio-btn"
                                class:active={filtreTeletrav === null}
                                onclick={() => filtreTeletrav = null}
                            >Tous</button>
                            <button
                                class="radio-btn"
                                class:active={filtreTeletrav === true}
                                onclick={() => filtreTeletrav = true}
                            >Oui</button>
                            <button
                                class="radio-btn"
                                class:active={filtreTeletrav === false}
                                onclick={() => filtreTeletrav = false}
                            >Non</button>
                        </div>
                    </div>

                    <!-- Durée max -->
                    <div class="filtre-section">
                        <div class="filtre-label">
                            📅 Durée max
                            {#if filtreWeekMax !== null}
                                <span class="filtre-value">{filtreWeekMax} sem.</span>
                            {/if}
                        </div>
                        <input
                            type="range"
                            min="4"
                            max="24"
                            step="2"
                            bind:value={filtreWeekMax}
                            class="range-input"
                        />
                        <div class="range-labels">
                            <span>4 sem.</span>
                            <span>24 sem.</span>
                        </div>
                        {#if filtreWeekMax !== null}
                            <button class="clear-btn" onclick={() => filtreWeekMax = null}>✕ Effacer</button>
                        {/if}
                    </div>

                    <!-- Domaines -->
                    {#if domaines && domaines.length > 0}
                        <div class="filtre-section">
                            <div class="filtre-label">🗂️ Domaines</div>
                            <div class="tags-list">
                                {#each domaines as d}
                                    <button
                                        class="tag-btn"
                                        class:active={filtreDomaineIds.includes(d.id)}
                                        onclick={() => toggleDomaine(d.id)}
                                    >{d.name}</button>
                                {/each}
                            </div>
                        </div>
                    {/if}

                    <!-- Compétences -->
                    {#if competences && competences.length > 0}
                        <div class="filtre-section">
                            <div class="filtre-label">⚙️ Compétences</div>
                            <div class="tags-list">
                                {#each competences as c}
                                    <button
                                        class="tag-btn"
                                        class:active={filtreSkillIds.includes(c.id)}
                                        onclick={() => toggleSkill(c.id)}
                                    >{c.name}</button>
                                {/each}
                            </div>
                        </div>
                    {/if}
                </aside>

                <!-- Liste des offres -->
                <div class="listeOffres">
                    {#if offresFiltrees().length === 0}
                        <div class="empty-state">
                            <p class="empty-icon">🔍</p>
                            <p class="empty-title">Aucune offre trouvée</p>
                            <p class="empty-sub">Essayez de modifier vos filtres.</p>
                            <button class="reset-btn-center" onclick={resetFiltres}>Réinitialiser les filtres</button>
                        </div>
                    {:else}
                        <p class="nb-resultats">{offresFiltrees().length} offre{offresFiltrees().length > 1 ? 's' : ''} trouvée{offresFiltrees().length > 1 ? 's' : ''}</p>
                        {#if utilisateur.role_id == 2}
                            {#each offresFiltrees() as offre}
                                <OffreDeStage
                                    offre={offre}
                                    entreprise={entreprises}
                                    doms={recupDomaines(offre, links_offres_domaines, domaines)}
                                    skills={recupCompetences(offre, links_offres_competences, competences)}
                                    etudiant={etudiant}
                                />
                            {/each}
                        {:else}
                            {#each offresFiltrees() as offre}
                                <OffreDeStage
                                    offre={offre}
                                    entreprise={recupEntreprise(offre, entreprises)}
                                    doms={recupDomaines(offre, links_offres_domaines, domaines)}
                                    skills={recupCompetences(offre, links_offres_competences, competences)}
                                    etudiant={etudiant}
                                />
                            {/each}
                        {/if}
                    {/if}
                </div>
            </div>
        </section>
    {/if}
</main>

{#if showModal}
    <Modal
        bind:showModal={showModal}
        bind:domaines={domaines}
        bind:competences={competences}
        bind:entreprises={entreprises}
        user={utilisateur}
    />
{/if}

<footer>
    <p>© CyStage - Tous droits réservés 2026</p>
</footer>

<style>


    .zoneOffres {
        max-width: 1300px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
    }

    .titreBloc { margin-bottom: 1.5rem; }
    .titreGauche { text-align: left; }

    .titreBloc span {
        display: inline-block;
        margin-bottom: 0.5rem;
        color: var(--primary-700);
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .titreBloc h2 {
        margin: 0 0 0.5rem;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        font-weight: 800;
    }

    .titreBloc p { margin: 0; color: var(--ink-600); }

    /* Layout sidebar + offres */
    .layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 1.5rem;
        align-items: flex-start;
    }

    /* Sidebar */
    .sidebar {
        background: #fff;
        border: 1px solid var(--border-200);
        border-radius: 16px;
        padding: 1.25rem;
        position: sticky;
        top: 80px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .sidebar-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink-900);
        margin: 0;
    }

    .reset-btn {
        font-size: 0.78rem;
        color: var(--primary-600);
        background: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        padding: 0;
        font-family: inherit;
    }

    .reset-btn:hover { text-decoration: underline; }

    .filtre-section {
        margin-bottom: 1.25rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-200);
    }

    .filtre-section:last-child { border-bottom: none; margin-bottom: 0; }

    .filtre-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.6rem;
    }

    .filtre-value {
        font-size: 0.8rem;
        color: var(--primary-600);
        font-weight: 700;
        text-transform: none;
    }

    .search-input {
        width: 100%;
        padding: 0.55rem 0.75rem;
        border: 1px solid var(--border-200);
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s;
    }

    .search-input:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .radio-group {
        display: flex;
        gap: 0.4rem;
    }

    .radio-btn {
        flex: 1;
        padding: 0.4rem 0.5rem;
        border: 1px solid var(--border-200);
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        background: #f8fafc;
        color: var(--ink-600);
        font-family: inherit;
        transition: all 0.15s;
    }

    .radio-btn.active {
        background: var(--primary-50);
        border-color: var(--primary-600);
        color: var(--primary-700);
    }

    .range-input {
        width: 100%;
        accent-color: var(--primary-600);
        cursor: pointer;
    }

    .range-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--ink-600);
        margin-top: 0.25rem;
    }

    .clear-btn {
        margin-top: 0.4rem;
        font-size: 0.75rem;
        color: #94a3b8;
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
    }

    .clear-btn:hover { color: #ef4444; }

    .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .tag-btn {
        padding: 0.3rem 0.65rem;
        border: 1px solid var(--border-200);
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        background: #f8fafc;
        color: var(--ink-600);
        font-family: inherit;
        transition: all 0.15s;
    }

    .tag-btn.active {
        background: var(--primary-50);
        border-color: var(--primary-600);
        color: var(--primary-700);
    }

    /* Liste offres */
    .listeOffres {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .nb-resultats {
        font-size: 0.85rem;
        color: var(--ink-600);
        margin: 0 0 0.5rem 0;
        font-weight: 600;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border-200);
    }

    .empty-icon { font-size: 2.5rem; margin: 0; }
    .empty-title { font-size: 1.1rem; font-weight: 700; color: var(--ink-900); margin: 0.5rem 0 0.25rem; }
    .empty-sub { color: var(--ink-600); font-size: 0.9rem; margin: 0 0 1rem; }

    .reset-btn-center {
        padding: 0.5rem 1.25rem;
        background: var(--primary-600);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
    }

    footer {
        padding: 1.4rem 1rem 2rem;
        text-align: center;
        color: var(--ink-600);
        font-size: 0.9rem;
    }

    footer p { margin: 0; }

    @media (max-width: 900px) {
        .layout { grid-template-columns: 1fr; }
        .sidebar { position: static; }
    }
</style>