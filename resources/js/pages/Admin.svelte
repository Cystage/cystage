<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';

    let { etudiants, entreprises, offres, admins} = $props();

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

    function formatDate(date: string) {
        return new Date(date).toLocaleDateString('fr-FR');
    }

    const roles: Record<number, string> = {
        1: 'Admin',
        2: 'Entreprise',
        3: 'Étudiant',
    };
</script>

<AppHead title="Administration" />
<Header />

<main>
    <div class="content">
        <div class="page-header">
            <h1>🛠️ Administration</h1>
            <p>Gestion des utilisateurs et des offres de la plateforme</p>
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
                <strong>{admins.length}</strong>
                <span>Administrateurs</span>
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
            <button class="tab" class:active={activeTab === 'admins'} onclick={() => activeTab = 'admins'}>
                🛠️ Admins ({admins.length})
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
    </div>
</main>

<style>
    * { box-sizing: border-box; }

    :global(body) {
        --primary-700: #1d4ed8;
        --primary-600: #2563eb;
        --primary-100: #dbeafe;
        --ink-900: #0f172a;
        --ink-600: #475569;
        --border-200: #e2e8f0;
        margin: 0;
        font-family: "Plus Jakarta Sans", sans-serif;
        background: linear-gradient(180deg, #f3f8ff 0%, #ffffff 30%, #f8fafc 100%);
    }

    main {
        min-height: calc(100vh - 64px);
        background: transparent;
        padding: 2rem 1.5rem;
    }

    .content {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-header { margin-bottom: 2rem; }
    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--ink-900);
        margin: 0 0 0.25rem 0;
    }
    .page-header p { color: var(--ink-600); margin: 0; }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
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

    .tabs {
        display: flex;
        gap: 6px;
        margin-bottom: 0;
    }

    .tab {
        padding: 0.65rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 600;
        border: 1px solid var(--border-200);
        border-bottom: none;
        background: #f8fafc;
        color: var(--ink-600);
        cursor: pointer;
        font-family: inherit;
        border-radius: 10px 10px 0 0;
        transition: background 0.15s, color 0.15s;
    }

    .tab.active {
        background: #fff;
        color: var(--primary-700);
    }

    .table-container {
        background: white;
        border: 1px solid var(--border-200);
        border-radius: 0 14px 14px 14px;
        overflow: hidden;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.06);
    }

    table { width: 100%; border-collapse: collapse; }

    thead {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    th {
        padding: 0.85rem 1rem;
        text-align: left;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    td {
        padding: 0.85rem 1rem;
        font-size: 0.9rem;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f8fafc; }

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

    @media (max-width: 1100px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .tabs {
            flex-wrap: wrap;
        }

        .tab {
            border-radius: 10px;
            border-bottom: 1px solid var(--border-200);
        }

        .table-container {
            border-radius: 14px;
            overflow-x: auto;
        }
    }

    @media (max-width: 720px) {
        main {
            padding: 1.2rem 0.8rem;
        }

        .stats {
            grid-template-columns: 1fr;
        }
    }
</style>