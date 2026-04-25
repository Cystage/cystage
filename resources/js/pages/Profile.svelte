<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm } from '@inertiajs/svelte';

    type Profile = {
        nom?: string;
        prenom?: string;
        email?: string;
        num_etudiant?: string;
        identifiant?: string;
        siret?: string,
        adresse?: string,
        code_postal?: string,
        ville?: string,
        pays?: string,
        num_tel?: string,
        type?: string,
    };
    let { profile }: { profile: Profile } = $props();

    let editing = $state(false);
    let activeTab = $state('profil');

    const form = useForm({
        nom:          profile?.nom          ?? '',
        prenom:       profile?.prenom       ?? '',
        num_etudiant: profile?.num_etudiant ?? '',
        siret:        profile?.siret        ?? '',
        adresse:      profile?.adresse      ?? '',
        code_postal:  profile?.code_postal  ?? '',
        ville:        profile?.ville        ?? '',
        pays:         profile?.pays         ?? '',
        num_tel:      profile?.num_tel      ?? '',
    });

    function submit(e: Event) {
        e.preventDefault();
        $form.patch('/profil', {
            onSuccess: () => { editing = false; }
        });
    }

    let fields = $derived(
        profile?.type == '1' ? [
            { label: 'Identifiant', key: null, value: profile?.nom,   full: true },
            { label: 'Email',       key: null, value: profile?.email, full: true },
        ] :
        profile?.type == '3' ? [
            { label: 'Nom',              key: 'nom',          value: profile?.nom },
            { label: 'Prénom',           key: 'prenom',       value: profile?.prenom },
            { label: 'Email',            key: null,           value: profile?.email,        full: true },
            { label: 'Numéro étudiant',  key: 'num_etudiant', value: profile?.num_etudiant },
            { label: 'Identifiant',      key: null,           value: profile?.identifiant },
        ] : [
            { label: 'Appellation', key: 'nom',        value: profile?.nom,        full: true },
            { label: 'Email',       key: null,          value: profile?.email,       full: true },
            { label: 'Identifiant', key: null,          value: profile?.identifiant },
            { label: 'SIRET',       key: 'siret',       value: profile?.siret },
            { label: 'Adresse',     key: 'adresse',     value: profile?.adresse,     full: true },
            { label: 'Code postal', key: 'code_postal', value: profile?.code_postal },
            { label: 'Ville',       key: 'ville',       value: profile?.ville },
            { label: 'Pays',        key: 'pays',        value: profile?.pays },
            { label: 'Téléphone',   key: 'num_tel',     value: profile?.num_tel },
        ]
    );
    
    function getFullName() {
        const prenom = profile?.prenom?.trim() ?? '';
        const nom = profile?.nom?.trim() ?? '';
        const value = `${prenom} ${nom}`.trim();
        return value !== '' ? value : 'Profil utilisateur';
    }

    function getInitials() {
        const parts = getFullName().split(/\s+/).filter(Boolean);
        const first = parts[0]?.[0] ?? 'P';
        const second = parts[1]?.[0] ?? '';
        return `${first}${second}`.toUpperCase();
    }

    function displayValue(value: string | null | undefined) {
        return value && value.trim() !== '' ? value : 'Non renseigné';
    }
</script>

<AppHead title="Mon espace" />
<Header />

<main class="page-container">
    <div class="content">
        <p class="greeting">Bonjour, {getFullName()}</p>

        <div class="Y1">
            <div class="Bande">Mon espace</div>
            <div class="profile-header">
                <div class="avatar">{getInitials()}</div>
                <p class="profile-name">{getFullName()}</p>
            </div>
        </div>

        {#if profile?.type == '3'}
            <div class="tabs">
                <button class="tab" class:active={activeTab === 'profil'} onclick={() => activeTab = 'profil'}>
                    Mon profil
                </button>
                <button class="tab" class:active={activeTab === 'candidatures'} onclick={() => activeTab = 'candidatures'}>
                    Mes candidatures
                </button>
            </div>
        {/if}

        {#if profile?.type == '2'}
            <div class="tabs">
                <button class="tab" class:active={activeTab === 'profil'} onclick={() => activeTab = 'profil'}>
                    Mon profil
                </button>
                <button class="tab" class:active={activeTab === 'candidatures'} onclick={() => activeTab = 'candidatures'}>
                    Candidatures reçues
                </button>
            </div>
        {/if}

        {#if activeTab === 'profil'}
            <div class="Y2">
                <form onsubmit={submit}>
                    {#each fields as field, index}
                        <div class={`form-group ${field.full ? 'form-group-full' : ''}`.trim()}>
                            <label for={`profile-field-${index}`}>{field.label}</label>

                            {#if editing && field.key}
                                <input
                                    id={`profile-field-${index}`}
                                    type="text"
                                    bind:value={$form[field.key]}
                                />
                                {#if $form.errors[field.key]}
                                    <span class="erreur">{$form.errors[field.key]}</span>
                                {/if}
                            {:else}
                                <input
                                    id={`profile-field-${index}`}
                                    type="text"
                                    value={displayValue(field.value)}
                                    disabled
                                />
                            {/if}
                        </div>
                    {/each}

                    <div class="form-actions">
                        {#if editing}
                            <button type="submit" class="btn-save">Enregistrer</button>
                            <button type="button" class="btn-cancel" onclick={() => editing = false}>Annuler</button>
                        {:else}
                            <button type="button" class="btn-edit" onclick={() => editing = true}>Modifier le profil</button>
                        {/if}
                    </div>
                </form>

                <a class="back" href="/">← Retour à l'accueil</a>
            </div>
        {/if}

        {#if activeTab === 'candidatures'}
            <div class="Y2">
            {#if profile?.type == '3'}
                <div class="empty-state">
                    <p class="empty-icon">📋</p>
                    <p class="empty-title">Aucune candidature pour le moment</p>
                    <p class="empty-sub">Les offres auxquelles vous postulez apparaîtront ici.</p>
                    <a class="btn-edit" href="/">Voir les offres disponibles</a>
                </div>
            {/if}
            {#if profile?.type == '2'}
                <div class="empty-state">
                    <p class="empty-icon">👥</p>
                    <p class="empty-title">Aucune candidature reçue pour le moment</p>
                    <p class="empty-sub">Les étudiants ayant postulé à vos offres apparaîtront ici.</p>
                </div>
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
        --primary-50: #eff6ff;
        --ink-900: #0f172a;
        --ink-600: #475569;
        --border-200: #e2e8f0;
        margin: 0;
        font-family: "Plus Jakarta Sans", sans-serif;
        background: linear-gradient(180deg, #f3f8ff 0%, #ffffff 30%, #f8fafc 100%);
    }

    .greeting {
        margin: 0 0 16px;
        font-size: clamp(1.4rem, 2.4vw, 1.75rem);
        font-weight: 700;
        color: var(--ink-900);
    }

    .Bande {
        background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        color: white;
        margin-bottom: 14px;
        padding: 22px 24px;
        font-size: clamp(1.45rem, 2.8vw, 1.9rem);
        font-weight: bold;
        border-radius: 14px;
    }

    .page-container {
        width: 100%;
        display: flex;
        min-height: 100vh;
        background: transparent;
    }

    .content {
        width: 100%;
        padding: 24px 20px 40px;
        max-width: 1040px;
        margin: 0 auto;
    }

    .Y1, .Y2 {
        background: #fff;
        border: 1px solid var(--border-200);
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
    }

    .Y1 { margin-bottom: 0; }
    .Y2 { margin-top: 0; border-top-left-radius: 0; border-top-right-radius: 0; border-top: none; }

    .tabs {
        display: flex;
        gap: 0;
        margin-top: 16px;
    }

    .tab {
        padding: 0.7rem 1.2rem;
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

    .tab:first-child { margin-right: 4px; }

    .tab.active {
        background: #fff;
        color: var(--primary-700);
        border-color: #e5e7eb;
        position: relative;
        z-index: 1;
    }

    .Y2 form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
        align-items: flex-start;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.form-group-full { grid-column: 1 / -1; }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        background-color: #fff;
        margin-bottom: 0;
    }

    .form-group input:disabled {
        background-color: #f8fafc;
        color: #64748b;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .erreur { color: #dc3545; font-size: 13px; }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .btn-edit, .btn-save, .btn-cancel {
        padding: 0.6rem 1.25rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-family: inherit;
        text-decoration: none;
        display: inline-block;
        transition: background 0.15s, transform 0.15s;
    }

    .btn-edit   { background: #2563eb; color: white; }
    .btn-edit:hover   { background: #1d4ed8; transform: translateY(-1px); }
    .btn-save   { background: #16a34a; color: white; }
    .btn-save:hover   { background: #15803d; transform: translateY(-1px); }
    .btn-cancel { background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; }
    .btn-cancel:hover { background: #e2e8f0; transform: translateY(-1px); }

    .btn-edit:focus-visible,
    .btn-save:focus-visible,
    .btn-cancel:focus-visible,
    .tab:focus-visible,
    .form-group input:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .avatar {
        background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        color: #fff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .profile-name {
        margin: 0;
        font-weight: bold;
        font-size: 18px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        gap: 0.5rem;
        text-align: center;
    }

    .empty-icon { font-size: 3rem; }

    .empty-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .empty-sub {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 1rem;
    }

    .back {
        display: inline-block;
        margin-top: 16px;
        text-decoration: none;
        color: var(--primary-600);
        font-weight: 600;
    }

    @media (max-width: 760px) {
        .content {
            padding: 16px 12px 28px;
        }

        .Y2 form {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .tabs {
            flex-wrap: wrap;
            gap: 8px;
        }

        .tab {
            border-radius: 10px;
            border-bottom: 1px solid var(--border-200);
        }

        .Y2 {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            border-top: 1px solid var(--border-200);
            margin-top: 10px;
        }
    }
</style>
