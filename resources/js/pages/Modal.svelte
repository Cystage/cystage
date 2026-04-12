<script lang="ts">
    import { useForm } from '@inertiajs/svelte';

    let { showModal = $bindable() } = $props();
    function disable_modal() {
        showModal=!showModal;
        console.log(showModal);
    }
    //'nom','entreprise','adresse','description'
    const form = useForm({ nom: '',entreprise: '', adresse: '',description:''});

    function submit(e) {
        e.preventDefault();
        $form.post('/offre', {
            preserveState: true,
            onSuccess: () => { $form.reset(); showModal = false; }
        });
    }
</script>

<div class="overlay">
    <div class="modal">
        <div class="header">

            <h1 class="titre">Poster votre offre de stage </h1>
            <button class="close" onclick={disable_modal}><p>❌</p></button>
        </div>

        <br><br>
        <form onsubmit={submit}>
            <div class="field">
                <label for="nom">Nom de l'offre</label>
                <input bind:value={$form.nom} type="text" id="nom" placeholder="Ex: Stage développeur web"/>
                {#if $form.errors.nom}<span class="erreur">{$form.errors.nom}</span>{/if}
            </div>

            <div class="field">
                <label for="entreprise">Entreprise</label>
                <input bind:value={$form.entreprise} type="text" id="entreprise" placeholder="Ex: Google"/>
                {#if $form.errors.entreprise}<span class="erreur">{$form.errors.entreprise}</span>{/if}
            </div>

            <div class="field">
                <label for="adresse">Adresse</label>
                <input bind:value={$form.adresse} type="text" id="adresse" placeholder="Ex: Paris, 75001"/>
                {#if $form.errors.adresse}<span class="erreur">{$form.errors.adresse}</span>{/if}
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea bind:value={$form.description} id="description" rows="3" placeholder="Décrivez le poste..."></textarea>
                {#if $form.errors.description}<span class="erreur">{$form.errors.description}</span>{/if}
            </div>

            <button type="submit" class="submit">Publier l'offre</button>
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
</style>