<script lang="ts">
    import { router, page } from '@inertiajs/svelte';

    let { postulations = [], profile } = $props();

    const isEntreprise = profile?.type == 2;

    let showArchived = $state(false);

    let visible = $derived(
        showArchived ? postulations : postulations.filter((p: any) => !p.archived)
    );

    let archivedCount = $derived(postulations.filter((p: any) => p.archived).length);

    // Pagination
    const PER_PAGE = 5;
    let pageNum = $state(1);
    let totalPages = $derived(Math.ceil(visible.length / PER_PAGE));
    let paginated = $derived(visible.slice((pageNum - 1) * PER_PAGE, pageNum * PER_PAGE));

    $effect(() => { showArchived; pageNum = 1; });

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

    function archiver(id: number, archived: boolean) {
        router.post(`/postulation/${id}/archiver`, {}, { preserveScroll: true });
    }

    function deleteComment(id: number) {
        router.delete(`/commentaire/${id}`, { preserveScroll: true });
    }

    let commentBodies: Record<number, string> = $state({});

    $effect(() => {
        for (const p of postulations) {
            if (commentBodies[p.id] === undefined) {
                commentBodies[p.id] = '';
            }
        }
    });

    function submitComment(e: Event, postulationId: number) {
        e.preventDefault();
        const body = commentBodies[postulationId];
        if (!body?.trim()) return;
        router.post(
            `/postulation/${postulationId}/commentaire`,
            { body },
            {
                preserveScroll: true,
                onSuccess: () => { commentBodies[postulationId] = ''; },
            }
        );
    }

    const stateLabel: Record<number, string> = {
        1: 'En attente',
        2: 'Acceptée — confirmation en attente',
        3: 'Stage confirmé',
    };

    const stateBadge: Record<number, string> = {
        1: 'badge-pending',
        2: 'badge-accepted',
        3: 'badge-confirmed',
    };
</script>

<div class="candidatures-header">
    <div>
        <h1 class="candidatures-title">
            {isEntreprise ? 'Candidatures reçues' : 'Mes candidatures'}
        </h1>
        <p class="candidatures-sub">
            {visible.length} candidature{visible.length > 1 ? 's' : ''}
            {showArchived ? '' : archivedCount > 0 ? `· ${archivedCount} archivée${archivedCount > 1 ? 's' : ''}` : ''}
        </p>
    </div>
    {#if archivedCount > 0}
        <button class="btn-toggle-archived" onclick={() => showArchived = !showArchived}>
            {showArchived ? 'Masquer archivées' : `Voir archivées (${archivedCount})`}
        </button>
    {/if}
</div>

{#if visible.length === 0}
    <div class="empty-state">
        <span class="empty-icon">📭</span>
        <p class="empty-title">{isEntreprise ? 'Aucune candidature reçue' : 'Aucune candidature envoyée'}</p>
        {#if isEntreprise}
            <p class="empty-sub">Aucun étudiant n'a encore postulé à vos offres.</p>
        {:else}
            <p class="empty-sub">Postulez à des offres depuis la page d'accueil.</p>
        {/if}
    </div>
{:else}
    {#each paginated as p}
        <div class="card" class:archived={p.archived}>
            <div class="card-header">
                <div class="card-meta">
                    {#if isEntreprise}
                        <p class="card-title">{p?.etudiant?.prenom ?? ''} {p?.etudiant?.nom ?? 'Étudiant inconnu'}</p>
                        <p class="card-sub">Offre : {p?.offre?.nom ?? '—'}</p>
                    {:else}
                        <p class="card-title">{p?.offre?.nom ?? 'Offre inconnue'}</p>
                    {/if}
                </div>
                <div class="card-header-right">
                    <span class="badge {stateBadge[p.state] ?? 'badge-pending'}">
                        {stateLabel[p.state] ?? 'Inconnu'}
                    </span>
                    {#if p.archived}
                        <span class="badge badge-archived">Archivée</span>
                    {/if}
                </div>
            </div>

            <div class="card-body">
                <p class="motiv-label">Lettre de motivation</p>
                <p class="motiv">{p?.motiv ?? '—'}</p>
            </div>

            {#if p.state === 3 && p.commentaires?.length > 0}
                <div class="comments-section">
                    <p class="comments-label">Commentaires</p>
                    {#each p.commentaires as c}
                        <div class="comment">
                            <div class="comment-header">
                                <span class="comment-author">{c.user?.email ?? '—'}</span>
                                <span class="comment-time">{new Date(c.created_at).toLocaleDateString('fr-FR')}</span>
                            </div>
                            <p class="comment-body">{c.body}</p>
                            {#if c.user_id === ($page.props as any).auth?.user?.id}
                                <button class="comment-delete" onclick={() => deleteComment(c.id)}>Supprimer</button>
                            {/if}
                        </div>
                    {/each}
                </div>
            {/if}

            {#if p.state === 3}
                <form class="comment-form" onsubmit={(e) => submitComment(e, p.id)}>
                    <input
                        type="text"
                        placeholder="Ajouter un commentaire sur ce stage…"
                        bind:value={commentBodies[p.id]}
                    />
                    <button type="submit" class="btn btn-comment">Envoyer</button>
                </form>
            {/if}

            <div class="card-footer">
                {#if p.path}
                    <a class="cv-link" href="/storage/{p.path}" target="_blank" rel="noopener">
                        Voir le CV (PDF)
                    </a>
                {:else}
                    <span class="cv-none">Pas de CV joint</span>
                {/if}

                <div class="actions">
                    {#if !p.archived}
                        {#if isEntreprise}
                            {#if p.state === 1}
                                <button class="btn btn-green" onclick={() => accepter(p.id)}>Accepter</button>
                                <button class="btn btn-red" onclick={() => supprimer(p.id, 'Refuser ce candidat ?')}>Refuser</button>
                            {:else if p.state === 2}
                                <span class="attente">En attente de confirmation de l'étudiant</span>
                            {:else if p.state === 3}
                                <span class="confirmed">Stage confirmé ✓</span>
                                <button class="btn btn-archive" onclick={() => archiver(p.id, p.archived)}>Archiver</button>
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
                                <button class="btn btn-archive" onclick={() => archiver(p.id, p.archived)}>Archiver</button>
                            {/if}
                        {/if}
                    {:else}
                        <button class="btn btn-archive" onclick={() => archiver(p.id, p.archived)}>Désarchiver</button>
                    {/if}
                </div>
            </div>
        </div>
    {/each}

    {#if totalPages > 1}
        <div class="pagination">
            <button class="pg-btn" disabled={pageNum === 1} onclick={() => pageNum--}>←</button>
            {#each Array.from({length: totalPages}, (_, i) => i + 1) as p}
                <button class="pg-btn" class:pg-active={p === pageNum} onclick={() => pageNum = p}>{p}</button>
            {/each}
            <button class="pg-btn" disabled={pageNum === totalPages} onclick={() => pageNum++}>→</button>
        </div>
    {/if}
{/if}

<style>
    .candidatures-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .candidatures-title {
        font-size: clamp(1.1rem, 2.2vw, 1.4rem);
        font-weight: 700;
        color: var(--ink-900);
        margin: 0 0 4px;
    }

    .candidatures-sub {
        font-size: 0.85rem;
        color: var(--ink-600);
        margin: 0;
    }

    .btn-toggle-archived {
        padding: 0.4rem 0.9rem;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--ink-600);
        background: var(--surface-subtle);
        border: 1px solid var(--border-200);
        border-radius: 8px;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .btn-toggle-archived:hover { background: var(--surface-muted); }

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
        transition: opacity 0.2s;
    }

    .card.archived {
        opacity: 0.6;
        border-style: dashed;
    }

    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.8rem;
    }

    .card-header-right {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        flex-shrink: 0;
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
    }

    .badge-pending   { background: #fef3c7; color: #92400e; }
    .badge-accepted  { background: #dbeafe; color: #1e40af; }
    .badge-confirmed { background: #d1fae5; color: #065f46; }
    .badge-archived  { background: #f1f5f9; color: #64748b; }

    .card-body { margin-bottom: 0.9rem; }

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

    .btn:hover { opacity: 0.82; }

    .btn-green   { background: #d1fae5; color: #065f46; }
    .btn-red     { background: #fee2e2; color: #991b1b; }
    .btn-archive { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

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

    /* ── Comments ── */
    .comments-section {
        border-top: 1px solid var(--border-200);
        padding-top: 0.85rem;
        margin-bottom: 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .comments-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0 0.2rem;
    }

    .comment {
        background: var(--surface-subtle);
        border: 1px solid var(--border-200);
        border-radius: 8px;
        padding: 0.65rem 0.85rem;
    }

    .comment-header {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.3rem;
    }

    .comment-author {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink-700);
    }

    .comment-time {
        font-size: 0.75rem;
        color: var(--ink-500);
    }

    .comment-body {
        font-size: 0.875rem;
        color: var(--ink-900);
        margin: 0;
        line-height: 1.4;
    }

    .comment-delete {
        background: none;
        border: none;
        color: #dc2626;
        font-size: 0.75rem;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
        margin-top: 0.25rem;
    }

    .comment-delete:hover { text-decoration: underline; }

    .comment-form {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.85rem;
        border-top: 1px solid var(--border-200);
        padding-top: 0.85rem;
    }

    .comment-form input {
        flex: 1;
        padding: 0.5rem 0.85rem;
        border: 1px solid var(--border-200);
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: inherit;
        background: var(--surface-subtle);
        color: var(--ink-900);
        outline: none;
        transition: border-color 0.15s;
    }

    .comment-form input:focus { border-color: var(--primary-600); }

    .btn-comment { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

    .cv-none {
        font-size: 0.875rem;
        color: var(--ink-500);
        font-style: italic;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.35rem;
        margin-top: 1.25rem;
    }

    .pg-btn {
        min-width: 34px;
        height: 34px;
        padding: 0 0.5rem;
        border: 1px solid var(--border-200);
        border-radius: 8px;
        background: var(--surface-card);
        color: var(--ink-600);
        font-size: 0.875rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background 0.15s;
    }

    .pg-btn:hover:not(:disabled) { background: var(--surface-muted); }
    .pg-btn:disabled { opacity: 0.4; cursor: default; }
    .pg-btn.pg-active { background: var(--primary-600); color: #fff; border-color: var(--primary-600); }
</style>
