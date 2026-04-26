<script lang="ts">
    import Header from '@/components/Header.svelte';
    import { useForm } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import FormInput from '@/components/FormInput.svelte';
    import Button from '@/components/Button.svelte';

    let role: 'etudiant' | 'entreprise' = $state('etudiant');

    const formEtudiant = useForm({
        nom: '',
        prenom: '',
        num_etudiant: '',
        password: '',
        password_confirmation: '',
    });

    const formEntreprise = useForm({
        nom: '',
        siret: '',
        adresse: '',
        code_postal: '',
        ville: '',
        pays: '',
        num_tel: '',
        password: '',
        password_confirmation: '',
    });

    let errors: Record<string, string> = $state({});

    function validateEtudiant(): boolean {
        errors = {};
        if (!$formEtudiant.nom) errors.nom = "Le nom est obligatoire";
        if (!$formEtudiant.prenom) errors.prenom = "Le prénom est obligatoire";
        if (!$formEtudiant.num_etudiant) errors.num_etudiant = "Le numéro étudiant est obligatoire";
        if (!$formEtudiant.password) errors.password = "Le mot de passe est obligatoire";
        if (!$formEtudiant.password_confirmation) errors.password_confirmation = "Veuillez confirmer le mot de passe";
        if ($formEtudiant.password && $formEtudiant.password_confirmation && $formEtudiant.password !== $formEtudiant.password_confirmation) {
            errors.password_confirmation = "Les mots de passe ne correspondent pas";
            errors.password = " ";
        }
        return Object.keys(errors).length === 0;
    }

    function validateEntreprise(): boolean {
        errors = {};
        if (!$formEntreprise.nom) errors.nom = "L'appellation est obligatoire";
        if (!$formEntreprise.siret) errors.siret = "Le SIRET est obligatoire";
        if (!$formEntreprise.adresse) errors.adresse = "L'adresse est obligatoire";
        if (!$formEntreprise.code_postal) errors.code_postal = "Le code postal est obligatoire";
        if (!$formEntreprise.ville) errors.ville = "La ville est obligatoire";
        if (!$formEntreprise.pays) errors.pays = "Le pays est obligatoire";
        if (!$formEntreprise.num_tel) errors.num_tel = "Le numéro de téléphone est obligatoire";
        if (!$formEntreprise.password) errors.password = "Le mot de passe est obligatoire";
        if (!$formEntreprise.password_confirmation) errors.password_confirmation = "Veuillez confirmer le mot de passe";
        if ($formEntreprise.password && $formEntreprise.password_confirmation && $formEntreprise.password !== $formEntreprise.password_confirmation) {
            errors.password_confirmation = "Les mots de passe ne correspondent pas";
            errors.password = " ";
        }
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

<AppHead title="Créer un compte">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>


<Header/>
<main>
    <div class="box">
        <h1>Créer un compte</h1>
        <p class="subtitle">Choisissez votre profil et complétez les informations pour rejoindre CY Stage.</p>

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
                <FormInput id="num_etudiant" label="Numéro étudiant" placeholder="06 00 00 00 00" required bind:value={$formEtudiant.num_etudiant} error={errors.num_etudiant || $formEtudiant.errors.num_etudiant}></FormInput>
                <FormInput id="password" label="Mot de passe" placeholder="••••••••" required bind:value={$formEtudiant.password} error={errors.password || $formEtudiant.errors.password}></FormInput>
                <FormInput id="password_confirmation" label="Confirmer le mot de passe" placeholder="••••••••" required bind:value={$formEtudiant.password_confirmation} error={errors.password_confirmation || $formEtudiant.errors.password_confirmation}></FormInput>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <div class="subm">
                    <Button type="submit" variant="btnBleu" isFull>Créer le compte</Button>
                </div>
            </form>
        {/if}

        {#if role === 'entreprise'}
            <form id="creation_compte" onsubmit={submit}>
                <FormInput id="nom" label="Nom" placeholder="Nom de l'entreprise" required bind:value={$formEntreprise.nom} error={errors.nom || $formEntreprise.errors.nom}></FormInput>
                <FormInput id="siret" label="SIRET" placeholder="12345678901234" required bind:value={$formEntreprise.siret} error={errors.siret || $formEntreprise.errors.siret}></FormInput>
                <FormInput id="adresse" isFull label="Adresse" placeholder="15 rue de la paix" required bind:value={$formEntreprise.adresse} error={errors.adresse || $formEntreprise.errors.adresse}></FormInput>
                <FormInput id="code_postal" label="Code postal" placeholder="64000" required bind:value={$formEntreprise.code_postal} error={errors.code_postal || $formEntreprise.errors.code_postal}></FormInput>
                <FormInput id="ville"  label="Vile" placeholder="Pau" required bind:value={$formEntreprise.ville} error={errors.ville || $formEntreprise.errors.ville}></FormInput>
                <FormInput id="pays"  label="Pays" placeholder="France" required bind:value={$formEntreprise.pays} error={errors.pays || $formEntreprise.errors.pays}></FormInput>
                <FormInput id="num_tel"  label="Téléphone" placeholder="06 00 00 00 00" required bind:value={$formEntreprise.num_tel} error={errors.num_tel || $formEntreprise.errors.num_tel}></FormInput>
                <FormInput id="password" isFull label="Mot de passe" placeholder="••••••••" required bind:value={$formEntreprise.password} error={errors.password || $formEntreprise.errors.password }></FormInput>
                <FormInput id="password_confirmation" isFull label="Confirmer le mot de passe" placeholder="••••••••" required bind:value={$formEntreprise.password_confirmation} error={errors.password_confirmation || $formEntreprise.errors.password_confirmation}></FormInput>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <div class="subm">
                    <Button type="submit" variant="btnBleu" isFull>Créer le compte</Button>

                </div>
            </form>
        {/if}

        <div class="footer-links">
            <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
        </div>
    </div>
</main>

<style>


    .box {
        background: #ffffff;
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

    .role-selector {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.7rem;
        background: #f1f5f9;
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
        color: #64748b;
        transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }

    .role-btn.active {
        background: #ffffff;
        color: #1d4ed8;
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.16);
    }

    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
        align-items: flex-start;
    }


    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }





    .champ-obligatoire {
        grid-column: 1 / -1;
        font-size: 13px;
        color: #6c757d;
        margin-top: -0.25rem;
    }

    .footer-links {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
    }

    .footer-links a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }

    .footer-links a:hover { text-decoration: underline; }

    @media (max-width: 800px) {
        .box {
            padding: 1.8rem 1.2rem;
            border-radius: 16px;
        }

        form {
            grid-template-columns: 1fr;
            gap: 14px;
        }
    }

    .subm {
        grid-column: 1 / -1; 
        width: 100%;
    }

</style>