<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    interface Props {
        children?: Snippet;
        type?: "button" | "submit" | "reset";
        href?: string | null;
        variant?: "btnBleu" | "btnBlanc" | "btn-ghost" | "btnBleu";
        size?: "large" | "small"; 
        onclick?: (e: MouseEvent) => void;
    }

    let {
        children,
        type = "button" as "button" | "submit" | "reset",
        href = null,
        variant, 
        size="small",
        onclick = undefined,
    } = $props();
</script>

    {#if href}
        <a href="{href}" use:inertia class="btn {variant} {size}">
            {@render children()}
        </a>
    {:else}
        <button {type} {onclick} class="btn {variant} {size}">
            {@render children()}
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

  .large {
    min-height: 50px;
    padding: 0.85rem 1.35rem;
    border-radius: 14px;
  }

  .small {
    padding: 0.45rem 0.9rem;
    border-radius: 10px;
    font-size: 0.84rem;
  }

  @media (max-width: 768px) {
        .hero {
            width: 100%;
        } 
    }
</style>