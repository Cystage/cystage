<script lang="ts">
	import FormInput from '@/components/FormInput.svelte';
    import Button from '@/components/Button.svelte'

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
            <FormInput id="email" isFull label="Email" placeholder="Email " required bind:value={$form.email} error={$form.errors.email}></FormInput>
            <Button type="submit" variant="btnBleu">Envoyer le lien</Button>
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