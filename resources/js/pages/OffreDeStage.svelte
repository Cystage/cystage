<script lang="ts">
    import ModalPoste from "./ModalPoste.svelte";
    import { page } from '@inertiajs/svelte';

    let { offre = $bindable(), entreprise = $bindable(), doms, skills, etudiant = $bindable() } = $props();

    let showModalPostuler = $state(false);
    let user = $derived($page.props.auth?.user);

    function portal(node: HTMLElement) {
        document.body.appendChild(node);
        return {
            destroy() {
                node.remove();
            }
        };
    }
</script>

<div class="card">
    <!-- Header -->
    <div class="card-header">
        <div class="header-left">
            {#if entreprise?.logo}
                <img src={entreprise.logo} alt="Logo {entreprise.nom}" class="logo-ent"/>
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
    </div>

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

    <style>

        h1 { font-size: clamp(1.35rem, 2.4vw, 1.9rem); margin: 0; color: var(--ink-900); }
        h2 { font-size: 1.1rem; color: var(--ink-900); margin: 0.5rem 0; }

        div.main {
            padding: 1.4rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--border-200);
            border-radius: 16px;
            margin-left: 10%;
            margin-right: 10%;
            background: #fff;
        }

        div.location {
            display: flex;
            align-items: left;
            vertical-align: bottom;
            gap:5px;
        }
        div.location svg {
            margin-top: 2px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 0.25rem;
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.24);
        }

        input[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 35px rgba(37, 99, 235, 0.28);
        }

        p.information {
            color: var(--ink-600);
        }

        p {
            margin: 0.35rem 0;
            color: var(--ink-900);
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            div.main {
                margin: 0;
                padding: 1rem;
            }
        }
    </style>
