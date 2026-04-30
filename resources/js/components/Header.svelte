<script lang="ts">
    import { inertia, page, router } from '@inertiajs/svelte';
    import { useForm } from '@inertiajs/svelte';
    import { onMount } from 'svelte';

    let { showModal = $bindable(false), showLogin = $bindable(false) } = $props();

    function openPublierOffre() {
        const url = ($page.url as string).split('?')[0];
        if (url === '/') {
            showModal = true;
        } else {
            router.visit('/?newOffre=1');
        }
    }

    const logoutForm = useForm({});
    function logout() {
        $logoutForm.post('/logout');
    }

    let user        = $derived(($page.props as any).auth?.user);
    let notifs      = $derived((($page.props as any).notifications ?? []) as any[]);
    let unreadCount = $derived(($page.props as any).notifs_unread ?? 0);

    let dark = $state(false);
    let showNotifs = $state(false);

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

    function toggleNotifs() { showNotifs = !showNotifs; }
    function closeNotifs()  { showNotifs = false; }

    function markRead(id: number, link: string | null, alreadyRead: boolean) {
        showNotifs = false;
        if (alreadyRead) {
            if (link) router.visit(link);
            return;
        }
        router.post(`/notifs/${id}/lire`, {}, {
            preserveScroll: true,
            onSuccess: () => { if (link) router.visit(link); }
        });
    }

    function deleteNotif(e: MouseEvent, id: number) {
        e.stopPropagation();
        router.delete(`/notifs/${id}`, { preserveScroll: true });
    }

    function deleteRead() {
        router.delete('/notifs/lues', { preserveScroll: true });
    }

    function deleteAll() {
        if (confirm('Supprimer toutes les notifications ?')) {
            router.delete('/notifs', { preserveScroll: true });
        }
    }

    function markAllRead() {
        router.post('/notifs/tout-lire', {}, { preserveScroll: true });
    }

    function onKeydown(e: KeyboardEvent) {
        if (e.key === 'Escape') showNotifs = false;
    }

    function timeAgo(dateStr: string) {
        const diff = Date.now() - new Date(dateStr).getTime();
        const mins = Math.floor(diff / 60000);
        if (mins < 1) return "à l'instant";
        if (mins < 60) return `il y a ${mins} min`;
        const hrs = Math.floor(mins / 60);
        if (hrs < 24) return `il y a ${hrs}h`;
        return `il y a ${Math.floor(hrs / 24)}j`;
    }

    const notifIcon: Record<string, string> = {
        nouvelle_candidature: '📩',
        candidature_acceptee: '✅',
        stage_confirme: '🎉',
    };

    let readCount = $derived(notifs.filter((n: any) => !!n.read_at).length);
</script>

<svelte:window onkeydown={onKeydown} />

<header>
    <!-- Gauche : toggle thème -->
    <div class="header-left">
        <button class="icon-btn theme-btn" onclick={toggleDark} title={dark ? 'Mode clair' : 'Mode sombre'} aria-label="Basculer le thème">
            {#if dark}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            {:else}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            {/if}
        </button>
    </div>

    <!-- Centre : logo -->
    <div class="header-center">
        <a use:inertia href="/" class="header-logo">CyStage</a>
    </div>

    <!-- Droite : nav -->
    <nav class="header-nav" aria-label="Navigation principale">
        {#if user}
            <!-- Liens de navigation -->
            <div class="nav-links">
                <a use:inertia href="/profil" class="nav-link">Mon espace</a>
                {#if user.role_id == 1}
                    <a use:inertia href="/admin" class="nav-link">Admin</a>
                {/if}
            </div>

            <!-- CTA publier -->
            {#if user.role_id == 2 || user.role_id == 1}
                <button class="btn-publish" onclick={openPublierOffre}>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Publier une offre
                </button>
            {/if}

            <span class="nav-sep" aria-hidden="true"></span>

            <!-- Cloche notifications -->
            <div class="notif-wrapper">
                <button class="icon-btn notif-btn" onclick={toggleNotifs} title="Notifications" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    {#if unreadCount > 0}
                        <span class="notif-badge">{unreadCount > 9 ? '9+' : unreadCount}</span>
                    {/if}
                </button>

                {#if showNotifs}
                    <div class="notif-overlay" onclick={closeNotifs} role="presentation"></div>
                    <div class="notif-panel">
                        <div class="notif-panel-header">
                            <span class="notif-panel-title">Notifications</span>
                            <div class="notif-panel-actions">
                                {#if unreadCount > 0}
                                    <button class="notif-action-btn" onclick={markAllRead}>Tout lire</button>
                                {/if}
                                {#if readCount > 0}
                                    <button class="notif-action-btn notif-action-del" onclick={deleteRead}>Suppr. les lues</button>
                                {/if}
                            </div>
                        </div>

                        {#if notifs.length === 0}
                            <div class="notif-empty">
                                <span>🔔</span>
                                <p>Aucune notification</p>
                            </div>
                        {:else}
                            <div class="notif-list">
                                {#each notifs as n}
                                    <div
                                        class="notif-item"
                                        class:unread={!n.read_at}
                                        role="button"
                                        tabindex="0"
                                        onclick={() => markRead(n.id, n.link, !!n.read_at)}
                                        onkeydown={(e) => e.key === 'Enter' && markRead(n.id, n.link, !!n.read_at)}
                                    >
                                        <span class="notif-item-icon">{notifIcon[n.type] ?? '🔔'}</span>
                                        <div class="notif-item-body">
                                            <p class="notif-item-msg">{n.message}</p>
                                            <p class="notif-item-time">{timeAgo(n.created_at)}</p>
                                        </div>
                                        {#if !n.read_at}
                                            <span class="notif-dot"></span>
                                        {/if}
                                        <button class="notif-delete" onclick={(e) => deleteNotif(e, n.id)} title="Supprimer">×</button>
                                    </div>
                                {/each}
                            </div>
                            <div class="notif-panel-footer">
                                <button class="notif-delete-all" onclick={deleteAll}>Tout supprimer</button>
                            </div>
                        {/if}
                    </div>
                {/if}
            </div>

            <!-- Déconnexion -->
            <button class="btn-logout" onclick={logout}>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span class="btn-logout-label">Déconnexion</span>
            </button>
        {:else}
            <a use:inertia href="/login" class="btn-signin">Connexion</a>
        {/if}
    </nav>
</header>

<style>
    /* ─── Structure ─────────────────────────────────────────── */
    header {
        position: sticky;
        top: 0;
        z-index: 100;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        padding: 0 1.25rem;
        height: 52px;
        background: var(--header-bg);
        border-bottom: 1px solid var(--border-200);
        backdrop-filter: saturate(180%) blur(20px);
        -webkit-backdrop-filter: saturate(180%) blur(20px);
    }

    .header-left  { display: flex; align-items: center; }
    .header-center { display: flex; align-items: center; justify-content: center; }
    .header-nav   { display: flex; align-items: center; gap: 0.35rem; justify-content: flex-end; }

    /* ─── Logo ────────────────────────────────────────────── */
    .header-logo {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ink-900);
        text-decoration: none;
        letter-spacing: -0.025em;
    }

    /* ─── Icon buttons (theme + notif) ─────────────────────── */
    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        background: transparent;
        color: var(--ink-600);
        cursor: pointer;
        font-family: inherit;
        transition: background 0.12s, color 0.12s;
        flex-shrink: 0;
    }

    .icon-btn:hover { background: var(--surface-muted); color: var(--ink-900); }
    .icon-btn:focus-visible { outline: 2px solid var(--primary-600); outline-offset: 2px; }

    /* ─── Nav links (Mon espace / Admin) ────────────────────── */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .nav-link {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        background: var(--surface-muted);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--ink-700);
        text-decoration: none;
        transition: background 0.12s, color 0.12s, border-color 0.12s;
        white-space: nowrap;
    }

    .nav-link:hover { background: var(--surface-subtle); border-color: var(--primary-600); color: var(--primary-600); }

    /* ─── CTA Publier ────────────────────────────────────────── */
    .btn-publish {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        background: var(--surface-muted);
        color: var(--ink-700);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
        transition: background 0.12s, border-color 0.12s;
        flex-shrink: 0;
    }

    .btn-publish:hover {
        background: var(--surface-subtle);
        border-color: var(--primary-600);
        color: var(--primary-600);
    }

    /* ─── Séparateur vertical ───────────────────────────────── */
    .nav-sep {
        display: inline-block;
        width: 1px;
        height: 18px;
        background: var(--border-200);
        margin: 0 0.2rem;
        flex-shrink: 0;
    }

    /* ─── Notif bell ─────────────────────────────────────────── */
    .notif-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .notif-btn { position: relative; }

    .notif-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 16px;
        height: 16px;
        padding: 0 3px;
        border-radius: 999px;
        background: #ef4444;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        box-sizing: border-box;
    }

    /* ─── Déconnexion ────────────────────────────────────────── */
    .btn-logout {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        background: var(--surface-muted);
        color: var(--ink-600);
        font-size: 0.825rem;
        font-weight: 500;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.12s, color 0.12s, border-color 0.12s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-logout:hover { background: #fff1f2; border-color: #fca5a5; color: #e11d48; }

    /* ─── Connexion (non connecté) ──────────────────────────── */
    .btn-signin {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 1rem;
        border-radius: 980px;
        background: var(--primary-600);
        color: #fff;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.15s;
        white-space: nowrap;
    }

    .btn-signin:hover { opacity: 0.88; }

    /* ─── Notif overlay ───────────────────────────────────────── */
    .notif-overlay {
        position: fixed;
        inset: 0;
        z-index: 150;
    }

    /* ─── Notif panel ─────────────────────────────────────────── */
    .notif-panel {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 340px;
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 14px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        z-index: 200;
        overflow: hidden;
    }

    .notif-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.9rem 1rem 0.7rem;
        border-bottom: 1px solid var(--border-200);
    }

    .notif-panel-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--ink-900);
    }

    .notif-panel-actions {
        display: flex;
        gap: 0.6rem;
        align-items: center;
    }

    .notif-action-btn {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--primary-600);
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
        white-space: nowrap;
    }

    .notif-action-btn:hover { text-decoration: underline; }
    .notif-action-del { color: #dc2626; }

    .notif-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        padding: 2rem 1rem;
        color: var(--ink-600);
        font-size: 0.875rem;
    }

    .notif-empty span { font-size: 1.75rem; }

    .notif-list { max-height: 360px; overflow-y: auto; }

    .notif-item {
        width: 100%;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.8rem 1rem;
        border: none;
        border-bottom: 1px solid var(--border-200);
        background: var(--surface-card);
        cursor: pointer;
        font-family: inherit;
        text-align: left;
        transition: background 0.12s;
    }

    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: var(--surface-subtle); }
    .notif-item.unread { background: #f0f7ff; }
    .notif-item.unread:hover { background: #e0efff; }

    .notif-item-icon { font-size: 1.1rem; flex-shrink: 0; margin-top: 1px; }
    .notif-item-body { flex: 1; min-width: 0; }

    .notif-item-msg {
        margin: 0 0 2px;
        font-size: 0.84rem;
        color: var(--ink-900);
        line-height: 1.4;
    }

    .notif-item-time {
        margin: 0;
        font-size: 0.73rem;
        color: var(--ink-500);
    }

    .notif-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--primary-600);
        flex-shrink: 0;
        margin-top: 6px;
    }

    .notif-delete {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--ink-400);
        font-size: 1rem;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.12s, background 0.12s, color 0.12s;
        margin-left: 2px;
    }

    .notif-item:hover .notif-delete { opacity: 1; }
    .notif-delete:hover { background: #fee2e2; color: #dc2626; }

    .notif-panel-footer {
        padding: 0.55rem 1rem;
        border-top: 1px solid var(--border-200);
        text-align: center;
    }

    .notif-delete-all {
        font-size: 0.78rem;
        font-weight: 600;
        color: #dc2626;
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
        padding: 0;
    }

    .notif-delete-all:hover { text-decoration: underline; }

    /* ─── Responsive ──────────────────────────────────────────── */
    @media (max-width: 900px) {
        header { padding: 0 1rem; }
        .btn-logout-label { display: none; }
        .notif-panel { width: 300px; }
    }

    @media (max-width: 640px) {
        header {
            grid-template-columns: auto 1fr;
            grid-template-rows: auto auto;
            height: auto;
            padding: 0.5rem 1rem;
            gap: 0.4rem;
        }

        .header-left  { grid-column: 1; grid-row: 1; }
        .header-center { grid-column: 2; grid-row: 1; justify-content: flex-start; padding-left: 0.5rem; }
        .header-nav   { grid-column: 1 / -1; grid-row: 2; justify-content: flex-start; flex-wrap: wrap; gap: 0.3rem; }

        .nav-sep { display: none; }
        .notif-panel { right: auto; left: 0; width: 290px; }
    }
</style>
