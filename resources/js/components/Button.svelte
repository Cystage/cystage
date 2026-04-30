<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    interface Props {
        children?: Snippet;
        type?: "button" | "submit" | "reset";
        href?: string | null;
        variant?: "btnBleu" | "btnBlanc" | "btn-ghost" | "btnGreen" | "btnGrey";
        disabled?: boolean;
        onclick?: (e: MouseEvent) => void;
        isFull?: boolean;
    }

    let {
        children,
        type = "button" as "button" | "submit" | "reset",
        href = null,
        variant = "btnBleu",
        onclick = undefined,
        disabled = false,
        isFull = false
    } = $props();
</script>

{#if href}
    <a href="{href}" use:inertia class="btn {variant}" class:full={isFull}>
        {@render children?.()}
    </a>
{:else}
    <button {type} {onclick} class="btn {variant}" class:full={isFull} {disabled}>
        {@render children?.()}
    </button>
{/if}

<style>
  a { text-decoration: none; }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    min-height: 44px;
    padding: 0.6rem 1.2rem;
    border-radius: 980px;
    border: 1px solid transparent;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    font-family: inherit;
    letter-spacing: -0.01em;
    cursor: pointer;
    transition: opacity 0.15s ease, background-color 0.15s ease, transform 0.12s ease;
    white-space: nowrap;
  }

  .btn:focus-visible {
    outline: 3px solid rgba(0, 113, 227, 0.35);
    outline-offset: 2px;
  }

  /* Bleu — Apple style */
  .btnBleu {
    background: var(--primary-600);
    color: #ffffff;
  }

  .btnBleu:not(:disabled):hover {
    opacity: 0.88;
    transform: translateY(-1px);
  }

  .btnBleu:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  /* Blanc */
  .btnBlanc {
    background: var(--surface-0);
    color: var(--ink-900);
    border-color: var(--border-200);
  }

  .btnBlanc:hover {
    background: var(--surface-subtle);
    transform: translateY(-1px);
  }

  /* Ghost */
  .btn-ghost {
    background: transparent;
    color: var(--primary-600);
    border: none;
    border-radius: 8px;
  }

  .btn-ghost:hover {
    background: var(--primary-50);
  }

  /* Green */
  .btnGreen {
    background: #28a745;
    color: white;
    border-radius: 980px;
  }

  .btnGreen:hover { opacity: 0.88; transform: translateY(-1px); }

  /* Grey */
  .btnGrey {
    background: var(--surface-muted);
    color: var(--ink-700);
    border-color: var(--border-200);
    border-radius: 980px;
  }

  .btnGrey:hover { background: var(--border-200); transform: translateY(-1px); }

  .full {
    width: 100%;
    display: flex;
  }
</style>
