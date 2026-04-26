<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    interface Props {
        children?: Snippet;
        type?: "button" | "submit" | "reset";
        href?: string | null;
        variant?: "btnBleu" | "btnBlanc" | "btn-ghost" | "btnBleu" | "btnGreen" | "btnGrey";
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
        isFull =false
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

  a {
    text-decoration:"none";
  }
  .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 50px;
  padding: 0.85rem 1.35rem;
  border-radius: 14px;
  border: 1px solid transparent;
  text-decoration: none;
  font-size: 0.95rem;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
 }

 .btn:focus-visible {
  outline: 3px solid rgba(37, 99, 235, 0.35);
  outline-offset: 2px;
 }

 .btnBleu {
  background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
  color: #ffffff;
  box-shadow: var(--shadow-medium);
 }

 .btnBleu:hover {
  transform: translateY(-2px);
  box-shadow: 0 28px 52px rgba(37, 99, 235, 0.24);
 }

    .btnBleu:not(:disabled):hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 28px rgba(37, 99, 235, 0.3);
    }

    .btnBleu:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

 .btnBlanc {
  background: var(--surface-0);
  color: var(--ink-900);
  border-color: var(--border-200);
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
 }

 .btnBlanc:hover {
  border-color: var(--primary-100);
  transform: translateY(-2px);
 }

 .btn-ghost {
    background: transparent;
    color: var(--primary-600);
    border: none;
  }

  .btn-ghost:hover {
    background: var(--primary-50);
    color: var(--primary-700);
  }

  .btnGreen   { background: #16a34a; color: white; }

  .btnGreen:focus-visible,
   .btnGrey:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }
    
   .btnGreen:hover   { background: #15803d; transform: translateY(-1px); }

    .btnGrey { background: #f1f5f9; color: #1e293b; border: 1px solid #e2e8f0; }

    .btnGrey:hover { background: #e2e8f0; transform: translateY(-1px); }
  @media (max-width: 768px) {
        .hero {
            width: 100%;
        } 
    }

    .full {
        width: 100%;
        display: flex;
    }
</style>