<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';

    let { showModal = $bindable(), entreprises = $bindable(), competences = $bindable(), domaines = $bindable(), user } = $props();

    function disable_modal() {
        showModal = false;
    }

    const form = useForm({
        nom: '',
        ent_id: '',
        nb_week: '',
        week_hour: '',
        paye_hour: '',
        teletrav: false,
        poste_desc: '',
        profil_desc: '',
        domaines: [] as number[],
        competences: [] as number[],
    });

    if (user.role_id == 2) {
        $form.ent_id = entreprises.id;
    }

    function toggleDomaine(id: number) {
        if ($form.domaines.includes(id)) {
            $form.domaines = $form.domaines.filter((d: number) => d !== id);
        } else {
            $form.domaines = [...$form.domaines, id];
        }
    }

    function toggleCompetence(id: number) {
        if ($form.competences.includes(id)) {
            $form.competences = $form.competences.filter((c: number) => c !== id);
        } else {
            $form.competences = [...$form.competences, id];
        }
    }

    function submit(e: Event) {
        e.preventDefault();
        $form.post('/offre', {
            preserveState: true,
            onSuccess: () => { $form.reset(); showModal = false; }
        });
    }
</script>

<div class="overlay" onclick={(e) => e.target === e.currentTarget && disable_modal()}>
    <div class="modal">

        <!-- Header -->
        <div class="modal-header">
            <div class="modal-title">
                <div class="modal-icon">📋</div>
                <div>
                    <h1>Publier une offre</h1>
                    <p class="modal-subtitle">Remplissez les informations de votre offre de stage</p>
                </div>
            </div>
            <button class="close-btn" onclick={disable_modal} title="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form onsubmit={submit}>

            <!-- Section : Informations générales -->
            <div class="section">
                <div class="section-label">Informations générales</div>

                <div class="field">
                    <label for="nom">Nom de l'offre <span class="required">*</span></label>
                    <input bind:value={$form.nom} type="text" id="nom" placeholder="Ex : Stage développeur web full-stack"/>
                    {#if $form.errors.nom}<span class="erreur">{$form.errors.nom}</span>{/if}
                </div>

                {#if user.role_id == 1}
                <div class="field">
                    <label>Entreprise <span class="required">*</span></label>
                    <div class="chips">
                        {#each entreprises as e}
                            <button
                                type="button"
                                class="chip"
                                class:selected={$form.ent_id == e.id}
                                onclick={() => $form.ent_id = e.id}
                            >{e.nom}</button>
                        {/each}
                    </div>
                    {#if $form.errors.ent_id}<span class="erreur">{$form.errors.ent_id}</span>{/if}
                </div>
                {/if}
            </div>

            <!-- Section : Conditions -->
            <div class="section">
                <div class="section-label">Conditions</div>

                <div class="row-3">
                    <div class="field">
                        <label for="nb_week">Durée <span class="required">*</span></label>
                        <div class="input-unit">
                            <input bind:value={$form.nb_week} type="number" id="nb_week" placeholder="8" min="1"/>
                            <span class="unit">sem.</span>
                        </div>
                        {#if $form.errors.nb_week}<span class="erreur">{$form.errors.nb_week}</span>{/if}
                    </div>

                    <div class="field">
                        <label for="week_hour">Heures / sem. <span class="required">*</span></label>
                        <div class="input-unit">
                            <input bind:value={$form.week_hour} type="number" id="week_hour" placeholder="35" min="1"/>
                            <span class="unit">h</span>
                        </div>
                        {#if $form.errors.week_hour}<span class="erreur">{$form.errors.week_hour}</span>{/if}
                    </div>

                    <div class="field">
                        <label for="paye_hour">Gratification <span class="required">*</span></label>
                        <div class="input-unit">
                            <input bind:value={$form.paye_hour} type="number" step="0.01" id="paye_hour" placeholder="3.90" min="0"/>
                            <span class="unit">€/h</span>
                        </div>
                        {#if $form.errors.paye_hour}<span class="erreur">{$form.errors.paye_hour}</span>{/if}
                    </div>
                </div>

                <div class="toggle-row">
                    <div class="toggle-info">
                        <span class="toggle-label">Télétravail possible</span>
                        <span class="toggle-desc">Le poste peut être exercé à distance</span>
                    </div>
                    <label class="toggle" for="teletrav">
                        <input type="checkbox" id="teletrav" bind:checked={$form.teletrav}/>
                        <span class="toggle-track"></span>
                    </label>
                </div>
            </div>

            <!-- Section : Domaines & Compétences -->
            <div class="section">
                <div class="section-label">Domaines & Compétences</div>

                {#if domaines && domaines.length > 0}
                <div class="field">
                    <label>Domaines</label>
                    <div class="chips">
                        {#each domaines as d}
                            <button
                                type="button"
                                class="chip"
                                class:selected={$form.domaines.includes(d.id)}
                                onclick={() => toggleDomaine(d.id)}
                            >{d.name}</button>
                        {/each}
                    </div>
                    {#if $form.errors.domaines}<span class="erreur">{$form.errors.domaines}</span>{/if}
                </div>
                {/if}

                {#if competences && competences.length > 0}
                <div class="field">
                    <label>Compétences</label>
                    <div class="chips">
                        {#each competences as c}
                            <button
                                type="button"
                                class="chip"
                                class:selected={$form.competences.includes(c.id)}
                                onclick={() => toggleCompetence(c.id)}
                            >{c.name}</button>
                        {/each}
                    </div>
                    {#if $form.errors.competences}<span class="erreur">{$form.errors.competences}</span>{/if}
                </div>
                {/if}
            </div>

            <!-- Section : Descriptions -->
            <div class="section">
                <div class="section-label">Descriptions</div>

                <div class="field">
                    <label for="poste_desc">Description du poste <span class="required">*</span></label>
                    <textarea bind:value={$form.poste_desc} id="poste_desc" rows="4" placeholder="Décrivez les missions, le contexte, les outils utilisés..."></textarea>
                    {#if $form.errors.poste_desc}<span class="erreur">{$form.errors.poste_desc}</span>{/if}
                </div>

                <div class="field">
                    <label for="profil_desc">Profil recherché <span class="required">*</span></label>
                    <textarea bind:value={$form.profil_desc} id="profil_desc" rows="4" placeholder="Niveaux d'études, compétences attendues, qualités..."></textarea>
                    {#if $form.errors.profil_desc}<span class="erreur">{$form.errors.profil_desc}</span>{/if}
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <Button type="button" variant="btnGrey" onclick={disable_modal}>Annuler</Button>
                <Button type="submit" variant="btnBleu">Publier l'offre →</Button>
            </div>

        </form>
    </div>
</div>

<style>
    /* ── Overlay ── */
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 18, 40, 0.65);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    /* ── Modal ── */
    .modal {
        width: 620px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        background: var(--surface-card);
        border-radius: 20px;
        border: 1px solid var(--border-200);
        box-shadow: 0 24px 60px rgba(10, 18, 40, 0.25);
        display: flex;
        flex-direction: column;
    }

    /* ── Header ── */
    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.5rem 1.75rem 0;
    }

    .modal-title {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .modal-icon {
        font-size: 1.5rem;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .modal-title h1 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--ink-900);
        margin: 0 0 0.15rem 0;
        line-height: 1.2;
    }

    .modal-subtitle {
        font-size: 0.82rem;
        color: var(--ink-600);
        margin: 0;
    }

    .close-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        color: var(--ink-600);
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.15s, color 0.15s;
    }

    .close-btn:hover {
        background: var(--surface-muted);
        color: var(--ink-900);
    }

    .close-btn:focus-visible {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    /* ── Form ── */
    form {
        display: flex;
        flex-direction: column;
        gap: 0;
        padding: 0 1.75rem 1.75rem;
        margin-top: 1.25rem;
    }

    /* ── Sections ── */
    .section {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
        padding: 1.1rem 0;
        border-top: 1px solid var(--border-200);
    }

    .section:first-of-type {
        border-top: none;
        padding-top: 0;
    }

    .section-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* ── Fields ── */
    .field {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }

    label {
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--ink-600);
    }

    .required { color: #ef4444; margin-left: 1px; }

    input[type="text"],
    input[type="number"],
    textarea {
        padding: 0.6rem 0.85rem;
        border: 1px solid var(--border-200);
        border-radius: 10px;
        font-size: 0.9rem;
        outline: none;
        background: var(--surface-subtle);
        color: var(--ink-900);
        font-family: inherit;
        box-sizing: border-box;
        width: 100%;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: var(--primary-600);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    textarea { resize: vertical; line-height: 1.6; }

    /* ── 3-column row ── */
    .row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0.75rem;
    }

    /* ── Input with unit ── */
    .input-unit {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-unit input {
        padding-right: 2.8rem;
    }

    .unit {
        position: absolute;
        right: 0.75rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--ink-600);
        pointer-events: none;
        white-space: nowrap;
    }

    /* ── Télétravail toggle ── */
    .toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: var(--surface-subtle);
        border: 1px solid var(--border-200);
        border-radius: 10px;
    }

    .toggle-info {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .toggle-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--ink-900);
    }

    .toggle-desc {
        font-size: 0.78rem;
        color: var(--ink-600);
    }

    .toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
    }

    .toggle input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-track {
        width: 44px;
        height: 24px;
        border-radius: 999px;
        background: var(--surface-muted);
        border: 1px solid var(--border-200);
        transition: background 0.2s ease, border-color 0.2s ease;
        position: relative;
    }

    .toggle-track::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--ink-600);
        transition: transform 0.2s ease, background 0.2s ease;
    }

    .toggle input:checked + .toggle-track {
        background: var(--primary-600);
        border-color: var(--primary-600);
    }

    .toggle input:checked + .toggle-track::after {
        transform: translateX(20px);
        background: #fff;
    }

    .toggle:focus-within .toggle-track {
        outline: 3px solid rgba(37, 99, 235, 0.35);
        outline-offset: 2px;
    }

    /* ── Chips (domaines / compétences) ── */
    .chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.45rem;
    }

    .chip {
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        color: var(--ink-600);
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s;
    }

    .chip:hover {
        border-color: var(--primary-600);
        color: var(--primary-700);
        background: var(--primary-50);
    }

    .chip.selected {
        background: var(--primary-50);
        border-color: var(--primary-600);
        color: var(--primary-700);
    }

    /* ── Footer ── */
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-200);
        margin-top: 0.5rem;
    }

    /* ── Error ── */
    .erreur {
        color: #ef4444;
        font-size: 0.8rem;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .modal { border-radius: 16px; }
        .modal-header { padding: 1.25rem 1.25rem 0; }
        form { padding: 0 1.25rem 1.25rem; }
        .row-3 { grid-template-columns: 1fr 1fr; }
        .modal-footer { flex-direction: column-reverse; }
    }

    @media (max-width: 420px) {
        .row-3 { grid-template-columns: 1fr; }
    }
</style>
