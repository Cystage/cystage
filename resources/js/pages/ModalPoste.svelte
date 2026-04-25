<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    let { showModalPostuler = $bindable(), offre = $bindable(), etudiant = $bindable()} = $props();
    function disable_modal() {
        showModalPostuler=!showModalPostuler;
        console.log(showModalPostuler);
    }
   

    const form = useForm({ offre_id: offre.id,etu_id: etudiant.id, state:1 ,motiv:'',path:''});

    function submit(e:Event) {
        e.preventDefault();
        $form.post('/postulation', {
            preserveState: true,
            onSuccess: () => { $form.reset(); showModalPostuler = false; }
        });

    }
</script>

<div class="overlay">
    <div class="modal">
        <div class="header">

            <h1 class="titre">Postuler chez Test {offre.entreprise}</h1>
            <button class="close" onclick={disable_modal}><p>❌</p></button>
        </div>

        <br><br>
        <form onsubmit={submit}>
            <div class="field">
                <label for="">Expliquez nous votre motivation!</label>
                <textarea 
                    name="" 
                    id=""
                    bind:value={$form.motiv}
                    rows=10>
                </textarea>
            </div>

            <div class="field">
                <label for="">Déposer votre cv ici</label>
                    <div class="drop-area" ondragover={(e) => e.preventDefault()} ondrop={(e) => { e.preventDefault(); $form.path = e.dataTransfer?.files[0]; }}>
                        
                        {#if $form.path}
                            Fichier prêt : {$form.path.name}
                        {:else}
                            Déposez votre fichier ici
                        {/if}
                    </div>
            </div>


            <button type="submit" class="submit">Envoyer ma candidature</button>
        </form>
    </div>
</div>

<style>
    :global(body) {
        --primary-700: #1d4ed8;
        --primary-600: #2563eb;
        --primary-100: #dbeafe;
        --ink-900: #0f172a;
        --ink-600: #475569;
        --border-200: #e2e8f0;
        font-family: "Plus Jakarta Sans", sans-serif;
    }

    .overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0,0,0,0.6);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal {
        position: relative;
        width: 480px;
        max-width: 90vw;
        max-height: 85vh;
        overflow-y: auto;
        background: white;
        border-radius: 18px;
        border: 1px solid var(--border-200);
        padding: 2rem;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.2);
    }
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .titre {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ink-900);
    }
    .close {
        background: none;
        border: none;
        font-size: 1.1rem;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        transition: background 0.15s;
    }
    .close:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .field {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink-600);
    }
    input, textarea {
        width: 100%;
        padding: 0.55rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.15s;
        font-family: inherit;
        box-sizing: border-box;
    }
    input:focus, textarea:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    textarea {
        resize: vertical;
    }
    .submit {
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.15s;
        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
    }
    .submit:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 18px 35px rgba(37, 99, 235, 0.28);
    }
    .erreur {
        color: #ef4444;
        font-size: 0.8rem;
    }
    .drop-area { 
        border: 2px dashed #93c5fd;
        border-radius: 10px;
        padding: 24px;
        text-align: center;
        background: #eff6ff;
    }

    .close:focus-visible,
    input:focus-visible,
    textarea:focus-visible,
    .submit:focus-visible,
    .drop-area:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }
</style>
