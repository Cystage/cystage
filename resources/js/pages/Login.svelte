<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';

    const form = useForm({ email: '', password: '' });

    let success = $derived($page.props.flash?.success);

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/login');
    }
</script>

<AppHead title="Connexion" />
<Header />

<main>
    <div class="box">
        <div class="titre">
            <img class="img-profil" src="https://static.vecteezy.com/system/resources/thumbnails/019/879/186/small_2x/user-icon-on-transparent-background-free-png.png" alt="Logo photo profil">
            <span>Connectez-vous</span>
        </div>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        {#if $form.errors.email}
            <span class="erreur">{$form.errors.email}</span>
        {/if}

        <form onsubmit={submit}>
            <div class="field">
                <label for="email">E-mail</label>
                <input
                    bind:value={$form.email}
                    type="email" id="email"
                    placeholder="jean.dupont@gmail.com"
                    class:input-error={$form.errors.email}
                />
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input
                    bind:value={$form.password}
                    type="password" id="password"
                    placeholder="••••••••"
                    class:input-error={$form.errors.password}
                />
            </div>

            <input type="submit" class="button" value="Connexion" />
        </form>

        <div class="footer-links">
            <p>Mot de passe oublié ? <a href="/forgot-password">Réinitialiser</a></p>
            <p>Pas de compte ? <a href="/register">Créer un compte</a></p>
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
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .box {
        background: #ffffff;
        border-radius: 12px;
        padding: 2.5rem 2rem;
        width: 380px;
        max-width: 90vw;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .titre {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
    }

    .img-profil { width: 40px; }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .erreur {
        color: #d32f2f;
        margin-bottom: 10px;
        display: block;
        font-size: 0.875rem;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .field {
        position: relative;
        margin-top: 0.5rem;
    }

    label {
        position: absolute;
        background: linear-gradient(to bottom, #f9f9f9, #ffffff);
        margin-left: 10px;
        margin-top: -7px;
        padding-left: 10px;
        padding-right: 10px;
        font-size: 14px;
        color: #374151;
        font-weight: 600;
        z-index: 1;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9rem;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        background: #ffffff;
        transition: border-color 0.15s;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .input-error { border-color: #dc3545 !important; }

    input[type="submit"] {
        width: 100%;
        padding: 0.7rem;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s;
        margin-top: 0.25rem;
    }

    input[type="submit"]:hover { background: #1d4ed8; }

    .footer-links {
        margin-top: 1.25rem;
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .footer-links a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .footer-links a:hover { text-decoration: underline; }
</style>