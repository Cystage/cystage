<script lang="ts">
    import Header from '@/components/Header.svelte';
    import { useForm } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';

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
                <div class="form-group">
                    <label for="nom">Nom <span class="required">*</span></label>
                    <input type="text" id="nom" placeholder="Nom"
                        bind:value={$formEtudiant.nom}
                        class:input-error={errors.nom || $formEtudiant.errors.nom}
                    />
                    <span class="error-message">{errors.nom || $formEtudiant.errors.nom || ''}</span>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom <span class="required">*</span></label>
                    <input type="text" id="prenom" placeholder="Prénom"
                        bind:value={$formEtudiant.prenom}
                        class:input-error={errors.prenom || $formEtudiant.errors.prenom}
                    />
                    <span class="error-message">{errors.prenom || $formEtudiant.errors.prenom || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="num_etudiant">Numéro étudiant <span class="required">*</span></label>
                    <input type="text" id="num_etudiant" placeholder="12345678"
                        bind:value={$formEtudiant.num_etudiant}
                        class:input-error={errors.num_etudiant || $formEtudiant.errors.num_etudiant}
                    />
                    <span class="error-message">{errors.num_etudiant || $formEtudiant.errors.num_etudiant || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="password">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="password" placeholder="••••••••"
                        bind:value={$formEtudiant.password}
                        class:input-error={errors.password || $formEtudiant.errors.password}
                    />
                    <span class="error-message">{errors.password || $formEtudiant.errors.password || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" placeholder="••••••••"
                        bind:value={$formEtudiant.password_confirmation}
                        class:input-error={errors.password_confirmation || $formEtudiant.errors.password_confirmation}
                    />
                    <span class="error-message">{errors.password_confirmation || $formEtudiant.errors.password_confirmation || ''}</span>
                </div>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <input type="submit" id="creer" value="Créer le compte" />
            </form>
        {/if}

        {#if role === 'entreprise'}
            <form id="creation_compte" onsubmit={submit}>
                <div class="form-group">
                    <label for="nom">Appellation <span class="required">*</span></label>
                    <input type="text" id="nom" placeholder="Nom de l'entreprise"
                        bind:value={$formEntreprise.nom}
                        class:input-error={errors.nom || $formEntreprise.errors.nom}
                    />
                    <span class="error-message">{errors.nom || $formEntreprise.errors.nom || ''}</span>
                </div>

                <div class="form-group">
                    <label for="siret">SIRET <span class="required">*</span></label>
                    <input type="text" id="siret" placeholder="12345678901234"
                        bind:value={$formEntreprise.siret}
                        class:input-error={errors.siret || $formEntreprise.errors.siret}
                    />
                    <span class="error-message">{errors.siret || $formEntreprise.errors.siret || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="adresse">Adresse <span class="required">*</span></label>
                    <input type="text" id="adresse" placeholder="666 rue du diable"
                        bind:value={$formEntreprise.adresse}
                        class:input-error={errors.adresse || $formEntreprise.errors.adresse}
                    />
                    <span class="error-message">{errors.adresse || $formEntreprise.errors.adresse || ''}</span>
                </div>

                <div class="form-group">
                    <label for="code_postal">Code postal <span class="required">*</span></label>
                    <input type="text" id="code_postal" placeholder="64000"
                        bind:value={$formEntreprise.code_postal}
                        class:input-error={errors.code_postal || $formEntreprise.errors.code_postal}
                    />
                    <span class="error-message">{errors.code_postal || $formEntreprise.errors.code_postal || ''}</span>
                </div>

                <div class="form-group">
                    <label for="ville">Ville <span class="required">*</span></label>
                    <input type="text" id="ville" placeholder="Pau"
                        bind:value={$formEntreprise.ville}
                        class:input-error={errors.ville || $formEntreprise.errors.ville}
                    />
                    <span class="error-message">{errors.ville || $formEntreprise.errors.ville || ''}</span>
                </div>

                <div class="form-group">
                    <label for="pays">Pays <span class="required">*</span></label>
                    <input type="text" id="pays" placeholder="France"
                        bind:value={$formEntreprise.pays}
                        class:input-error={errors.pays || $formEntreprise.errors.pays}
                    />
                    <span class="error-message">{errors.pays || $formEntreprise.errors.pays || ''}</span>
                </div>

                <div class="form-group">
                    <label for="num_tel">Téléphone <span class="required">*</span></label>
                    <input type="tel" id="num_tel" placeholder="06 06 06 06 06"
                        bind:value={$formEntreprise.num_tel}
                        class:input-error={errors.num_tel || $formEntreprise.errors.num_tel}
                    />
                    <span class="error-message">{errors.num_tel || $formEntreprise.errors.num_tel || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="password">Mot de passe <span class="required">*</span></label>
                    <input type="password" id="password" placeholder="••••••••"
                        bind:value={$formEntreprise.password}
                        class:input-error={errors.password || $formEntreprise.errors.password}
                    />
                    <span class="error-message">{errors.password || $formEntreprise.errors.password || ''}</span>
                </div>

                <div class="form-group form-group-full">
                    <label for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" placeholder="••••••••"
                        bind:value={$formEntreprise.password_confirmation}
                        class:input-error={errors.password_confirmation || $formEntreprise.errors.password_confirmation}
                    />
                    <span class="error-message">{errors.password_confirmation || $formEntreprise.errors.password_confirmation || ''}</span>
                </div>

                <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>
                <input type="submit" id="creer" value="Créer le compte" />
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

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
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
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-group input:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .form-group input::placeholder { color: #6c757d; }

    .input-error { border-color: #dc3545 !important; }

    .error-message {
        color: #dc3545;
        font-size: 13px;
        min-height: 1em;
    }

    .required { color: #dc3545; font-weight: bold; }

    .champ-obligatoire {
        grid-column: 1 / -1;
        font-size: 13px;
        color: #6c757d;
        margin-top: -0.25rem;
    }

    input[type="submit"]#creer {
        grid-column: 1 / -1;
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
    }

    input[type="submit"]#creer:hover {
        background: linear-gradient(135deg, var(--primary-700), #1d4ed8);
        transform: translateY(-1px);
        box-shadow: 0 18px 35px rgba(37, 99, 235, 0.28);
    }

    .role-btn:focus-visible,
    .form-group input:focus-visible,
    input[type="submit"]#creer:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
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

</style>