<script lang="ts">
    import { useForm } from '@inertiajs/svelte';

    let { showLogin = $bindable() } = $props();
    function disable_login() {
        showLogin = !showLogin;
    }

    const form = useForm({ email: '', password: '' });

    function submit(e) {
        e.preventDefault();
        $form.post('/login', {
            preserveState: true,
            onSuccess: () => { $form.reset(); showLogin = false; }
        });
    }
</script>

<div class="overlay">
    <div class="box">
        <button class="close" onclick={disable_login}>✕</button>

        <h1 class="titre">
            <img class="img-profil" src="https://static.vecteezy.com/system/resources/thumbnails/019/879/186/small_2x/user-icon-on-transparent-background-free-png.png" alt="Logo profil">
            <span>Connectez-vous</span>
        </h1>

        {#if $form.errors.email}
            <span class="erreur">{$form.errors.email}</span>
        {/if}
        {#if $form.errors.password}
            <span class="erreur">{$form.errors.password}</span>
        {/if}

        <form onsubmit={submit}>
            <div class="field">
                <label for="email">E-mail</label>
                <input bind:value={$form.email} type="email" id="email" placeholder="jean.dupont@gmail.com"/>
            </div>

            <div class="field">
                <label for="password">Mot de passe</label>
                <input bind:value={$form.password} type="password" id="password" placeholder="••••••••"/>
            </div>

            <input type="submit" class="button" value="Connexion"/>
        </form>

        <div class="footer-links">
            <p>Vous n'avez pas de compte ? <a class="btn-secondary" href="/register">Créer un compte</a></p>
            <p>Mot de passe oublié ? <a class="btn-secondary" href="/reset-password">Réinitialiser le mot de passe</a></p>
        </div>
    </div>
</div>

<style>
    .overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .box {
        position: relative;
        background: #ffffff;
        border-radius: 12px;
        padding: 2.5rem 2rem 2rem;
        width: 380px;
        max-width: 90vw;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .close {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: none;
        border: none;
        font-size: 1rem;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        transition: background 0.15s;
    }

    .close:hover {
        background: #f1f5f9;
        color: #1e293b;
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

    .img-profil {
        width: 40px;
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

    input[type="submit"]:hover {
        background: #1d4ed8;
    }

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

    .footer-links a:hover {
        text-decoration: underline;
    }
</style>