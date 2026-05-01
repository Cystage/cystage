<script lang="ts">
    import Header from '@/components/Header.svelte';
    import { useForm, page } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import FormInput from '@/components/FormInput.svelte';
    import Button from '@/components/Button.svelte';

    let role: 'etudiant' | 'entreprise' = $state('etudiant');

    const formEtudiant = useForm({
        nom: '',
        prenom: '',
        num_etudiant: '',
    });

    const formEntreprise = useForm({
        nom: '',
        siret: '',
        email: '',
        adresse: '',
        code_postal: '',
        ville: '',
        pays: '',
        num_tel: '',
    });

    let success = $derived(($page.props as any).flash?.success);

    let errors: Record<string, string> = $state({});

    function validateEtudiant(): boolean {
        errors = {};
        if (!$formEtudiant.nom) errors.nom = "Le nom est obligatoire";
        if (!$formEtudiant.prenom) errors.prenom = "Le prénom est obligatoire";
        if (!$formEtudiant.num_etudiant) errors.num_etudiant = "Le numéro étudiant est obligatoire";
        return Object.keys(errors).length === 0;
    }

    function validateEntreprise(): boolean {
        errors = {};
        if (!$formEntreprise.nom) errors.nom = "L'appellation est obligatoire";
        if (!$formEntreprise.siret) errors.siret = "Le SIRET est obligatoire";
        if (!$formEntreprise.email) errors.email = "L'email est obligatoire";
        if (!$formEntreprise.adresse) errors.adresse = "L'adresse est obligatoire";
        if (!$formEntreprise.code_postal) errors.code_postal = "Le code postal est obligatoire";
        if (!$formEntreprise.ville) errors.ville = "La ville est obligatoire";
        if (!$formEntreprise.pays) errors.pays = "Le pays est obligatoire";
        if (!$formEntreprise.num_tel) errors.num_tel = "Le numéro de téléphone est obligatoire";
        return Object.keys(errors).length === 0;
    }

    function submit(e: Event) {
        e.preventDefault();
        if (role === 'etudiant') {
            if (!validateEtudiant()) return;
            $formEtudiant.post('/register');
        } else {
            if (!validateEntreprise()) return;
            $formEntreprise.post('/newent');
        }
    }

    function switchRole(r: 'etudiant' | 'entreprise') {
        role = r;
        errors = {};
    }
</script>

<AppHead title="Créer un compte" description="Inscrivez-vous sur CyStage en tant qu'étudiant ou entreprise pour accéder à la plateforme de stages." />


<Header/>
<main>
    <div class="box">
        <h1>Créer un compte</h1>
        <p class="subtitle">Renseignez les informations — l'utilisateur recevra un mail pour définir son mot de passe.</p>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        <div class="role-selector">
            <button
                type="button"
                class="role-btn"
                class:active={role === 'etudiant'}
                onclick={() => switchRole('etudiant')}
            >
                🎓 Étudiant
            </button>
            <button
                type="button"
                class="role-btn"
                class:active={role === 'entreprise'}
                onclick={() => switchRole('entreprise')}
            >
                🏢 Entreprise
            </button>
        </div>

        {#if role === 'etudiant'}
            <form id="creation_compte" onsubmit={submit}>
                <FormInput id="nom" label="Nom" placeholder="Nom" required bind:value={$formEtudiant.nom} error={errors.nom || $formEtudiant.errors.nom}></FormInput>
                <FormInput id="prenom" label="Prénom" placeholder="Prénom" required bind:value={$formEtudiant.prenom} error={errors.prenom || $formEtudiant.errors.prenom}></FormInput>
                <FormInput id="num_etudiant" label="Numéro étudiant" placeholder="22100700" required bind:value={$formEtudiant.num_etudiant} error={errors.num_etudiant || $formEtudiant.errors.num_etudiant}></FormInput>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <div class="subm">
                    <Button type="submit" variant="btnBleu" isFull>Créer le compte</Button>
                </div>
            </form>
        {/if}

        {#if role === 'entreprise'}
            <form id="form_entreprise" onsubmit={submit}>
                <FormInput id="nom" label="Nom" placeholder="Nom de l'entreprise" required bind:value={$formEntreprise.nom} error={errors.nom || $formEntreprise.errors.nom}></FormInput>
                <FormInput id="siret" label="SIRET" placeholder="12345678901234" required bind:value={$formEntreprise.siret} error={errors.siret || $formEntreprise.errors.siret}></FormInput>
                <FormInput id="email" label="Email" placeholder="email@entreprise.com" required bind:value={$formEntreprise.email} error={errors.email || $formEntreprise.errors.email}></FormInput>
                <FormInput id="adresse" isFull label="Adresse" placeholder="15 rue de la paix" required bind:value={$formEntreprise.adresse} error={errors.adresse || $formEntreprise.errors.adresse}></FormInput>
                <FormInput id="code_postal" label="Code postal" placeholder="64000" required bind:value={$formEntreprise.code_postal} error={errors.code_postal || $formEntreprise.errors.code_postal}></FormInput>
                <FormInput id="ville"  label="Ville" placeholder="Pau" required bind:value={$formEntreprise.ville} error={errors.ville || $formEntreprise.errors.ville}></FormInput>
                <FormInput id="pays"  label="Pays" placeholder="France" required bind:value={$formEntreprise.pays} error={errors.pays || $formEntreprise.errors.pays}></FormInput>
                <FormInput id="num_tel"  label="Téléphone" placeholder="0612345678" required bind:value={$formEntreprise.num_tel} error={errors.num_tel || $formEntreprise.errors.num_tel}></FormInput>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <div class="subm">
                    <Button type="submit" variant="btnBleu" isFull>Créer le compte</Button>

                </div>
            </form>
        {/if}

    </div>
</main>

<style>


    .box {
        background: var(--surface-card);
        border-radius: 20px;
        border: 1px solid var(--border-200);
        padding: 2.5rem;
        width: 760px;
        max-width: 100%;
        box-shadow: 0 20px 42px rgba(15, 23, 42, 0.08);
    }

    h1 {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--ink-900);
        margin-bottom: 0.6rem;
        text-align: center;
    }

    .subtitle {
        text-align: center;
        color: var(--ink-600);
        margin-bottom: 1.6rem;
        font-size: 0.95rem;
    }

    .alert-success {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 0.85rem 1rem;
        margin-bottom: 1.25rem;
        font-size: 0.9rem;
        text-align: center;
    }

    .role-selector {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.7rem;
        background: var(--surface-muted);
        padding: 0.4rem;
        border-radius: 12px;
        border: 1px solid var(--border-200);
    }

    .role-btn {
        flex: 1;
        padding: 0.65rem 1rem;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        background: transparent;
        color: var(--ink-600);
        transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }

    .role-btn.active {
        background: var(--surface-card);
        color: var(--primary-600);
        border: 1px solid var(--primary-600);
        box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.1);
    }

    /* mobile-first */
    form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        align-items: flex-start;
    }

    @media (min-width: 640px) {
        form { grid-template-columns: 1fr 1fr; gap: 18px 24px; }
    }




    .champ-obligatoire {
        grid-column: 1 / -1;
        font-size: 13px;
        color: var(--ink-600);
        margin-top: -0.25rem;
    }

    .footer-links {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.875rem;
        color: var(--ink-600);
    }

    .footer-links a {
        color: var(--primary-600);
        font-weight: 600;
        text-decoration: none;
    }

    .footer-links a:hover { text-decoration: underline; }

    @media (max-width: 640px) {
        .box { padding: 1.5rem 1rem; border-radius: 16px; }
    }

    .subm {
        grid-column: 1 / -1; 
        width: 100%;
    }

</style>