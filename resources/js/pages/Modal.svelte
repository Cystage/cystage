<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    let { showModal = $bindable(), entreprises = $bindable(), competences = $bindable(), domaines = $bindable(), user } = $props();
    function disable_modal() {
        showModal=!showModal;
        console.log(showModal);
    }
    //'nom','ent_id','nb_week','week_hour','paye_hour','teletrav','poste_desc','profil_desc'
    const form = useForm({ nom: '',ent_id: '', nb_week: '',week_hour:'',paye_hour:'',teletrav:'',poste_desc:'',profil_desc:'',domaines: [1],competences: [1]});
    function submit(e) {
        e.preventDefault();
        $form.post('/offre', {
            preserveState: true,
            onSuccess: () => { $form.reset(); showModal = false; }
        });
    }
    $form.teletrav = false;
    if(user.role_id == 2){
        $form.ent_id = entreprises.id;
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
            {#if user.role_id == 1}
            <div class="field">
                <label>Entreprise</label>
                {#each entreprises as e }
                    <label><input name="ent_id" type="radio" bind:group={$form.ent_id} value={e.id}/> {e.nom}</label>
                {/each}
                {#if $form.errors.ent_id}<span class="erreur">{$form.errors.ent_id}</span>{/if}
            </div>
            {/if}
            <div class="field">
                <label>Domaines</label>
                {#each domaines as d}
                    <label><input id="{d.name}" type="checkbox" bind:group={$form.domaines} value={d.id}/> {d.name}</label>
                {/each}
                {#if $form.errors.domaines}<span class="erreur">{$form.errors.domaines}</span>{/if}
            </div>

            <div class="field">
                <label>Compétences</label>
                {#each competences as c}
                    <label><input id="{c.name}" type="checkbox" bind:group={$form.competences} value="{c.id}"> {c.name}</label>
                {/each}
                {#if $form.errors.competences}<span class="erreur">{$form.errors.competences}</span>{/if}
            </div>

            <div class="field">
                <label for="nb_week">Durée (semaines)</label>
                <input bind:value={$form.nb_week} type="number" id="nb_week" placeholder="8"/>
                {#if $form.errors.nb_week}<span class="erreur">{$form.errors.nb_week}</span>{/if}
            </div>

            <div class="field">
                <label for="week_hour">Heures/semaine</label>
                <input bind:value={$form.week_hour} type="number" id="week_hour" placeholder="35"/>
                {#if $form.errors.week_hour}<span class="erreur">{$form.errors.week_hour}</span>{/if}
            </div>

            <div class="field">
                <label for="paye_hour">Taux horaire</label>
                <input bind:value={$form.paye_hour} type="number" step=0.01 id="paye_hour" placeholder="3.5"/>
                {#if $form.errors.paye_hour}<span class="erreur">{$form.errors.paye_hour}</span>{/if}
            </div>

            <div class="field">
                <label for="teletrav">Télétravail possible</label>
                <input bind:checked={$form.teletrav} id="teletrav" type="checkbox" placeholder=""/>
            </div>

            <div class="field">
                <label for="poste_desc">Description du poste</label>
                <textarea bind:value={$form.poste_desc} id="poste_desc" rows="3" placeholder="Décrivez le poste..."></textarea>
                {#if $form.errors.poste_desc}<span class="erreur">{$form.errors.poste_desc}</span>{/if}
            </div>

            <div class="field">
                <label for="profil_desc">Description du profil recherché</label>
                <textarea bind:value={$form.profil_desc} id="profil_desc" rows="3" placeholder="Décrivez le profil..."></textarea>
                {#if $form.errors.profil_desc}<span class="erreur">{$form.errors.profil_desc}</span>{/if}
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