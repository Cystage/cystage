<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import logo from './img/logo.png';

    let showModal = false;
</script>

<AppHead title="Bienvenu">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>


<main>
    <div class="style1">
        <div class="divGauche">
            <div class="texte1">
                Plateforme de gestion de stages
            </div>

            <h1>
                Trouvez votre stage.
            <br>
                Construisez votre avenir.
            </h1>
        
            <p class="texte2">
                CyStage centralise les offres, simplifie les démarches et facilite les échanges
                entre étudiants, entreprises et encadrants sur une seule plateforme moderne,
                claire et accessible.
            </p>
            <div class="nonConnecte">
                <a href="/login" class="bouttonLogin">
                    Se connecter
                </a>
                <a href="/register" class="bouttonLogin2">
                Compte étudiant
                </a>
                <a href="/newent" class="btn btnBlanc">
                Compte entreprise
                </a>
            </div>
            <div class="divStatistiques">
                    <div class="previsualisationStatistiques">
                        <strong>+120</strong>
                        <span>offres</span>
                        </div>
                    </div>
                    <div class="previsualisationStatistiques">
                        <strong>+35</strong>
                        <span>entreprises</span>
                    </div>

                    <div class="previsualisationStatistiques">
                        <strong>3</strong>
                        <span>espaces dédiés</span>
                    </div>
                </div>
            </div>
            
            <div class="divDroite">
                <div class="divAffichage1">
                    <span class="miniTexte">Recherche simplifiée</span>
            <h3>Tout regrouper. Tout clarifier.</h3>
            <p>
                Offres, profils et suivi sont réunis dans une seule interface pensée
                pour rendre la recherche de stage plus fluide.
            </p>
        </div>
                   
    </div>
    
</main>

{#if showModal}
    <Modal bind:showModal={showModal} user={null}/>
{/if}

<style>
 :global(body) {
  --primary-700: #1d4ed8;
  --primary-600: #2563eb;
  --primary-100: #dbeafe;
  --primary-50: #eff6ff;
  --ink-900: #0f172a;
  --ink-600: #475569;
  --border-200: #e2e8f0;
  margin: 0;
  background: linear-gradient(180deg, #f3f8ff 0%, #ffffff 28%, #f8fafc 100%);
  color: var(--ink-900);
  font-family: "Plus Jakarta Sans", sans-serif;
 }

 * { box-sizing: border-box; }

 main { width: 100%; overflow: hidden; }

 .hero {
  position: relative;
  padding: 5rem 1.5rem 3.8rem;
  overflow: hidden;
 }

 .fond1,
 .fond2 {
  position: absolute;
  border-radius: 999px;
  pointer-events: none;
  z-index: 0;
 }

 .fond1 {
  top: -300px;
  left: 40%;
  width: 980px;
  height: 980px;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.14) 0%, rgba(59, 130, 246, 0) 70%);
 }

 .fond2 {
  top: 70px;
  right: 7%;
  width: 280px;
  height: 280px;
  background: radial-gradient(circle, rgba(29, 78, 216, 0.14) 0%, rgba(29, 78, 216, 0) 70%);
 }

 .contenuHero {
  position: relative;
  z-index: 1;
  max-width: 1220px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 2.2rem;
  align-items: center;
 }

 .blocGauche { max-width: 680px; }

 .zoneLogo {
  display: inline-flex;
  align-items: center;
  justify-content: flex-start;
  margin-bottom: 1rem;
 }

 .logoHero { width: 250px; max-width: 100%; height: auto; display: block; object-fit: contain; }

 .petitBadge {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.5rem 0.95rem;
  border-radius: 999px;
  background: var(--primary-50);
  border: 1px solid var(--primary-100);
  color: var(--primary-700);
  font-size: 0.9rem;
  font-weight: 700;
  margin-bottom: 1rem;
 }

 h1 {
  margin: 0 0 1.1rem;
  font-size: clamp(2.2rem, 5vw, 4.2rem);
  line-height: 1.05;
  letter-spacing: -0.04em;
  font-weight: 800;
 }

 .texteHero { margin: 0 0 2rem; max-width: 620px; font-size: 1.05rem; line-height: 1.75; color: var(--ink-600); }

 .actionsHero { display: flex; flex-wrap: wrap; gap: 0.9rem; }

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
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
 }

 .btnBleu {
  background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
  color: #fff;
  box-shadow: 0 24px 48px rgba(37, 99, 235, 0.2);
 }

 .btnBleu:hover { transform: translateY(-2px); }

 .btnBlanc {
  background: #fff;
  color: var(--ink-900);
  border-color: var(--border-200);
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
 }

 .btnBlanc:hover { border-color: var(--primary-100); transform: translateY(-2px); }

 .statsHero { display: flex; flex-wrap: wrap; gap: 0.85rem; margin-top: 1.4rem; }

 .petiteStat {
  min-width: 116px;
  padding: 0.9rem 1rem;
  border-radius: 16px;
  background: #ffffff;
  border: 1px solid var(--primary-100);
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.1);
 }

 .petiteStat strong { display: block; font-size: 1.2rem; line-height: 1; color: var(--ink-900); }
 .petiteStat span { display: block; margin-top: 0.35rem; color: var(--ink-600); font-size: 0.9rem; }

 .blocDroite { display: flex; flex-direction: column; gap: 1rem; }
 .ligneCartes { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

 .carte {
  background: #fff;
  border: 1px solid var(--border-200);
  border-radius: 22px;
  padding: 1.35rem;
  box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
 }

 .carteGrande { min-height: 190px; display: flex; flex-direction: column; justify-content: center; }

 .miniTexte {
  display: inline-flex;
  margin-bottom: 0.8rem;
  color: var(--primary-700);
  font-weight: 700;
  font-size: 0.86rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
 }

 .carte h3 { margin: 0 0 0.65rem; font-size: 1.1rem; }
 .carte p { margin: 0; color: var(--ink-600); line-height: 1.65; }

 .miniOffre {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.8rem;
  padding: 0.95rem 0;
  border-top: 1px solid #edf2f7;
 }

 .miniOffre:first-of-type { border-top: none; padding-top: 0.2rem; }
 .miniOffre h4 { margin: 0 0 0.25rem; font-size: 1rem; }
 .miniOffre p { margin: 0; color: var(--ink-600); font-size: 0.9rem; }

 .tagPetit {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 52px;
  padding: 0.42rem 0.7rem;
  border-radius: 999px;
  background: var(--primary-50);
  color: var(--primary-700);
  font-size: 0.8rem;
  font-weight: 700;
  white-space: nowrap;
 }

 .section { max-width: 1220px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
 .sectionMoins { padding-top: 0.5rem; }

 .titreBloc { max-width: 760px; margin: 0 auto 2.3rem; text-align: center; }

 .titreBloc span {
  display: inline-block;
  margin-bottom: 0.75rem;
  color: var(--primary-700);
  font-weight: 700;
  font-size: 0.92rem;
  text-transform: uppercase;
  letter-spacing: 0.045em;
 }

 .titreBloc h2, .blocFin h2 { margin: 0 0 0.95rem; font-size: clamp(1.8rem, 3vw, 2.8rem); line-height: 1.14; }
 .titreBloc p { margin: 0; color: var(--ink-600); line-height: 1.75; font-size: 1rem; }

 .grille4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; }
 .grille3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem; }

 .blocInfo {
  background: #ffffff;
  border: 1px solid #e5edf5;
  border-radius: 20px;
  padding: 1.45rem;
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
 }

 .iconeBloc {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, #eff6ff, #dbeafe);
  color: var(--primary-700);
  font-weight: 800;
  font-size: 1.05rem;
 }

 .blocInfo h3 { margin: 0 0 0.75rem; font-size: 1.05rem; }
 .blocInfo p { margin: 0; color: var(--ink-600); line-height: 1.72; }

 .zoneEtapes { position: relative; }
 .ligneEtapes {
  position: absolute;
  top: 29px;
  left: 8%;
  right: 8%;
  height: 2px;
  background: linear-gradient(90deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.38), rgba(59, 130, 246, 0.15));
  z-index: 0;
 }

 .zoneEtapes .grille3 { position: relative; z-index: 1; }

 .numeroEtape {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  border-radius: 999px;
  background: rgba(37, 99, 235, 0.12);
  color: var(--primary-700);
  font-weight: 800;
 }

 .sectionFin { max-width: 1220px; margin: 0 auto; padding: 0 1.5rem 4.8rem; }

 .blocFin {
  padding: 3rem 2rem;
  text-align: center;
  border-radius: 28px;
  border: 1px solid var(--primary-100);
  background: linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
  box-shadow: 0 20px 46px rgba(37, 99, 235, 0.1);
 }

 .miniTitreFin {
  display: inline-block;
  margin-bottom: 0.85rem;
  color: var(--primary-700);
  font-size: 0.92rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.045em;
 }

 .blocFin p { max-width: 700px; margin: 0 auto 1.9rem; color: var(--ink-600); line-height: 1.75; }
 .centre { justify-content: center; }

 @media (max-width: 1024px) {
  .contenuHero { grid-template-columns: 1fr; gap: 1.6rem; }
  .blocGauche { max-width: unset; }
  .grille4 { grid-template-columns: repeat(2, 1fr); }
  .grille3 { grid-template-columns: repeat(2, 1fr); }
 }

 @media (max-width: 768px) {
  .hero { padding-top: 3.6rem; }
  .section, .sectionFin { padding-left: 1rem; padding-right: 1rem; }
  .logoHero { width: 210px; }
  h1 { font-size: clamp(2rem, 9vw, 2.8rem); }
  .texteHero { font-size: 1rem; line-height: 1.65; }
  .ligneCartes, .grille4, .grille3 { grid-template-columns: 1fr; }
  .ligneEtapes { display: none; }
  .actionsHero { flex-direction: column; }
  .btn { width: 100%; }
  .blocFin { padding: 2rem 1.2rem; }
 }
</style>
