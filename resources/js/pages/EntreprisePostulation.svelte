<script lang="ts">
    import { router } from '@inertiajs/svelte';

    let { postulations = [], profile } = $props();

    const isEntreprise = profile?.type == 2;

    function supprimer(id: number, label: string) {
        if (confirm(label)) {
            router.delete(`/postulation/${id}`, { preserveScroll: true });
        }
    }

    function accepter(id: number) {
        if (confirm('Êtes-vous sûr de vouloir accepter ce candidat ?')) {
            router.post(`/accepte/${id}`, {}, { preserveScroll: true });
        }
    }

    function confirmer(id: number) {
        if (confirm('Confirmer ce stage ?')) {
            router.post(`/postulation/${id}/confirmer`, {}, { preserveScroll: true });
        }
    }

    const stateLabel: Record<number, string> = {
        1: 'En attente',
        2: 'Acceptée — en attente de ta confirmation',
        3: 'Stage confirmé',
    };

    const stateBadge: Record<number, string> = {
        1: 'badge-pending',
        2: 'badge-accepted',
        3: 'badge-confirmed',
    };
</script>

<section class="heading">
    {#if isEntreprise}
        <h1>Vous avez <b><span>{postulations.length}</span> candidature{postulations.length > 1 ? 's' : ''}</b></h1>
    {:else}
        <h1>Vous avez <b><span>{postulations.length}</span> candidature{postulations.length > 1 ? 's' : ''}</b></h1>
    {/if}
</section>

{#if postulations.length === 0}
    <div class="empty-state">
        <span class="empty-icon">📭</span>
        <p class="empty-title">{isEntreprise ? 'Aucune candidature reçue' : 'Aucune candidature envoyée'}</p>
        {#if !isEntreprise}
            <p class="empty-sub">Postulez à des offres depuis la page d'accueil.</p>
        {/if}
    </div>
{:else}
    {#each postulations as p}
        <div class="card">
            <div class="card-header">
                <div>
                    {#if isEntreprise}
                        <p class="card-title">{p?.etudiant?.prenom ?? ''} {p?.etudiant?.nom ?? 'Étudiant inconnu'}</p>
                        <p class="card-sub">Offre : {p?.offre?.nom ?? '—'}</p>
                    {:else}
                        <p class="card-title">{p?.offre?.nom ?? 'Offre inconnue'}</p>
                    {/if}
                </div>
                <span class="badge {stateBadge[p.state] ?? 'badge-pending'}">
                    {stateLabel[p.state] ?? 'Inconnu'}
                </span>
            </div>

            <div class="card-body">
                <p class="motiv-label">Lettre de motivation</p>
                <p class="motiv">{p?.motiv ?? '—'}</p>
            </div>

            <div class="card-footer">
                <a class="cv-link" href="/storage/{p.path}" target="_blank" rel="noopener">
                    Voir le CV (PDF)
                </a>

                <div class="actions">
                    {#if isEntreprise}
                        {#if p.state === 1}
                            <button class="btn btn-green" onclick={() => accepter(p.id)}>Accepter</button>
                            <button class="btn btn-red" onclick={() => supprimer(p.id, 'Refuser ce candidat ?')}>Refuser</button>
                        {:else if p.state === 2}
                            <span class="attente">En attente de confirmation de l'étudiant</span>
                        {:else if p.state === 3}
                            <span class="confirmed">Stage confirmé ✓</span>
                        {/if}
                    {:else}
                        {#if p.state === 1}
                            <span class="attente">En attente de l'entreprise</span>
                            <button class="btn btn-red" onclick={() => supprimer(p.id, 'Retirer cette candidature ?')}>Retirer</button>
                        {:else if p.state === 2}
                            <button class="btn btn-green" onclick={() => confirmer(p.id)}>Confirmer le stage</button>
                            <button class="btn btn-red" onclick={() => supprimer(p.id, 'Refuser cette offre ?')}>Refuser</button>
                        {:else if p.state === 3}
                            <span class="confirmed">Stage confirmé ✓</span>
                        {/if}
                    {/if}
                </div>
            </div>
        </div>
    {/each}
{/if}

<style>
    .heading {
        margin: 0 0 1.5rem;
    }

    .heading h1 {
        font-size: clamp(1.2rem, 2.4vw, 1.6rem);
        color: var(--ink-900);
        margin: 0;
    }

    .heading h1 span {
        color: var(--primary-600);
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 3rem 1rem;
        gap: 0.5rem;
        text-align: center;
    }

    .empty-icon { font-size: 2.5rem; }

    .empty-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink-900);
        margin: 0;
    }

    .empty-sub {
        font-size: 0.875rem;
        color: var(--ink-600);
        margin: 0;
    }

    .card {
        border: 1px solid var(--border-200);
        border-radius: 12px;
        background: var(--surface-card);
        padding: 1.1rem 1.3rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.8rem;
    }

    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--ink-900);
        margin: 0;
    }

    .card-sub {
        font-size: 0.85rem;
        color: var(--ink-600);
        margin: 0.15rem 0 0;
    }

    .badge {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.25rem 0.65rem;
        border-radius: 999px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-pending   { background: #fef3c7; color: #92400e; }
    .badge-accepted  { background: #dbeafe; color: #1e40af; }
    .badge-confirmed { background: #d1fae5; color: #065f46; }

    .card-body {
        margin-bottom: 0.9rem;
    }

    .motiv-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink-600);
        margin: 0 0 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .motiv {
        font-size: 0.92rem;
        color: var(--ink-900);
        line-height: 1.5;
        margin: 0;
        white-space: pre-wrap;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cv-link {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-600);
        text-decoration: none;
    }

    .cv-link:hover { text-decoration: underline; }

    .actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn {
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: opacity 0.15s;
    }

    .btn:hover { opacity: 0.85; }

    .btn-green { background: #d1fae5; color: #065f46; }
    .btn-red   { background: #fee2e2; color: #991b1b; }

    .attente {
        font-size: 0.85rem;
        color: var(--ink-600);
        font-style: italic;
    }

    .confirmed {
        font-size: 0.875rem;
        font-weight: 600;
        color: #065f46;
    }
</style>
