<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';

    let { showLogin = $bindable() } = $props();

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
            <span class="icon">🔐</span>
            <span>Connectez-vous</span>
        </div>
        <p class="subtitle">Accédez à votre espace CY Stage pour suivre vos offres et candidatures.</p>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        {#if $form.errors.email || $form.errors.password}
            <span class="erreur">{$form.errors.email || $form.errors.password}</span>
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


    .box {
        background: #fff;
        border: 1px solid var(--border-200);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        width: 430px;
        max-width: 90vw;
        box-shadow: 0 20px 42px rgba(15, 23, 42, 0.08);
    }

    .titre {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--ink-900);
        margin-bottom: 0.6rem;
    }

    .icon {
        width: 2rem;
        height: 2rem;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-50);
    }

    .subtitle {
        color: var(--ink-600);
        text-align: center;
        margin-bottom: 1.4rem;
        font-size: 0.94rem;
    }

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
        margin-bottom: 0.75rem;
        display: block;
        font-size: 0.875rem;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .field {
        position: relative;
        margin-top: 0.35rem;
    }

    label {
        position: absolute;
        background: #fff;
        margin-left: 0.75rem;
        margin-top: -0.55rem;
        padding: 0 0.35rem;
        font-size: 0.83rem;
        color: #374151;
        font-weight: 600;
        z-index: 1;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.9rem;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        background: #ffffff;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .input-error { border-color: #dc3545 !important; }

    input[type="submit"] {
        width: 100%;
        padding: 0.78rem;
        background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: 0.25rem;
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
    }

    input[type="submit"]:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 18px 35px rgba(37, 99, 235, 0.28);
    }

    input[type="submit"]:focus-visible,
    input[type="email"]:focus-visible,
    input[type="password"]:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
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

    .footer-links a:hover { text-decoration: underline; }

    @media (max-width: 640px) {
        .box {
            width: 100%;
            max-width: 100%;
            padding: 1.8rem 1.2rem;
            border-radius: 16px;
        }
    }
</style>