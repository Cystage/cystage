<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page, router } from '@inertiajs/svelte';

    let { etudiants, entreprises, offres, admins, logs = [], stages = [] } = $props();

    let activeTab = $state('etudiants');
    let success = $derived($page.props.flash?.success);

    const deleteForm = useForm({});
    const roleForm = useForm({ role_id: 0 });
    const deleteOffreForm = useForm({});

    function deleteUser(id: number) {
        if (!confirm('Supprimer cet utilisateur ?')) return;
        $deleteForm.delete(`/admin/user/${id}`);
    }

    function changeRole(id: number, newRole: number) {
        if (!confirm(`Changer le rôle de cet utilisateur ?`)) return;
        $roleForm.role_id = newRole;
        $roleForm.patch(`/admin/user/${id}/role`);
    }

    function deleteOffre(id: number) {
        if (!confirm('Supprimer cette offre ?')) return;
        $deleteOffreForm.delete(`/admin/offre/${id}`);
    }

    function archiverStage(id: number, archived: boolean) {
        router.post(`/postulation/${id}/archiver`, {}, { preserveScroll: true });
    }

    function formatDate(date: string) {
        return new Date(date).toLocaleDateString('fr-FR');
    }

    const roles: Record<number, string> = {
        1: 'Admin',
        2: 'Entreprise',
        3: 'Étudiant',
    };

    const logActionLabel: Record<string, { label: string; color: string }> = {
        login:              { label: 'Connexion',    color: '#2563eb' },
        login_failed:       { label: 'Échec login',  color: '#dc2626' },
        login_2fa:          { label: '2FA envoyé',   color: '#7c3aed' },
        logout:             { label: 'Déconnexion',  color: '#64748b' },
        register:           { label: 'Inscription',  color: '#16a34a' },
        postulation:        { label: 'Candidature',  color: '#0891b2' },
        acceptation:        { label: 'Acceptation',  color: '#15803d' },
        confirmation:       { label: 'Confirmation', color: '#15803d' },
        delete_account:     { label: 'Suppression',  color: '#dc2626' },
        admin_role:         { label: 'Rôle modifié', color: '#d97706' },
        admin_delete_offre: { label: 'Offre supp.',  color: '#dc2626' },
        settings:           { label: 'Paramètres',   color: '#64748b' },
    };
</script>

<AppHead title="Administration" />
<Header />

<main>
    <div class="content">
        <div class="page-header">
            <div>
                <h1>🛠️ Administration</h1>
                <p>Gestion des utilisateurs et des offres de la plateforme</p>
            </div>
            <a href="/register" class="btn-create-account">+ Créer un compte</a>
        </div>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        <div class="stats">
            <div class="stat-card">
                <strong>{offres.length}</strong>
                <span>Offres publiées</span>
            </div>
            <div class="stat-card">
                <strong>{etudiants.length}</strong>
                <span>Étudiants</span>
            </div>
            <div class="stat-card">
                <strong>{entreprises.length}</strong>
                <span>Entreprises</span>
            </div>
            <div class="stat-card">
                <strong>{stages.filter((s: any) => !s.archived).length}</strong>
                <span>Stages en cours</span>
            </div>
        </div>

        <div class="tabs">
            <button class="tab" class:active={activeTab === 'offres'} onclick={() => activeTab = 'offres'}>
                📋 Offres ({offres.length})
            </button>
            <button class="tab" class:active={activeTab === 'etudiants'} onclick={() => activeTab = 'etudiants'}>
                🎓 Étudiants ({etudiants.length})
            </button>
            <button class="tab" class:active={activeTab === 'entreprises'} onclick={() => activeTab = 'entreprises'}>
                🏢 Entreprises ({entreprises.length})
            </button>
            <button class="tab" class:active={activeTab === 'stages'} onclick={() => activeTab = 'stages'}>
                🏁 Stages ({stages.length})
            </button>
            <button class="tab" class:active={activeTab === 'admins'} onclick={() => activeTab = 'admins'}>
                🛠️ Admins ({admins.length})
            </button>
            <button class="tab" class:active={activeTab === 'logs'} onclick={() => activeTab = 'logs'}>
                📜 Logs ({logs.length})
            </button>
        </div>

        {#if activeTab === 'etudiants'}
            <div class="table-container">
                {#if etudiants.length === 0}
                    <div class="empty">Aucun étudiant inscrit.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>N° étudiant</th>
                                <th>Rôle</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each etudiants as etu}
                                <tr>
                                    <td>{etu.nom}</td>
                                    <td>{etu.prenom}</td>
                                    <td class="email">{etu.email}</td>
                                    <td>{etu.num_etudiant}</td>
                                    <td>
                                        <span class="badge badge-{etu.role_id}">
                                            {roles[etu.role_id]}
                                        </span>
                                    </td>
                                    <td>{formatDate(etu.created_at)}</td>
                                    <td class="actions">
                                        {#if etu.role_id !== 1}
                                            <button class="btn-role" onclick={() => changeRole(etu.id, 1)}>
                                                → Admin
                                            </button>
                                        {/if}
                                        <button class="btn-danger" onclick={() => deleteUser(etu.id)}>
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}

        {#if activeTab === 'entreprises'}
            <div class="table-container">
                {#if entreprises.length === 0}
                    <div class="empty">Aucune entreprise inscrite.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>SIRET</th>
                                <th>Ville</th>
                                <th>Téléphone</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each entreprises as ent}
                                <tr>
                                    <td>{ent.nom}</td>
                                    <td class="email">{ent.email}</td>
                                    <td>{ent.siret}</td>
                                    <td>{ent.ville}</td>
                                    <td>{ent.num_tel}</td>
                                    <td>{formatDate(ent.created_at)}</td>
                                    <td class="actions">
                                        <button class="btn-danger" onclick={() => deleteUser(ent.id)}>
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}

        {#if activeTab === 'offres'}
            <div class="table-container">
                {#if offres.length === 0}
                    <div class="empty">Aucune offre publiée.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de l'offre</th>
                                <th>Entreprise</th>
                                <th>Publiée le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each offres as offre}
                                <tr>
                                    <td>{offre.nom}</td>
                                    <td>{offre.entreprise}</td>
                                    <td>{formatDate(offre.created_at)}</td>
                                    <td class="actions">
                                        <button class="btn-danger" onclick={() => deleteOffre(offre.id)}>
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}

        {#if activeTab === 'stages'}
            <div class="table-container">
                {#if stages.length === 0}
                    <div class="empty">Aucun stage confirmé.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Offre</th>
                                <th>Entreprise</th>
                                <th>Confirmé le</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each stages as stage}
                                <tr>
                                    <td>{stage.etudiant}</td>
                                    <td>{stage.offre}</td>
                                    <td>{stage.entreprise}</td>
                                    <td>{formatDate(stage.created_at)}</td>
                                    <td>
                                        {#if stage.archived}
                                            <span class="badge badge-archived">Archivé</span>
                                        {:else}
                                            <span class="badge badge-3">En cours</span>
                                        {/if}
                                    </td>
                                    <td class="actions">
                                        <button class="btn-role" onclick={() => archiverStage(stage.id, stage.archived)}>
                                            {stage.archived ? 'Désarchiver' : 'Archiver'}
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}

        {#if activeTab === 'admins'}
            <div class="table-container">
                {#if admins.length === 0}
                    <div class="empty">Aucun administrateur.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Identifiant</th>
                                <th>Email</th>
                                <th>Inscrit le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each admins as admin}
                                <tr>
                                    <td>{admin.name}</td>
                                    <td class="email">{admin.email}</td>
                                    <td>{formatDate(admin.created_at)}</td>
                                    <td class="actions">
                                        <button
                                            class="btn-role"
                                            onclick={() => changeRole(admin.id, 3)}
                                            disabled={admins.length === 1}
                                            title={admins.length === 1 ? 'Impossible de rétrograder le dernier admin' : ''}
                                        >
                                            → Étudiant
                                        </button>
                                        <button
                                            class="btn-danger"
                                            onclick={() => deleteUser(admin.id)}
                                            disabled={admins.length === 1}
                                            title={admins.length === 1 ? 'Impossible de supprimer le dernier admin' : ''}
                                        >
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}
        {#if activeTab === 'logs'}
            <div class="table-container">
                {#if logs.length === 0}
                    <div class="empty">Aucun événement enregistré.</div>
                {:else}
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Utilisateur</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            {#each logs as log}
                                {@const meta = logActionLabel[log.action] ?? { label: log.action, color: '#64748b' }}
                                <tr>
                                    <td class="log-date">{formatDate(log.created_at)}</td>
                                    <td class="email">{log.email}</td>
                                    <td>
                                        <span class="log-badge" style="background:{meta.color}22;color:{meta.color}">
                                            {meta.label}
                                        </span>
                                    </td>
                                    <td class="log-desc">{log.description}</td>
                                    <td class="log-ip">{log.ip ?? '—'}</td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                {/if}
            </div>
        {/if}

    </div>
</main>

<style>


    main {
        padding: 2rem 1.5rem 4rem;
        min-height: calc(100vh - 52px);
    }

    .content {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--ink-900);
        margin: 0 0 0.25rem 0;
    }
    .page-header p { color: var(--ink-600); margin: 0; }

    .btn-create-account {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1.1rem;
        border-radius: 8px;
        background: var(--primary-600);
        color: #fff;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: opacity 0.15s;
        flex-shrink: 0;
    }
    .btn-create-account:hover { opacity: 0.88; }

    .badge-archived { background: #f1f5f9; color: #64748b; }

    .alert-success {
        background: var(--badge-green-bg);
        color: var(--badge-green-text);
        border: 1px solid var(--badge-green-bg);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    /* stats — mobile-first */
    .stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    @media (min-width: 1100px) {
        .stats { grid-template-columns: repeat(4, 1fr); }
    }

    .stat-card {
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
    }

    .stat-card strong {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary-600);
        line-height: 1;
    }

    .stat-card span {
        display: block;
        margin-top: 0.4rem;
        color: var(--ink-600);
        font-size: 0.9rem;
    }

    /* tabs — mobile-first : tous arrondis, wrappés */
    .tabs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 0;
    }

    .tab {
        padding: 0.55rem 1rem;
        font-size: 0.9rem;
        font-weight: 600;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        color: var(--ink-600);
        cursor: pointer;
        font-family: inherit;
        border-radius: 10px;
        transition: background 0.15s, color 0.15s, border-color 0.15s;
    }

    .tab:hover:not(.active) { background: var(--surface-muted); color: var(--ink-900); }

    .tab.active {
        background: var(--surface-card);
        color: var(--primary-600);
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.1);
    }

    .table-container {
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
    }

    /* desktop : onglets style tabbar classique */
    @media (min-width: 1100px) {
        .tabs { flex-wrap: nowrap; }
        .tab {
            padding: 0.65rem 1.5rem;
            font-size: 0.95rem;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
        }
        .table-container { border-radius: 0 14px 14px 14px; }
    }

    table { width: 100%; border-collapse: collapse; }

    thead {
        background: var(--surface-subtle);
        border-bottom: 1px solid var(--border-200);
    }

    th {
        padding: 0.85rem 1rem;
        text-align: left;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    td {
        padding: 0.85rem 1rem;
        font-size: 0.9rem;
        color: var(--ink-900);
        border-bottom: 1px solid var(--border-200);
    }

    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--surface-subtle); }

    .email { color: var(--ink-600); font-size: 0.85rem; }

    .actions { display: flex; gap: 0.5rem; align-items: center; }

    .badge {
        padding: 0.25rem 0.6rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .badge-1 { background: #fef3c7; color: #d97706; }
    .badge-2 { background: #dbeafe; color: #2563eb; }
    .badge-3 { background: #dcfce7; color: #16a34a; }

    .btn-danger {
        padding: 0.35rem 0.75rem;
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s, transform 0.15s;
    }

    .btn-danger:hover { background: #fecaca; transform: translateY(-1px); }

    .btn-role {
        padding: 0.35rem 0.75rem;
        background: #fef3c7;
        color: #d97706;
        border: 1px solid #fde68a;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s, transform 0.15s;
    }

    .btn-role:hover { background: #fde68a; transform: translateY(-1px); }

    .tab:focus-visible,
    .btn-danger:focus-visible,
    .btn-role:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    .empty {
        padding: 3rem;
        text-align: center;
        color: var(--ink-600);
    }

    .log-badge {
        display: inline-block;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .log-date { font-size: 0.8rem; color: var(--ink-600); white-space: nowrap; }
    .log-desc { font-size: 0.85rem; color: var(--ink-700); }
    .log-ip   { font-size: 0.78rem; color: var(--ink-500); font-family: monospace; }

    @media (max-width: 720px) {
        main { padding: 1.2rem 0.8rem 3rem; }
        .stats { grid-template-columns: 1fr; }
    }
</style>