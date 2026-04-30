<script lang="ts">
    import { inertia, page, router } from '@inertiajs/svelte';
    import { useForm } from '@inertiajs/svelte';
    import { onMount } from 'svelte';
    import Button from '@/components/Button.svelte';

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

    function toggleNotifs() {
        showNotifs = !showNotifs;
    }

    function closeNotifs() {
        showNotifs = false;
    }

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
    <div class="header-left">
        <button class="theme-btn" onclick={toggleDark} title={dark ? 'Passer en mode clair' : 'Passer en mode sombre'}>
            {dark ? '☀️' : '🌙'}
        </button>
    </div>

    <div class="header-center">
        <a use:inertia href="/" class="header-logo-text">CyStage</a>
    </div>

    <nav class="header-right" aria-label="Navigation principale">
        {#if user}
            <!-- Bell -->
            <div class="notif-wrapper">
                <button class="notif-btn" onclick={toggleNotifs} title="Notifications" aria-label="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            <Button variant="btn-ghost" href="/profil">Mon espace</Button>
            {#if user.role_id == 2 || user.role_id == 1}
                <Button variant="btnBlanc" onclick={openPublierOffre}>Publier une offre</Button>
            {/if}
            {#if user.role_id == 1}
                <Button variant="btn-ghost" href="/admin">Administration</Button>
            {/if}
            <Button variant="btnBleu" onclick={logout}>Déconnexion</Button>
        {:else}
            <Button variant="btnBleu" href="/login">Connexion</Button>
        {/if}
    </nav>
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
    .header-right  { justify-content: flex-end; gap: 0.55rem; flex-wrap: wrap; list-style: none; margin: 0; padding: 0; }

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

    .theme-btn:hover { background: var(--surface-muted); transform: scale(1.08); }
    .theme-btn:focus-visible { outline: 3px solid rgba(37, 99, 235, 0.35); outline-offset: 2px; }

    /* ─── Notif bell ─── */
    .notif-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .notif-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        color: var(--ink-700);
        cursor: pointer;
        transition: background 0.15s, transform 0.15s;
    }

    .notif-btn:hover { background: var(--surface-muted); transform: scale(1.05); }
    .notif-btn:focus-visible { outline: 3px solid rgba(37, 99, 235, 0.35); outline-offset: 2px; }

    .notif-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        border-radius: 999px;
        background: #ef4444;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        box-sizing: border-box;
    }

    /* ─── Notif overlay ─── */
    .notif-overlay {
        position: fixed;
        inset: 0;
        z-index: 150;
    }

    /* ─── Notif panel ─── */
    .notif-panel {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 340px;
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 14px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.14);
        z-index: 200;
        overflow: hidden;
    }

    .notif-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.1rem 0.75rem;
        border-bottom: 1px solid var(--border-200);
    }

    .notif-panel-title {
        font-size: 0.95rem;
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

    .notif-delete {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--ink-400, #9ca3af);
        font-size: 1rem;
        line-height: 1;
        cursor: pointer;
        font-family: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.15s, background 0.15s, color 0.15s;
        margin-left: 2px;
    }

    .notif-item:hover .notif-delete { opacity: 1; }
    .notif-delete:hover { background: #fee2e2; color: #dc2626; }

    .notif-panel-footer {
        padding: 0.6rem 1.1rem;
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

    .notif-list {
        max-height: 380px;
        overflow-y: auto;
    }

    .notif-item {
        width: 100%;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 1.1rem;
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
    .notif-item.unread { background: #eff6ff; }
    .notif-item.unread:hover { background: #dbeafe; }

    .notif-item-icon {
        font-size: 1.2rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .notif-item-body { flex: 1; min-width: 0; }

    .notif-item-msg {
        margin: 0 0 2px;
        font-size: 0.845rem;
        color: var(--ink-900);
        line-height: 1.4;
        white-space: normal;
    }

    .notif-item-time {
        margin: 0;
        font-size: 0.75rem;
        color: var(--ink-600);
    }

    .notif-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #3b82f6;
        flex-shrink: 0;
        margin-top: 5px;
    }

    @media (max-width: 900px) {
        header { padding: 0.65rem 1rem; }
        .header-center { justify-content: flex-start; }
        .notif-panel { width: 300px; }
    }

    @media (max-width: 700px) {
        header { align-items: flex-start; flex-direction: column; }
        .header-center, .header-right { width: 100%; justify-content: flex-start; }
        .notif-panel { right: auto; left: 0; width: 290px; }
    }
</style>
