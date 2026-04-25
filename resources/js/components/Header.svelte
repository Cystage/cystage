<script lang="ts">
    import { inertia, page } from '@inertiajs/svelte';
    import { useForm } from '@inertiajs/svelte';

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
            {#if user.role_id==2}
                <a use:inertia class="btn-ghost" href="/postulation">Consulter les postulations</a>
            {/if}
            {#if user.role_id==3 || user.role_id==2}
                <a use:inertia class="btn-ghost" href="/profil">Mon profil</a>
            {/if}
            {#if user.role_id==2 || user.role_id==1}
                <button class="btn-secondary" onclick={() => showModal = !showModal}>Publier une offre</button>
            {/if}
            {#if user.role_id==1}
                <a use:inertia class="btn-ghost" href="/register">Créer un compte étudiant</a>
                <a use:inertia class="btn-ghost" href="/newent">Créer un compte entreprise</a>
            {/if}
            <button class="btn-primary" onclick={logout}>Déconnexion</button>
        {:else}
            <button class="btn-primary" onclick={() => showLogin = !showLogin}>Connexion</button>
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
        padding: 0 2rem;
        height: 64px;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .header-left, .header-center, .header-right {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .header-center { justify-content: center; }
    .header-right  { justify-content: flex-end; gap: 0.75rem; }

    .header-logo-text {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e40af;
        text-decoration: none;
        letter-spacing: -0.5px;
    }

    button, .btn-ghost {
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: background 0.15s;
        font-family: inherit;
    }

    .btn-primary { background: #2563eb; color: #fff; }
    .btn-primary:hover { background: #1d4ed8; }

    .btn-secondary { background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; }
    .btn-secondary:hover { background: #e2e8f0; }

    .btn-ghost { background: transparent; color: #2563eb; display: inline-flex; align-items: center; }
    .btn-ghost:hover { background: #eff6ff; }
</style>