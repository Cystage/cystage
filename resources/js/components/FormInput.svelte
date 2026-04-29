<script lang="ts">
    import { inertia } from '@inertiajs/svelte';
    import type { Snippet } from 'svelte';

    interface Props {

    }

    let {
        label,
        value = $bindable(),
        error="",
        type="text",
        id,
        placeholder="",
        required=false,
        isFull=false
        
    } = $props();
</script>
    <div class="form-group {isFull ? 'form-group-full' : ''}">
        <label for={id}>
            {label}
            {#if required}<span class="required">*</span>{/if}
        </label>
            <input
                {type} 
                {id} 
                {placeholder} 
                bind:value={value}
                class:input-error={error}
                />

            {#if error}
                <span class="error-message">{error}</span>
            {/if}
    </div>



<style>
    .form-group {   
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 0.5rem;
        }
        
    .form-group-full {
        grid-column: 1 / -1;
    }

    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink-600, #4b5563);
    }
    .required {
        color: #dc3545;
        font-weight: bold;
        margin-left: 2px;
    }

    input {
        width: 100%;
        padding: 0.7rem 0.9rem;
        border: 1px solid var(--border-200, #d1d5db);
        border-radius: 10px;
        font-size: 0.95rem;
        font-family: inherit;
        background: var(--surface-subtle, #f8fafc);
        color: var(--ink-900, #0f172a);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }

    input:focus, textarea:focus {
        border-color: var(--primary-600, #2563eb);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    input.input-error, textarea.input-error {
        border-color: #dc3545 !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        min-height: 1.2em;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }
    </style>