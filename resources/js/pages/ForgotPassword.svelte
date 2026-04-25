<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';

    const form = useForm({ email: '' });

    let success = $derived($page.props.flash?.success);

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/forgot-password');
    }
</script>

<AppHead title="Mot de passe oublié" />
<Header />

<main>
    <div class="box">
        <h1>Mot de passe oublié</h1>
        <p class="subtitle">Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        <form onsubmit={submit}>
            <div class="form-group form-group-full">
                <label for="email">Email <span class="required">*</span></label>
                <input
                    type="email" id="email" placeholder="jean.dupont@gmail.com"
                    bind:value={$form.email}
                    class:input-error={$form.errors.email}
                />
                <span class="error-message">{$form.errors.email || ''}</span>
            </div>

            <input type="submit" id="creer" value="Envoyer le lien" />
        </form>

        <div class="footer-links">
            <p>Retour à la <a href="/login">connexion</a></p>
        </div>
    </div>
</main>

<style>


    .box {
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--border-200);
        padding: 2.5rem;
        width: 440px;
        max-width: 100%;
        box-shadow: 0 20px 42px rgba(15, 23, 42, 0.08);
    }

    h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--ink-900);
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .subtitle {
        font-size: 0.94rem;
        color: var(--ink-600);
        text-align: center;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .alert-success {
        background: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    form {
        display: grid;
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.form-group-full { grid-column: 1 / -1; }

    label { font-size: 0.875rem; font-weight: 600; color: #374151; }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ced4da;
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        outline: none;
        transition: border-color 0.15s;
    }

    .form-group input:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .input-error { border-color: #dc3545 !important; }
    .error-message { color: #dc3545; font-size: 13px; min-height: 1em; }
    .required { color: #dc3545; font-weight: bold; }

    input[type="submit"]#creer {
        width: 100%;
        padding: 0.82rem;
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
        transform: translateY(-1px);
        box-shadow: 0 18px 35px rgba(37, 99, 235, 0.28);
    }

    .footer-links {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
    }

    .footer-links a { color: #2563eb; font-weight: 600; text-decoration: none; }
    .footer-links a:hover { text-decoration: underline; }

    @media (max-width: 640px) {
        .box {
            width: 100%;
            padding: 1.8rem 1.2rem;
            border-radius: 16px;
        }
    }
</style>