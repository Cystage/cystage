<script lang="ts">
    import { inertia, page } from '@inertiajs/svelte';
    import { useForm } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';


    let { showModal = $bindable(false), showLogin = $bindable(false) } = $props();
    
    const logoutForm = useForm({});
    function logout() {
        $logoutForm.post('/logout');
    }

    let user = $derived($page.props.auth?.user);
</script>

<header>
    <div class="header-left"></div>
    <div class="header-center">
        <a use:inertia href="/" class="header-logo-text">CyStage</a>
    </div>
    <div class="header-right">
        {#if user}
        
            {#if user}
                <Button variant="btn-ghost" href="/profil">Mon profil</Button>
            {/if}
            {#if user.role_id==2 || user.role_id==1}
                <Button variant="btnBlanc" onclick={() => showModal = !showModal}>Publier une offre</Button>
            {/if}
            {#if user.role_id==1}
                <Button variant="btn-ghost" href="/admin">Administration</Button>
            {/if}
                <Button variant="btnBleu"onclick={logout}>Déconnexion</Button>
        {:else}
                <Button variant="btnBleu" href={"/login"}>Connexion</Button>
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
        background: rgba(255, 255, 255, 0.94);
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
        backdrop-filter: blur(8px);
        gap: 0.75rem;
    }

    .header-left, .header-center, .header-right {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .header-center { justify-content: center; }
    .header-right  { justify-content: flex-end; gap: 0.55rem; flex-wrap: wrap; }

    .header-logo-text {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1d4ed8;
        text-decoration: none;
        letter-spacing: -0.03em;
    }

    button, .btn-primary, .btn-secondary, .btn-ghost {
        padding: 0.45rem 0.9rem;
        border-radius: 10px;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-primary { background: #2563eb; color: #fff; }
    .btn-primary:hover { background: #1d4ed8; transform: translateY(-1px); }

    .btn-secondary { background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; }
    .btn-secondary:hover { background: #e2e8f0; }

    .btn-ghost { background: transparent; color: #2563eb; display: inline-flex; align-items: center; }
    .btn-ghost:hover { background: #eff6ff; }

    .btn-primary:focus-visible,
    .btn-secondary:focus-visible,
    .btn-ghost:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    @media (max-width: 900px) {
        header {
            padding: 0.65rem 1rem;
        }

        .header-center {
            justify-content: flex-start;
        }

        .header-left {
            display: none;
        }
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