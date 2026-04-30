<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import ModalPoste from './ModalPoste.svelte';
    import { page } from '@inertiajs/svelte';

    let {
        offre,
        entreprise,
        competences = [],
        domaines = [],
        links_competences = [],
        links_domaines = [],
        etudiant = null,
        dejaPostule = false,
    } = $props();

    let showModal = $state(false);
    let user = $derived(($page.props as any).auth?.user ?? null);

    function portal(node: HTMLElement) {
        document.body.appendChild(node);
        return { destroy() { node.remove(); } };
    }

    const skills = $derived(
        links_competences
            .map((l: any) => competences.find((c: any) => c.id === l.skill_id))
            .filter(Boolean)
    );

    const doms = $derived(
        links_domaines
            .map((l: any) => domaines.find((d: any) => d.id === l.dom_id))
            .filter(Boolean)
    );
</script>

<AppHead
    title={offre?.nom ?? 'Offre de stage'}
    description="{offre?.nom ?? 'Offre'} chez {entreprise?.nom ?? ''} — {offre?.nb_week} semaines, {offre?.paye_hour}€/h. Postulez sur CyStage."
/>
<Header />

<main class="detail-page">
    <div class="detail-container">
        <a href="/" class="back-link">← Retour aux offres</a>

        <div class="detail-card">
            <!-- Header -->
            <div class="card-header">
                <div class="header-left">
                    {#if entreprise?.logo}
                        <img src={entreprise.logo} alt="Logo {entreprise.nom}" class="logo-ent" loading="lazy" />
                    {:else}
                        <div class="logo-placeholder">{entreprise?.nom?.[0] ?? '?'}</div>
                    {/if}
                    <div class="header-info">
                        <h1>{offre.nom}</h1>
                        <span class="ent-nom">{entreprise?.nom}</span>
                        {#if entreprise?.ville}
                            <span class="ent-location">📍 {entreprise.ville}{entreprise.pays ? ', ' + entreprise.pays : ''}</span>
                        {/if}
                    </div>
                </div>

                <div class="header-right">
                    <div class="badges">
                        {#if offre.teletrav}
                            <span class="badge badge-green">🏠 Télétravail</span>
                        {:else}
                            <span class="badge badge-gray">🏢 Présentiel</span>
                        {/if}
                        {#each doms as d}
                            <span class="badge badge-blue">#{d.name}</span>
                        {/each}
                    </div>

                    {#if user?.role_id === 3}
                        {#if dejaPostule}
                            <span class="already-applied">✓ Candidature envoyée</span>
                        {:else}
                            <button class="btn-postuler" onclick={() => showModal = true}>Postuler →</button>
                        {/if}
                    {/if}
                </div>
            </div>

            <hr class="divider" />

            <!-- Info grid -->
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-icon">📅</span>
                    <div>
                        <span class="info-label">Durée</span>
                        <span class="info-value">{offre.nb_week} semaines</span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-icon">⏰</span>
                    <div>
                        <span class="info-label">Rythme</span>
                        <span class="info-value">{offre.week_hour}h / semaine</span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-icon">💶</span>
                    <div>
                        <span class="info-label">Gratification</span>
                        <span class="info-value">{offre.paye_hour} €/h</span>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-icon">📞</span>
                    <div>
                        <span class="info-label">Contact</span>
                        <span class="info-value">{entreprise?.num_tel ?? '—'}</span>
                    </div>
                </div>
            </div>

            <hr class="divider" />

            <!-- Description -->
            <div class="section">
                <h2>Description du poste</h2>
                <p>{offre.poste_desc}</p>
            </div>

            <div class="section">
                <h2>Profil recherché</h2>
                <p>{offre.profil_desc}</p>
            </div>

            {#if skills.length > 0}
                <div class="section">
                    <h2>Compétences recherchées</h2>
                    <div class="skills">
                        {#each skills as s}
                            <span class="skill-tag">{s.name}</span>
                        {/each}
                    </div>
                </div>
            {/if}

            <!-- Footer CTA -->
            {#if user?.role_id === 3}
                <div class="cta-footer">
                    {#if dejaPostule}
                        <span class="already-applied-lg">✓ Vous avez déjà postulé à cette offre</span>
                    {:else}
                        <button class="btn-postuler-lg" onclick={() => showModal = true}>
                            Postuler à cette offre →
                        </button>
                    {/if}
                </div>
            {/if}
        </div>
    </div>
</main>

{#if showModal}
    <div use:portal>
        <ModalPoste {etudiant} bind:showModalPostuler={showModal} {offre} />
    </div>
{/if}

<style>
    .detail-page {
        min-height: 100vh;
        background: var(--surface-subtle);
        padding: 2rem 1.5rem 4rem;
    }

    .detail-container {
        max-width: 860px;
        margin: 0 auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink-600);
        text-decoration: none;
        margin-bottom: 1.25rem;
        transition: color 0.15s;
    }

    .back-link:hover { color: var(--primary-600); }

    .detail-card {
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.07);
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .header-left {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .logo-ent {
        width: 68px;
        height: 68px;
        object-fit: contain;
        border-radius: 14px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        padding: 6px;
        flex-shrink: 0;
    }

    .logo-placeholder {
        width: 68px;
        height: 68px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        border: 1px solid var(--border-200);
        flex-shrink: 0;
    }

    .header-info h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--ink-900);
        margin: 0 0 0.25rem;
        line-height: 1.25;
    }

    .ent-nom {
        display: block;
        font-size: 1rem;
        color: var(--ink-600);
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .ent-location {
        display: block;
        font-size: 0.85rem;
        color: var(--ink-500);
    }

    .header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        justify-content: flex-end;
    }

    .badge {
        padding: 0.3rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-green { background: var(--badge-green-bg); color: var(--badge-green-text); }
    .badge-gray  { background: var(--badge-gray-bg);  color: var(--badge-gray-text);  }
    .badge-blue  { background: var(--primary-50);      color: var(--primary-600);     }

    .btn-postuler {
        padding: 0.55rem 1.3rem;
        background: var(--primary-600);
        color: white;
        border: none;
        border-radius: 980px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: opacity 0.15s, transform 0.15s;
    }

    .btn-postuler:hover { opacity: 0.88; transform: translateY(-1px); }

    .already-applied {
        font-size: 0.875rem;
        font-weight: 600;
        color: #16a34a;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.4rem 0.9rem;
    }

    .divider {
        border: none;
        border-top: 1px solid var(--border-200);
        margin: 1.5rem 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: var(--surface-subtle);
        border-radius: 10px;
        padding: 0.7rem 0.9rem;
        border: 1px solid var(--border-200);
    }

    .info-icon { font-size: 1.1rem; }

    .info-label {
        display: block;
        font-size: 0.7rem;
        color: var(--ink-600);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .info-value {
        display: block;
        font-size: 0.88rem;
        color: var(--ink-900);
        font-weight: 600;
        margin-top: 0.1rem;
    }

    .section { margin-bottom: 1.5rem; }

    .section h2 {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin: 0 0 0.6rem;
    }

    .section p {
        font-size: 0.95rem;
        color: var(--ink-900);
        line-height: 1.7;
        margin: 0;
        white-space: pre-wrap;
    }

    .skills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .skill-tag {
        padding: 0.35rem 0.85rem;
        background: var(--surface-muted);
        border: 1px solid var(--border-200);
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--ink-900);
    }

    .cta-footer {
        border-top: 1px solid var(--border-200);
        padding-top: 1.5rem;
        margin-top: 0.5rem;
        display: flex;
        justify-content: flex-end;
    }

    .btn-postuler-lg {
        padding: 0.75rem 2rem;
        background: var(--primary-600);
        color: white;
        border: none;
        border-radius: 980px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: opacity 0.15s, transform 0.15s;
    }

    .btn-postuler-lg:hover { opacity: 0.88; transform: translateY(-1px); }

    .already-applied-lg {
        font-size: 0.95rem;
        font-weight: 600;
        color: #16a34a;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 0.65rem 1.25rem;
    }

    @media (max-width: 768px) {
        .detail-card { padding: 1.5rem 1.25rem; }
        .info-grid { grid-template-columns: repeat(2, 1fr); }
        .card-header { flex-direction: column; }
        .header-right { align-items: flex-start; }
        .badges { justify-content: flex-start; }
    }

    @media (max-width: 480px) {
        .detail-card { padding: 1.25rem 1rem; }
        .info-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
