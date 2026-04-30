<script lang="ts">
    import EntreprisePostulation from './EntreprisePostulation.svelte';
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';
    import { onMount } from 'svelte';

    type Profile = {
        nom?: string;
        prenom?: string;
        email?: string;
        num_etudiant?: string;
        identifiant?: string;
        siret?: string;
        adresse?: string;
        code_postal?: string;
        ville?: string;
        pays?: string;
        num_tel?: string;
        logo?: string;
        type?: string;
        notif_mail?: boolean;
        two_factor_enabled?: boolean;
    };

    let { profile, postulations = [] }: { profile: Profile; postulations?: any[] } = $props();

    let editing = $state(false);
    let activeTab = $state('profil');
    let showDeleteConfirm = $state(false);

    onMount(() => {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab');
        if (tab === 'candidatures' || tab === 'parametres') activeTab = tab;
    });

    let success = $derived(($page.props as any).flash?.success);

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
        logo:         null as File | null,
    });

    const settingsForm = useForm({
        notif_mail: profile?.notif_mail ?? true,
    });

    const twoFaForm = useForm({});

    const deleteForm = useForm({});

    function handleLogo(e: Event) {
        const input = e.target as HTMLInputElement;
        const file = input.files?.[0];
        if (file) $form.logo = file;
    }

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/profil', {
            forceFormData: true,
            onSuccess: () => { editing = false; }
        });
    }

    function submitSettings(e: Event) {
        e.preventDefault();
        $settingsForm.patch('/settings/notif-mail', { preserveState: true });
    }

    function deleteAccount() {
        $deleteForm.delete('/account');
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
                {#if profile?.logo}
                    <img src={profile.logo} alt="Logo {profile.nom}" class="logo-preview" loading="lazy" />
                {:else}
                    <div class="avatar">{getInitials()}</div>
                {/if}
                <p class="profile-name">{getFullName()}</p>
            </div>
        </div>

        <div class="tabs">
            <button class="tab" class:active={activeTab === 'profil'} onclick={() => activeTab = 'profil'}>
                Mon profil
            </button>
            {#if profile?.type == '3'}
                <button class="tab" class:active={activeTab === 'candidatures'} onclick={() => activeTab = 'candidatures'}>
                    Mes candidatures
                </button>
            {:else if profile?.type == '2'}
                <button class="tab" class:active={activeTab === 'candidatures'} onclick={() => activeTab = 'candidatures'}>
                    Candidatures reçues
                </button>
            {/if}
            <button class="tab" class:active={activeTab === 'parametres'} onclick={() => activeTab = 'parametres'}>
                Paramètres
            </button>
        </div>

        {#if activeTab === 'profil'}
            <div class="Y2">
                {#if success}
                    <div class="alert-success">{success}</div>
                {/if}
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
                            {#if profile?.type == '2' && editing}
                            <div class="form-group form-group-full">
                                <label for="company-logo">Logo de l'entreprise</label>
                                {#if profile?.logo}
                                    <img src={`/storage/${profile.logo}`} alt="Logo actuel" class="logo-preview"/>
                                {/if}
                                <input id="company-logo" type="file" accept="image/*" onchange={handleLogo} />
                            </div>
                            {/if}
                            <Button type="submit" variant="btnGreen">Enregistrer</Button>
                            <Button type="button" variant="btnGrey" onclick={() => editing = false}>Annuler</Button>
                        {:else}
                            <Button onclick={() => editing = true} variant="btnBleu">Modifier le profil</Button>
                        {/if}
                    </div>
                </form>

                <a class="back" href="/">← Retour à l'accueil</a>
            </div>
        {/if}

        {#if activeTab === 'candidatures'}
            <div class="Y2">
                <EntreprisePostulation {postulations} {profile}/>
            </div>
        {/if}

        {#if activeTab === 'parametres'}
            <div class="Y2 settings">

                {#if success && activeTab === 'parametres'}
                    <div class="alert-success">{success}</div>
                {/if}

                <!-- Notifications -->
                <section class="settings-section">
                    <div class="settings-section-header">
                        <div class="settings-icon notif-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </div>
                        <div>
                            <h2 class="settings-section-title">Notifications</h2>
                            <p class="settings-section-desc">Gérez vos préférences de communication</p>
                        </div>
                    </div>
                    <form onsubmit={submitSettings}>
                        <div class="setting-row">
                            <div class="setting-info">
                                <span class="setting-label">Notifications par email</span>
                                <span class="setting-desc">Recevoir un email lors d'une candidature, acceptation ou confirmation de stage</span>
                            </div>
                            <label class="toggle" for="notif_mail">
                                <input type="checkbox" id="notif_mail" bind:checked={$settingsForm.notif_mail} onchange={submitSettings}/>
                                <span class="toggle-track"></span>
                            </label>
                        </div>
                    </form>
                </section>

                <!-- Sécurité -->
                <section class="settings-section">
                    <div class="settings-section-header">
                        <div class="settings-icon security-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <div>
                            <h2 class="settings-section-title">Sécurité</h2>
                            <p class="settings-section-desc">Mot de passe et double authentification</p>
                        </div>
                    </div>
                    <div class="setting-row" style="margin-bottom:0.75rem">
                        <div class="setting-info">
                            <span class="setting-label">Mot de passe</span>
                            <span class="setting-desc">Un email de réinitialisation sera envoyé à {profile?.email}</span>
                        </div>
                        <a href="/forgot-password" class="btn-setting">Changer</a>
                    </div>
                    <div class="setting-row">
                        <div class="setting-info">
                            <span class="setting-label">Double authentification (2FA)</span>
                            <span class="setting-desc">
                                {profile?.two_factor_enabled ? 'Activée — un code email est requis à chaque connexion' : 'Désactivée — connexion directe avec email + mot de passe'}
                            </span>
                        </div>
                        <label class="toggle" for="two_factor">
                            <input
                                type="checkbox"
                                id="two_factor"
                                checked={profile?.two_factor_enabled ?? false}
                                onchange={() => $twoFaForm.patch('/settings/two-factor', { preserveState: true })}
                            />
                            <span class="toggle-track"></span>
                        </label>
                    </div>
                </section>

                <!-- Danger -->
                <section class="settings-section danger-section">
                    <div class="settings-section-header">
                        <div class="settings-icon danger-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        </div>
                        <div>
                            <h2 class="settings-section-title danger-title">Zone de danger</h2>
                            <p class="settings-section-desc">Actions irréversibles sur votre compte</p>
                        </div>
                    </div>

                    {#if !showDeleteConfirm}
                        <div class="setting-row">
                            <div class="setting-info">
                                <span class="setting-label">Supprimer mon compte</span>
                                <span class="setting-desc">Supprime définitivement votre compte et toutes vos données</span>
                            </div>
                            <button class="btn-danger-setting" onclick={() => showDeleteConfirm = true}>
                                Supprimer
                            </button>
                        </div>
                    {:else}
                        <div class="delete-confirm">
                            <p class="delete-confirm-text">
                                Êtes-vous sûr ? Cette action est <strong>irréversible</strong>. Toutes vos données seront supprimées.
                            </p>
                            <div class="delete-confirm-actions">
                                <button class="btn-setting" onclick={() => showDeleteConfirm = false}>Annuler</button>
                                <button class="btn-danger-setting" onclick={deleteAccount} disabled={$deleteForm.processing}>
                                    {$deleteForm.processing ? 'Suppression...' : 'Oui, supprimer mon compte'}
                                </button>
                            </div>
                        </div>
                    {/if}
                </section>

            </div>
        {/if}

    </div>
</main>

<style>
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
        background: var(--surface-card);
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
        background: var(--surface-subtle);
        color: var(--ink-600);
        cursor: pointer;
        font-family: inherit;
        border-radius: 10px 10px 0 0;
        transition: background 0.15s, color 0.15s;
        margin-right: 4px;
    }

    .tab.active {
        background: var(--surface-card);
        color: var(--primary-700);
        border-color: var(--border-200);
        position: relative;
        z-index: 1;
    }

    /* ── Profile form — mobile-first ── */
    .Y2 form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        align-items: flex-start;
    }

    @media (min-width: 640px) {
        .Y2 form {
            grid-template-columns: 1fr 1fr;
            gap: 18px 24px;
        }
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
        color: var(--ink-600);
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-200);
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        background-color: var(--surface-card);
        color: var(--ink-900);
        margin-bottom: 0;
        box-sizing: border-box;
    }

    .form-group input:disabled {
        background-color: var(--surface-subtle);
        color: var(--ink-600);
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

    .alert-success {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        grid-column: 1 / -1;
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
        flex-shrink: 0;
    }

    .profile-name {
        margin: 0;
        font-weight: bold;
        font-size: 18px;
    }

    .back {
        display: inline-block;
        margin-top: 16px;
        text-decoration: none;
        color: var(--primary-600);
        font-weight: 600;
    }

    .logo-preview {
        width: 80px;
        height: 80px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        margin-bottom: 0.5rem;
    }

    /* ── Settings tab ── */
    .settings { padding: 0; }

    .settings-section {
        padding: 1.5rem 1.75rem;
        border-bottom: 1px solid var(--border-200);
    }

    .settings-section:last-child { border-bottom: none; }

    .settings-section-header {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .settings-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notif-icon { background: #eff6ff; color: #2563eb; }
    .security-icon { background: #f0fdf4; color: #16a34a; }
    .danger-icon { background: #fff1f2; color: #e11d48; }

    .settings-section-title {
        margin: 0 0 2px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--ink-900);
    }

    .danger-title { color: #e11d48; }

    .settings-section-desc {
        margin: 0;
        font-size: 0.82rem;
        color: var(--ink-600);
    }

    .setting-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        padding: 0.85rem 1rem;
        background: var(--surface-subtle);
        border: 1px solid var(--border-200);
        border-radius: 10px;
    }

    .setting-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .setting-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--ink-900);
    }

    .setting-desc {
        font-size: 0.8rem;
        color: var(--ink-600);
    }

    /* Toggle */
    .toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .toggle input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-track {
        width: 44px;
        height: 24px;
        border-radius: 999px;
        background: var(--surface-muted);
        border: 1px solid var(--border-200);
        transition: background 0.2s, border-color 0.2s;
        position: relative;
    }

    .toggle-track::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--ink-600);
        transition: transform 0.2s, background 0.2s;
    }

    .toggle input:checked + .toggle-track {
        background: var(--primary-600);
        border-color: var(--primary-600);
    }

    .toggle input:checked + .toggle-track::after {
        transform: translateX(20px);
        background: #fff;
    }

    /* Buttons */
    .btn-setting {
        padding: 0.45rem 1rem;
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--ink-700);
        cursor: pointer;
        font-family: inherit;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .btn-setting:hover { background: var(--surface-subtle); }

    .btn-danger-setting {
        padding: 0.45rem 1rem;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #e11d48;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .btn-danger-setting:hover { background: #ffe4e6; }
    .btn-danger-setting:disabled { opacity: 0.6; cursor: not-allowed; }

    .danger-section .setting-row { border-color: #fecdd3; }

    .delete-confirm {
        padding: 1rem;
        background: #fff1f2;
        border: 1px solid #fecdd3;
        border-radius: 10px;
    }

    .delete-confirm-text {
        margin: 0 0 1rem;
        font-size: 0.9rem;
        color: #9f1239;
        line-height: 1.5;
    }

    .delete-confirm-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
    }

    @media (max-width: 760px) {
        .content { padding: 16px 12px 28px; }

        .Y2 form { grid-template-columns: 1fr; gap: 14px; }

        .tabs { flex-wrap: wrap; gap: 4px; }

        .tab {
            border-radius: 10px;
            border-bottom: 1px solid var(--border-200);
            margin-right: 0;
        }

        .Y2 {
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
            border-top: 1px solid var(--border-200);
            margin-top: 10px;
        }

        .settings-section { padding: 1.25rem 1rem; }

        .setting-row { flex-direction: column; align-items: flex-start; gap: 0.75rem; }

        .delete-confirm-actions { flex-direction: column-reverse; }
    }
</style>
