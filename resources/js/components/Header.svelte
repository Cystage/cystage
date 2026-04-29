<script lang="ts">
    import { inertia, page } from '@inertiajs/svelte';
    import { useForm } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import Button from '@/components/Button.svelte';

    let { showModal = $bindable(false), showLogin = $bindable(false) } = $props();

    const logoutForm = useForm({});
    function logout() {
        $logoutForm.post('/logout');
    }

    let user = $derived($page.props.auth?.user);
    let dark = $state(false);

    onMount(() => {
        dark = localStorage.getItem('theme') === 'dark';
        document.documentElement.classList.toggle('dark', dark);
    });

    function toggleDark() {
        document.documentElement.classList.add('theme-transitioning');
        dark = !dark;
        document.documentElement.classList.toggle('dark', dark);
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        setTimeout(() => document.documentElement.classList.remove('theme-transitioning'), 300);
    }
</script>

<header>
    <div class="header-left">
        <button class="theme-btn" onclick={toggleDark} title={dark ? 'Passer en mode clair' : 'Passer en mode sombre'}>
            {dark ? '☀️' : '🌙'}
        </button>
    </div>

    <div class="header-center">
        <a use:inertia href="/" class="header-logo-text">CyStage</a>
    </div>

    <div class="header-right">
        {#if user}
            <Button variant="btn-ghost" href="/profil">Mon espace</Button>
            {#if user.role_id == 2 || user.role_id == 1}
                <Button variant="btnBlanc" onclick={() => showModal = !showModal}>Publier une offre</Button>
            {/if}
            {#if user.role_id == 1}
                <Button variant="btn-ghost" href="/admin">Administration</Button>
            {/if}
            <Button variant="btnBleu" onclick={logout}>Déconnexion</Button>
        {:else}
            <Button variant="btnBleu" href="/login">Connexion</Button>
        {/if}
    </div>
</header>

<style>
    header {
        position: sticky;
        top: 0;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1.5rem;
        min-height: 64px;
        background: var(--header-bg);
        border-bottom: 1px solid var(--border-200);
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
        backdrop-filter: blur(8px);
        gap: 0.75rem;
    }

    .header-left,
    .header-center,
    .header-right {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .header-center { justify-content: center; }
    .header-right  { justify-content: flex-end; gap: 0.55rem; flex-wrap: wrap; }

    .header-logo-text {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--primary-700);
        text-decoration: none;
        letter-spacing: -0.03em;
    }

    /* ─── Dark mode toggle ─── */
    .theme-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        color: var(--ink-900);
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.15s ease;
        flex-shrink: 0;
    }

    .theme-btn:hover {
        background: var(--surface-muted);
        transform: scale(1.08);
    }

    .theme-btn:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    @media (max-width: 900px) {
        header { padding: 0.65rem 1rem; }
        .header-center { justify-content: flex-start; }
    }

    @media (max-width: 700px) {
        header {
            align-items: flex-start;
            flex-direction: column;
        }
        .header-center,
        .header-right {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>
