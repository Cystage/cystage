<script lang="ts">
    import type { Snippet } from 'svelte';

    let {
        title = '',
        description = '',
        children,
    }: {
        title?: string;
        description?: string;
        children?: Snippet;
    } = $props();

    const appName = import.meta.env.VITE_APP_NAME || 'CyStage';
    const fullTitle = $derived(title ? `${title} — ${appName}` : appName);
    const metaDesc = $derived(description || 'CyStage — plateforme de gestion de stages pour étudiants, entreprises et encadrants.');
</script>

<svelte:head>
    <title>{fullTitle}</title>
    <meta name="description" content={metaDesc} />
    {@render children?.()}
</svelte:head>
