<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import { useForm, page } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';

    let success = $derived(($page.props as any).flash?.success);

    const form = useForm({ code: '' });
    const resendForm = useForm({});

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/two-factor/verify');
    }

    function resend(e: Event) {
        e.preventDefault();
        $resendForm.post('/two-factor/resend', { preserveState: true });
    }
</script>

<AppHead title="Vérification" />

<main class="page">
    <div class="card">
        <div class="icon">🔐</div>
        <h1>Double authentification</h1>
        <p class="subtitle">Un code à 6 chiffres a été envoyé à votre adresse email. Saisissez-le ci-dessous.</p>

        {#if success}
            <div class="alert-success">{success}</div>
        {/if}

        <form onsubmit={submit}>
            <div class="field">
                <label for="code">Code de vérification</label>
                <input
                    id="code"
                    type="text"
                    inputmode="numeric"
                    maxlength="6"
                    placeholder="000000"
                    bind:value={$form.code}
                    autocomplete="one-time-code"
                />
                {#if $form.errors.code}
                    <span class="erreur">{$form.errors.code}</span>
                {/if}
            </div>

            <Button type="submit" variant="btnBleu" disabled={$form.processing}>
                {$form.processing ? 'Vérification...' : 'Valider le code'}
            </Button>
        </form>

        <form onsubmit={resend} class="resend-form">
            <button type="submit" class="resend-btn" disabled={$resendForm.processing}>
                Renvoyer un nouveau code
            </button>
        </form>

        <a class="back-link" href="/login">← Retour à la connexion</a>
    </div>
</main>

<style>
    .page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: var(--surface-subtle);
    }

    .card {
        width: 100%;
        max-width: 420px;
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.1);
        text-align: center;
    }

    .icon { font-size: 2.5rem; margin-bottom: 1rem; }

    h1 {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--ink-900);
        margin: 0 0 0.5rem;
    }

    .subtitle {
        font-size: 0.875rem;
        color: var(--ink-600);
        margin: 0 0 1.5rem;
        line-height: 1.5;
    }

    .alert-success {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    form { display: flex; flex-direction: column; gap: 1rem; }

    .field { display: flex; flex-direction: column; gap: 0.4rem; text-align: left; }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink-600);
    }

    input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-200);
        border-radius: 10px;
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.3em;
        text-align: center;
        background: var(--surface-subtle);
        color: var(--ink-900);
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    input:focus {
        outline: none;
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .erreur { color: #ef4444; font-size: 0.8rem; }

    .resend-form { margin-top: 0.25rem; }

    .resend-btn {
        background: none;
        border: none;
        color: var(--primary-600);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
        text-decoration: underline;
    }

    .resend-btn:disabled { opacity: 0.5; cursor: not-allowed; }

    .back-link {
        display: inline-block;
        margin-top: 1.25rem;
        font-size: 0.875rem;
        color: var(--ink-600);
        text-decoration: none;
    }

    .back-link:hover { color: var(--ink-900); }
</style>
