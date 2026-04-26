<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';

    let { token }: { token: string } = $props();

    const form = useForm({
        token: token,
        email: '',
        password: '',
        password_confirmation: '',
    });

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/reset-password');
    }
</script>

<AppHead title="Réinitialiser le mot de passe" />
<Header />

<main>
    <div class="box">
        <h1>Nouveau mot de passe</h1>
        <p class="subtitle">Choisissez un nouveau mot de passe pour votre compte.</p>

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

            <div class="form-group form-group-full">
                <label for="password">Nouveau mot de passe <span class="required">*</span></label>
                <input
                    type="password" id="password" placeholder="••••••••"
                    bind:value={$form.password}
                    class:input-error={$form.errors.password}
                />
                <span class="error-message">{$form.errors.password || ''}</span>
            </div>

            <div class="form-group form-group-full">
                <label for="password_confirmation">Confirmer le mot de passe <span class="required">*</span></label>
                <input
                    type="password" id="password_confirmation" placeholder="••••••••"
                    bind:value={$form.password_confirmation}
                    class:input-error={$form.errors.password_confirmation}
                />
                <span class="error-message">{$form.errors.password_confirmation || ''}</span>
            </div>
            <input type="submit" id="creer" value="Réinitialiser le mot de passe" />
        </form>
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

    form { display: grid; gap: 18px; }

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

    @media (max-width: 640px) {
        .box {
            width: 100%;
            padding: 1.8rem 1.2rem;
            border-radius: 16px;
        }
    }
</style>