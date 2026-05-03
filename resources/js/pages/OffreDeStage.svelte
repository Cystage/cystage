<script lang="ts">
    import ModalPoste from "./ModalPoste.svelte";
    import { page, router } from '@inertiajs/svelte';
    import Button from '@/components/Button.svelte';

    let { offre = $bindable(), entreprise = $bindable(), doms, skills, etudiant = $bindable(), canManage = false, onedit = null, dejaPostule = false } = $props();

    let showModalPostuler = $state(false);
    let user = $derived($page.props.auth?.user);

    function truncate(text: string, max = 160) {
        if (!text || text.length <= max) return text;
        return text.slice(0, max).trimEnd() + '…';
    }

    function supprimerOffre() {
        if (confirm(`Supprimer l'offre "${offre.nom}" ? Cette action supprimera aussi toutes les candidatures associées.`)) {
            router.delete(`/offre/${offre.id}`, { preserveScroll: true });
        }
    }

    function portal(node: HTMLElement) {
        document.body.appendChild(node);
        return {
            destroy() {
                node.remove();
            }
        };
    }
</script>

<article class="card">
    <header class="card-header">
        <div class="header-left">
            {#if entreprise?.logo}
                <img src={entreprise.logo} alt="Logo {entreprise.nom}" class="logo-ent" loading="lazy" />
            {:else}
                <div class="logo-placeholder">{entreprise?.nom?.[0] ?? '?'}</div>
            {/if}
            <div class="header-info">
                <h1>{offre.nom}</h1>
                <span class="ent-nom">{entreprise?.nom}</span>
            </div>
        </div>

        <div class="badges">
            {#if offre.teletrav}
                <span class="badge badge-green">🏠 Télétravail</span>
            {:else}
                <span class="badge badge-gray">🏢 Présentiel</span>
            {/if}
            {#each doms as d}
                <span class="badge badge-blue">#{d.name}</span>
            {/each}
        </div>
    </header>

    <hr class="divider"/>

    <!-- Infos rapides -->
    <div class="info-grid">
        <div class="info-item">
            <span class="info-icon">📅</span>
            <div>
                <span class="info-label">Durée</span>
                <span class="info-value">{offre.nb_week} semaines</span>
            </div>
        </div>
        <div class="info-item">
            <span class="info-icon">⏰</span>
            <div>
                <span class="info-label">Rythme</span>
                <span class="info-value">{offre.week_hour}h / semaine</span>
            </div>
        </div>
        <div class="info-item">
            <span class="info-icon">💶</span>
            <div>
                <span class="info-label">Gratification</span>
                <span class="info-value">{offre.paye_hour} €/h</span>
            </div>
        </div>
        <div class="info-item">
            <span class="info-icon">📍</span>
            <div>
                <span class="info-label">Lieu</span>
                <span class="info-value">{entreprise?.ville}, {entreprise?.pays}</span>
            </div>
        </div>
    </div>
    <hr class="divider"/>

    <!-- Description -->
    <div class="section">
        <h2>Description du poste</h2>
        <p>{truncate(offre.poste_desc)}</p>
    </div>

    <div class="section">
        <h2>Profil recherché</h2>
        <p>{truncate(offre.profil_desc)}</p>
    </div>

    <!-- Compétences -->
    {#if skills && skills.length > 0}
        <div class="section">
            <h2>Compétences</h2>
            <div class="skills">
                {#each skills as s}
                    <span class="skill-tag">{s.name}</span>
                {/each}
            </div>
        </div>
    {/if}

    <footer class="card-footer">
        <span class="contact">📞 {entreprise?.num_tel}</span>

        <div class="footer-actions">
            {#if canManage}
                <button class="btn-edit" onclick={() => onedit && onedit(offre)}>Modifier</button>
                <button class="btn-del" onclick={supprimerOffre}>Supprimer</button>
            {/if}
            <a href="/offre/{offre.id}" class="btn-detail">Voir le détail</a>
            {#if user?.role_id == 3}
                {#if dejaPostule}
                    <span class="already-applied">✓ Déjà postulé</span>
                {:else}
                    <Button variant="btnBleu" onclick={() => showModalPostuler = true}> Postuler →</Button>
                {/if}
            {/if}
        </div>
    </footer>

    {#if showModalPostuler}
        <div use:portal>
            <ModalPoste etudiant={etudiant} bind:showModalPostuler={showModalPostuler} offre={offre}/>
        </div>
    {/if}
</article>

<style>


    .card {
        background: var(--surface-card);
        border: 1px solid var(--border-200);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.1);
        transform: translateY(-2px);
    }

    /* Header — mobile-first */
    .card-header {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    @media (min-width: 600px) {
        .card-header {
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 0.9rem;
    }

    .logo-ent {
        width: 56px;
        height: 56px;
        object-fit: contain;
        border-radius: 12px;
        border: 1px solid var(--border-200);
        background: var(--surface-subtle);
        padding: 5px;
        flex-shrink: 0;
    }

    .logo-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--primary-50), var(--primary-100));
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        border: 1px solid var(--border-200);
        flex-shrink: 0;
    }

    .header-info h1 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--ink-900);
        margin: 0 0 0.2rem 0;
        line-height: 1.3;
    }

    .ent-nom {
        font-size: 0.875rem;
        color: var(--ink-600);
        font-weight: 500;
    }

    /* Badges */
    .badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        align-items: flex-start;
        justify-content: flex-start;
    }

    @media (min-width: 600px) {
        .badges { justify-content: flex-end; }
    }

    .badge {
        padding: 0.3rem 0.7rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-green { background: var(--badge-green-bg);  color: var(--badge-green-text); }
    .badge-gray  { background: var(--badge-gray-bg);   color: var(--badge-gray-text);  }
    .badge-blue  { background: var(--primary-50);       color: var(--primary-600);      }

    /* Divider */
    .divider {
        border: none;
        border-top: 1px solid var(--border-200);
        margin: 1rem 0;
    }

    /* Info grid — mobile-first */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    @media (min-width: 600px) {
        .info-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: var(--surface-subtle);
        border-radius: 10px;
        padding: 0.6rem 0.8rem;
        border: 1px solid var(--border-200);
    }

    .info-icon { font-size: 1.1rem; }

    .info-label {
        display: block;
        font-size: 0.72rem;
        color: var(--ink-600);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .info-value {
        display: block;
        font-size: 0.88rem;
        color: var(--ink-900);
        font-weight: 600;
        margin-top: 0.1rem;
    }

    /* Sections */
    .section { margin-bottom: 1rem; }

    .section h2 {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--ink-600);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0 0.4rem 0;
    }

    .section p {
        font-size: 0.9rem;
        color: var(--ink-900);
        line-height: 1.65;
        margin: 0;
    }

    /* Skills */
    .skills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .skill-tag {
        padding: 0.3rem 0.75rem;
        background: var(--surface-muted);
        border: 1px solid var(--border-200);
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--ink-900);
    }

    /* Footer */
    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-200);
    }

    .contact {
        font-size: 0.85rem;
        color: var(--ink-600);
    }

    .footer-actions {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .btn-detail {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-600);
        text-decoration: none;
        padding: 0.4rem 0.85rem;
        border: 1px solid var(--primary-200, #bfdbfe);
        border-radius: 8px;
        background: var(--primary-50);
        transition: background 0.15s;
    }

    .btn-detail:hover { background: var(--primary-100, #dbeafe); }

    .already-applied {
        font-size: 0.82rem;
        font-weight: 600;
        color: #16a34a;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 0.4rem 0.9rem;
        white-space: nowrap;
    }

    .btn-edit, .btn-del {
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: opacity 0.15s;
    }

    .btn-edit { background: var(--surface-muted); color: var(--ink-600); border: 1px solid var(--border-200); }
    .btn-edit:hover { opacity: 0.8; }
    .btn-del  { background: #fee2e2; color: #991b1b; }
    .btn-del:hover  { opacity: 0.8; }

    /* card-footer — stack sur mobile */
    .card-footer {
        flex-wrap: wrap;
        gap: 0.75rem;
    }
</style>