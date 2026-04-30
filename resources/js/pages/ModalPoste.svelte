<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';

    let { showModalPostuler = $bindable(), offre = $bindable(), etudiant = $bindable()} = $props();
    function disable_modal() {
        showModalPostuler = !showModalPostuler;
    }

    const form = useForm({ 
        offre_id: offre.id,
        etu_id: etudiant.id,
        state: 1,
        motiv: '',
        path: null as File | null
    });

    let isDragging = $state(false);

    function handleFile(file: File) {
        if (file && file.type === 'application/pdf') {
            $form.path = file;
        } else {
            alert('Veuillez déposer un fichier PDF uniquement.');
        }
    }

    function handleDrop(e: DragEvent) {
        e.preventDefault();
        isDragging = false;
        const file = e.dataTransfer?.files[0];
        if (file) handleFile(file);
    }

    function handleInputChange(e: Event) {
        const input = e.target as HTMLInputElement;
        const file = input.files?.[0];
        if (file) handleFile(file);
    }

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/postulation', {
            forceFormData: true,
            preserveState: true,
            onSuccess: () => {
                $form.reset();
                showModalPostuler = false;
            }
        });
    }


</script>

<div class="overlay">
    <div class="modal">

        <div class="header">
                <div class="header-info">
                    <p class="pre-titre">Candidature pour</p>
                    <h1 class="titre">{offre.nom}</h1>
                </div>
                <button class="close" onclick={disable_modal}>✕</button>
            </div>

            <form onsubmit={submit}>
                <div class="field">
                    <label for="motiv">
                        ✍️ Lettre de motivation
                        <span class="required">*</span>
                    </label>
                    <textarea
                        id="motiv"
                        bind:value={$form.motiv}
                        rows={7}
                        placeholder="Expliquez pourquoi vous êtes intéressé par ce poste, vos compétences clés, vos expériences pertinentes..."
                    ></textarea>
                    {#if $form.errors.motiv}
                        <span class="erreur">{$form.errors.motiv}</span>
                    {/if}
                </div>

                <div class="field">
                    <label for="file-input">
                        📄 CV <span class="required">*</span>
                        <span class="label-hint">— PDF uniquement</span>
                    </label>
                    <div
                        class="drop-area"
                        class:dragging={isDragging}
                        class:has-file={$form.path}
                        ondragover={(e) => { e.preventDefault(); isDragging = true; }}
                        ondragleave={() => isDragging = false}
                        ondrop={handleDrop}
                        onclick={() => document.getElementById('file-input')?.click()}
                        role="button"
                        tabindex="0"
                        onkeydown={(e) => e.key === 'Enter' && document.getElementById('file-input')?.click()}
                    >
                        {#if $form.path}
                            <div class="file-ready">
                                <span class="file-icon">📎</span>
                                <div>
                                    <p class="file-name">{($form.path as File).name}</p>
                                    <p class="file-hint">Cliquez pour changer de fichier</p>
                                </div>
                            </div>
                        {:else}
                            <span class="drop-icon">☁️</span>
                            <p class="drop-text">Glissez votre CV ici</p>
                            <p class="drop-hint">ou cliquez pour parcourir</p>
                        {/if}
                    </div>
                    <input
                        id="file-input"
                        type="file"
                        accept=".pdf"
                        style="display:none"
                        onchange={handleInputChange}
                    />
                    {#if $form.errors.path}
                        <span class="erreur">{$form.errors.path}</span>
                    {/if}
                </div>
                
                <Button type="submit" variant="btnBleu" disabled={$form.processing}>
                    {#if $form.processing}
                        <span class="spinner"></span> Envoi en cours
                    {:else}
                        Envoyer ma candidature →
                    {/if}
               </Button>
            </form>
    </div>
</div>

<style>


    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal {
        width: 520px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        background: var(--surface-card);
        border-radius: 20px;
        border: 1px solid var(--border-200);
        padding: 2rem;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
    }

    /* Header */
    .header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .pre-titre {
        font-size: 0.8rem;
        color: var(--ink-600);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0 0.2rem 0;
    }

    .titre {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ink-900);
        margin: 0;
        line-height: 1.3;
    }

    .close {
        background: var(--surface-muted);
        border: none;
        font-size: 0.9rem;
        color: var(--ink-600);
        cursor: pointer;
        padding: 0.4rem 0.6rem;
        border-radius: 8px;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .close:hover { background: var(--border-200); color: var(--ink-900); }

    /* Form */
    form { display: flex; flex-direction: column; gap: 1.25rem; }

    .field { display: flex; flex-direction: column; gap: 0.4rem; }

    label {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--ink-600);
    }

    .label-hint {
        font-weight: 400;
        color: #94a3b8;
        font-size: 0.8rem;
    }

    .required { color: #ef4444; }

    textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-200);
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        font-family: inherit;
        background: var(--surface-subtle);
        color: var(--ink-900);
        box-sizing: border-box;
        resize: vertical;
        transition: border-color 0.15s, box-shadow 0.15s;
        line-height: 1.6;
    }

    textarea:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    /* Drop area */
    .drop-area {
        border: 2px dashed var(--border-200);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        background: var(--surface-subtle);
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
    }

    .drop-area:hover { border-color: var(--primary-600); background: var(--primary-50); }
    .drop-area.dragging { border-color: var(--primary-600); background: var(--primary-50); }
    .drop-area.has-file { border-color: var(--badge-green-text); background: var(--badge-green-bg); border-style: solid; }

    .drop-icon { font-size: 2rem; display: block; margin-bottom: 0.4rem; }
    .drop-text { font-size: 0.9rem; font-weight: 600; color: var(--ink-900); margin: 0; }
    .drop-hint { font-size: 0.8rem; color: var(--ink-600); margin: 0.2rem 0 0 0; }

    .file-ready {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-align: left;
    }

    .file-icon { font-size: 1.5rem; }
    .file-name { font-size: 0.9rem; font-weight: 600; color: var(--badge-green-text); margin: 0; }
    .file-hint { font-size: 0.78rem; color: var(--ink-600); margin: 0.15rem 0 0 0; }

    .erreur { color: #ef4444; font-size: 0.8rem; }

    /* Spinner */
    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    p.attente::after {
        content:'';
        animation: dotAnimation 1.5s infinite;
    }
    @keyframes dotAnimation {
        0%  {content: '';}
        33% {content: ' .';}
        66% {content: ' ..';}
        100% {content:' ...';}
    }
</style>