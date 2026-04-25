<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    let { showModalPostuler = $bindable(), offre = $bindable(), etudiant = $bindable()} = $props();
    function disable_modal() {
        showModalPostuler=!showModalPostuler;
        console.log(showModalPostuler);
    }
   

    const form = useForm({ offre_id: offre.id,etu_id: etudiant.id, state:1 ,motiv:'',path:null});

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


            <button type="submit" class="submit">Postez l'offre</button>
        </form>
    </div>
</div>

<style>
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
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
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
        color: #1e293b;
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
        color: #374151;
    }
    input, textarea {
        width: 100%;
        padding: 0.55rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.15s;
        font-family: inherit;
        box-sizing: border-box;
    }
    input:focus, textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    textarea {
        resize: vertical;
    }
    .submit {
        margin-top: 0.5rem;
        padding: 0.65rem;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }
    .submit:hover {
    background: #1d4ed8;
    animation: shake 0.5s infinite;
    }
    @keyframes shake {
        0%   { transform: rotate(0deg); }
        33%  { transform: rotate(-5deg); }
        66%  { transform: rotate(5deg); }
        100% { transform: rotate(0deg); }
    }
    .erreur {
        color: #ef4444;
        font-size: 0.8rem;
    }
    .drop-area { 
        border: 2px dashed #666; 
        padding: 40px; 
        text-align: center;
        background: #eee;
    }
</style>
