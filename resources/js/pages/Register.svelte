<script lang="ts">
    import Header from '@/components/Header.svelte';
    import { useForm } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import logo from './img/logo.png';

    const form = useForm({
        nom: '',
        prenom: '',
        date_de_naissance: '',
        nb_tel: '',
        adresse: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    let errors: Record<string, string> = $state({});

    function validate(): boolean {
        errors = {};
        if (!$form.nom) errors.nom = "Le nom est obligatoire";
        if (!$form.prenom) errors.prenom = "Le prénom est obligatoire";
        if (!$form.date_de_naissance) errors.date_de_naissance = "La date de naissance est obligatoire";
        if (!$form.nb_tel) errors.nb_tel = "Le numéro de téléphone est obligatoire";
        if (!$form.adresse) errors.adresse = "L'adresse est obligatoire";
        if (!$form.email) errors.email = "L'e-mail est obligatoire";
        if (!$form.password) errors.password = "Le mot de passe est obligatoire";
        if (!$form.password_confirmation) errors.password_confirmation = "Veuillez confirmer le mot de passe";
        if ($form.password && $form.password_confirmation && $form.password !== $form.password_confirmation) {
            errors.password_confirmation = "Les mots de passe ne correspondent pas";
            errors.password = " ";
        }
        return Object.keys(errors).length === 0;
    }

    function submit(e: Event) {
        e.preventDefault();
        if (!validate()) return;
        $form.post('/register', { preserveState: true });
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

        <form id="creation_compte" onsubmit={submit}>

            <div class="form-group">
                <label for="nom">Nom <span class="required">*</span></label>
                <input
                    type="text" id="nom" placeholder="Nom"
                    bind:value={$form.nom}
                    class:input-error={errors.nom || $form.errors.nom}
                />
                <span class="error-message">{errors.nom || $form.errors.nom || ''}</span>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom <span class="required">*</span></label>
                <input
                    type="text" id="prenom" placeholder="Prénom"
                    bind:value={$form.prenom}
                    class:input-error={errors.prenom || $form.errors.prenom}
                />
                <span class="error-message">{errors.prenom || $form.errors.prenom || ''}</span>
            </div>

            <div class="form-group">
                <label for="date_de_naissance">Date de naissance <span class="required">*</span></label>
                <input
                    type="date" id="date_de_naissance"
                    bind:value={$form.date_de_naissance}
                    class:input-error={errors.date_de_naissance || $form.errors.date_de_naissance}
                />
                <span class="error-message">{errors.date_de_naissance || $form.errors.date_de_naissance || ''}</span>
            </div>

            <div class="form-group">
                <label for="nb_tel">Téléphone <span class="required">*</span></label>
                <input
                    type="tel" id="nb_tel" placeholder="06 12 34 56 78"
                    bind:value={$form.nb_tel}
                    class:input-error={errors.nb_tel || $form.errors.nb_tel}
                />
                <span class="error-message">{errors.nb_tel || $form.errors.nb_tel || ''}</span>
            </div>

            <div class="form-group form-group-full">
                <label for="adresse">Adresse <span class="required">*</span></label>
                <input
                    type="text" id="adresse" placeholder="11 rue de la Paix 64000 Pau"
                    bind:value={$form.adresse}
                    class:input-error={errors.adresse || $form.errors.adresse}
                />
                <span class="error-message">{errors.adresse || $form.errors.adresse || ''}</span>
            </div>

            <div class="form-group form-group-full">
                <label for="email">E-mail <span class="required">*</span></label>
                <input
                    type="email" id="email" placeholder="jean.dupont@gmail.com"
                    bind:value={$form.email}
                    class:input-error={errors.email || $form.errors.email}
                />
                <span class="error-message">{errors.email || $form.errors.email || ''}</span>
            </div>

            <div class="form-group form-group-full">
                <label for="password">Mot de passe <span class="required">*</span></label>
                <input
                    type="password" id="password" placeholder="••••••••"
                    bind:value={$form.password}
                    class:input-error={errors.password || $form.errors.password}
                />
                <span class="error-message">{errors.password || $form.errors.password || ''}</span>
            </div>

            <div class="form-group form-group-full">
                <label for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                <input
                    type="password" id="password_confirmation" placeholder="••••••••"
                    bind:value={$form.password_confirmation}
                    class:input-error={errors.password_confirmation || $form.errors.password_confirmation}
                />
                <span class="error-message">{errors.password_confirmation || $form.errors.password_confirmation || ''}</span>
            </div>

            <p class="champ-obligatoire"><span class="required">*</span> Champ obligatoire</p>

            <input type="submit" id="creer" value="Créer le compte" />
        </form>

        <div class="footer-links">
            <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
        </div>
    </div>
</main>

<style>
    * {
        font-family: "Plus Jakarta Sans", sans-serif;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    
    main {
        min-height: calc(100vh - 64px);
        background: #f8fafc;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .box {
        background: #ffffff;
        border-radius: 16px;
        padding: 2.5rem;
        width: 700px;
        max-width: 100%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2rem;
        text-align: center;
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

    .form-group.form-group-full {
        grid-column: 1 / -1;
    }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 15px;
        font-family: inherit;
        background-color: #fff;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-group input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .form-group input::placeholder {
        color: #6c757d;
    }

    .input-error {
        border-color: #dc3545 !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 13px;
        min-height: 1em;
    }

    .required {
        color: #dc3545;
        font-weight: bold;
    }

    .champ-obligatoire {
        grid-column: 1 / -1;
        font-size: 13px;
        color: #6c757d;
    }

    input[type="submit"]#creer {
        grid-column: 1 / -1;
        width: 100%;
        padding: 0.75rem;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s;
    }

    input[type="submit"]#creer:hover {
        background: #1d4ed8;
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

    .footer-links a:hover {
        text-decoration: underline;
    }
</style>