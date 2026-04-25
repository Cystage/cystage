<script lang="ts">
    import AppHead from '@/components/AppHead.svelte';
    import Button from '@/components/Button.svelte';
    import logo from './img/logo.png';
    
</script>

<AppHead title="Welcome">
 <link rel="preconnect" href="https://rsms.me/" />
 <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
 <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>

<main>
 <section class="hero">
  <div class="fond1"></div>
  <div class="fond2"></div>
  <div class="contenuHero">
   <div class="blocGauche apparition visible">
    <div class="zoneLogo">
     <img src={logo} alt="Logo CyStage" class="logoHero">
    </div>

    <div class="petitBadge">
     Plateforme de gestion de stages
    </div>

    <h1>
     Trouvez votre stage.<br>
     Construisez votre avenir.
    </h1>

    <p class="texteHero">
     CyStage centralise les offres, simplifie les démarches et facilite les échanges
     entre étudiants, entreprises et encadrants sur une seule plateforme moderne,
     claire et accessible.
    </p>

     <div class="actionsHero">
      <Button href="/login" variant="btn btnBleu">Se connecter</Button>
      <Button href="/register" variant="btn btnBlanc">Crée un compte</Button>
     </div>

     <div class="statsHero apparition">
      <div class="petiteStat">
       <strong>+120</strong>
       <span>offres</span>
      </div>
      <div class="petiteStat">
       <strong>+35</strong>
       <span>entreprises</span>
      </div>
      <div class="petiteStat">
       <strong>3</strong>
       <span>espaces dédiés</span>
      </div>
     </div>
   </div>

   <div class="blocDroite apparition">
    <div class="carte carteGrande">
     <span class="miniTexte">Recherche simplifiée</span>
     <h3>Tout regrouper. Tout clarifier.</h3>
     <p>
      Offres, profils et suivi sont réunis dans une seule interface pensée
      pour rendre la recherche de stage plus fluide.
     </p>
    </div>
    <div class="ligneCartes">
     <div class="carte cartePetite">
      <span class="miniTexte">Étudiants</span>
      <h3>Consulter</h3>
      <p>Trouvez des offres adaptées à votre profil.</p>
     </div>
     <div class="carte cartePetite">
      <span class="miniTexte">Entreprises</span>
      <h3>Publier</h3>
      <p>Diffusez vos opportunités plus simplement.</p>
     </div>
    </div>
    <div class="carte carteOffres">
     <span class="miniTexte">Aperçu</span>
     <div class="miniOffre">
      <div>
       <h4>Développeur Web</h4>
       <p>Frontend / Backend / UI</p>
      </div>
      <span class="tagPetit">Stage</span>
     </div>
     <div class="miniOffre">
      <div>
       <h4>Assistant Data</h4>
       <p>Analyse / Visualisation / SQL</p>
      </div>
      <span class="tagPetit">Data</span>
     </div>
     <div class="miniOffre">
      <div>
       <h4>Support SI</h4>
       <p>Infrastructure / Réseau / Outils</p>
      </div>
      <span class="tagPetit">SI</span>
     </div>
    </div>
   </div>
  </div>
 </section>
  <section class="section apparition">
   <div class="titreBloc">
    <span>Pourquoi CyStage ?</span>
    <h2>Une plateforme pensée pour rendre la recherche de stage plus simple</h2>
    <p>
     CyStage a été conçu pour centraliser les informations utiles, améliorer
     la lisibilité des offres et fluidifier les échanges entre tous les acteurs du stage.
    </p>
   </div>

   <div class="grille4">
    <div class="blocInfo apparition">
     <div class="iconeBloc">↗</div>
     <h3>Consulter des offres</h3>
     <p>Accédez rapidement à des opportunités adaptées à différents profils et domaines.</p>
    </div>

    <div class="blocInfo apparition">
     <div class="iconeBloc">▣</div>
     <h3>Centraliser les démarches</h3>
     <p>Retrouvez les informations importantes dans un seul espace clair et structuré.</p>
    </div>

    <div class="blocInfo apparition">
     <div class="iconeBloc">◎</div>
     <h3>Faciliter les échanges</h3>
     <p>Étudiants, entreprises et encadrants interagissent dans un environnement commun.</p>
    </div>

    <div class="blocInfo apparition">
     <div class="iconeBloc">⚡</div>
     <h3>Gagner du temps</h3>
     <p>Moins de dispersion, plus de lisibilité et une expérience plus fluide pour tous.</p>
    </div>
   </div>
  </section>

  <section class="section sectionMoins apparition">
   <div class="titreBloc">
    <span>Pour qui ?</span>
    <h2>Un espace adapté à chaque profil</h2>
    <p>
     La plateforme s’adresse à tous les acteurs impliqués dans le parcours de stage,
     avec une logique simple, directe et organisée.
    </p>
   </div>

   <div class="grille3">
    <div class="blocInfo apparition">
     <h3>Étudiants</h3>
     <p>
      Consultez les offres disponibles, accédez à votre espace personnel
      et simplifiez votre recherche de stage.
     </p>
    </div>

    <div class="blocInfo apparition">
     <h3>Entreprises</h3>
     <p>
      Publiez vos offres, présentez vos besoins et valorisez vos opportunités
      auprès des étudiants.
     </p>
    </div>

    <div class="blocInfo apparition">
     <h3>Tuteurs & Encadrants</h3>
     <p>
      Suivez plus facilement les informations utiles et accompagnez les étudiants
      avec davantage de clarté.
     </p>
    </div>
   </div>
  </section>

  <section class="section apparition">
   <div class="titreBloc">
    <span>Comment ça marche ?</span>
    <h2>Une expérience simple en 3 étapes</h2>
   </div>

   <div class="zoneEtapes">
    <div class="ligneEtapes"></div>

    <div class="grille3">
     <div class="blocInfo apparition">
      <div class="numeroEtape">1</div>
      <h3>Créez votre espace</h3>
      <p>Inscrivez-vous selon votre profil pour accéder aux fonctionnalités adaptées.</p>
     </div>

     <div class="blocInfo apparition">
      <div class="numeroEtape">2</div>
      <h3>Accédez aux offres</h3>
      <p>Consultez, explorez ou publiez des opportunités selon vos besoins.</p>
     </div>

     <div class="blocInfo apparition">
      <div class="numeroEtape">3</div>
      <h3>Suivez votre progression</h3>
      <p>Centralisez les informations utiles et facilitez vos démarches de stage.</p>
     </div>
    </div>
   </div>
  </section>

  <section class="sectionFin apparition">
   <div class="blocFin">
    <span class="miniTitreFin">Rejoindre la plateforme</span>
    <h2>Prêt à démarrer avec CyStage ?</h2>
    <p>
     Connectez-vous ou créez votre espace pour accéder aux offres,
     publier des opportunités et structurer votre parcours.
    </p>
    <div class="actionsHero centre">
    <Button href="/login" variant="btn btnBleu">Connexion</Button>
    <Button href="/register" variant="btn btnBlanc">Inscription</Button>
    </div>
   </div>
  </section>
</main>

<footer>
 <p>© CyStage - Tous droits réservés 2026</p>
</footer>

<style>

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

 .blocGauche {
  max-width: 680px;
 }

 .zoneLogo {
  display: inline-flex;
  align-items: center;
  justify-content: flex-start;
  margin-bottom: 1rem;
 }

 .logoHero {
  width: 250px;
  max-width: 100%;
  height: auto;
  display: block;
  object-fit: contain;
 }

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

 .texteHero {
  margin: 0 0 2rem;
  max-width: 620px;
  font-size: 1.05rem;
  line-height: 1.75;
  color: var(--ink-600);
 }

 .actionsHero {
  display: flex;
  flex-wrap: wrap;
  gap: 0.9rem;
 }

 .statsHero {
  display: flex;
  flex-wrap: wrap;
  gap: 0.85rem;
  margin-top: 1.4rem;
 }

 .petiteStat {
  min-width: 116px;
  padding: 0.9rem 1rem;
  border-radius: 16px;
  background: #ffffff;
  border: 1px solid var(--primary-100);
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.1);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
 }

 .petiteStat:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 28px rgba(37, 99, 235, 0.13);
 }

 .petiteStat strong {
  display: block;
  font-size: 1.2rem;
  line-height: 1;
  color: var(--ink-900);
 }

 .petiteStat span {
  display: block;
  margin-top: 0.35rem;
  color: var(--ink-600);
  font-size: 0.9rem;
 }

 .blocDroite {
  display: flex;
  flex-direction: column;
  gap: 1rem;
 }

 .ligneCartes {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
 }

 .carte {
  background: var(--surface-0);
  border: 1px solid var(--border-200);
  border-radius: 22px;
  padding: 1.35rem;
  box-shadow: var(--shadow-soft);
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
 }

 .carte:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
  border-color: var(--primary-100);
 }

 .carteGrande {
  min-height: 190px;
  display: flex;
  flex-direction: column;
  justify-content: center;
 }

 .miniTexte {
  display: inline-flex;
  margin-bottom: 0.8rem;
  color: var(--primary-700);
  font-weight: 700;
  font-size: 0.86rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
 }

 .carte h3 {
  margin: 0 0 0.65rem;
  font-size: 1.1rem;
 }

 .carte p {
  margin: 0;
  color: var(--ink-600);
  line-height: 1.65;
 }

 .miniOffre {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.8rem;
  padding: 0.95rem 0;
  border-top: 1px solid #edf2f7;
 }

 .miniOffre:first-of-type {
  border-top: none;
  padding-top: 0.2rem;
 }

 .miniOffre h4 {
  margin: 0 0 0.25rem;
  font-size: 1rem;
 }

 .miniOffre p {
  margin: 0;
  color: var(--ink-600);
  font-size: 0.9rem;
 }

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

 .section {
  max-width: 1220px;
  margin: 0 auto;
  padding: 2rem 1.5rem 4rem;
 }

 .sectionMoins {
  padding-top: 0.5rem;
 }

 .titreBloc {
  max-width: 760px;
  margin: 0 auto 2.3rem;
  text-align: center;
 }

 .titreGauche {
  text-align: left;
  margin: 0 0 2rem;
  max-width: unset;
 }

 .titreBloc span {
  display: inline-block;
  margin-bottom: 0.75rem;
  color: var(--primary-700);
  font-weight: 700;
  font-size: 0.92rem;
  text-transform: uppercase;
  letter-spacing: 0.045em;
 }

 .titreBloc h2,
 .blocFin h2 {
  margin: 0 0 0.95rem;
  font-size: clamp(1.8rem, 3vw, 2.8rem);
  line-height: 1.14;
 }

 .titreBloc p {
  margin: 0;
  color: var(--ink-600);
  line-height: 1.75;
  font-size: 1rem;
 }

 .grille4 {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.2rem;
 }

 .grille3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.2rem;
 }

 .blocInfo {
  background: #ffffff;
  border: 1px solid #e5edf5;
  border-radius: 20px;
  padding: 1.45rem;
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
  transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
 }

 .blocInfo:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
  border-color: var(--primary-100);
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

 .blocInfo h3 {
  margin: 0 0 0.75rem;
  font-size: 1.05rem;
 }

 .blocInfo p {
  margin: 0;
  color: var(--ink-600);
  line-height: 1.72;
 }

 .zoneEtapes {
  position: relative;
 }

 .ligneEtapes {
  position: absolute;
  top: 29px;
  left: 8%;
  right: 8%;
  height: 2px;
  background: linear-gradient(90deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.38), rgba(59, 130, 246, 0.15));
  z-index: 0;
 }

 .zoneEtapes .grille3 {
  position: relative;
  z-index: 1;
 }

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
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
 }

 .sectionFin {
  max-width: 1220px;
  margin: 0 auto;
  padding: 0 1.5rem 4.8rem;
 }

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

 .blocFin p {
  max-width: 700px;
  margin: 0 auto 1.9rem;
  color: var(--ink-600);
  line-height: 1.75;
 }

 .centre {
  justify-content: center;
 }

 .zoneOffres {
  max-width: 1100px;
  margin: 0 auto;
  padding: 2rem 1.5rem 4rem;
 }

 .listeOffres {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1rem;
 }

 footer {
  padding: 1.4rem 1rem 2rem;
  text-align: center;
  color: var(--ink-600);
  font-size: 0.9rem;
 }

 footer p {
  margin: 0;
 }

 @media (max-width: 1024px) {
  .contenuHero {
   grid-template-columns: 1fr;
   gap: 1.6rem;
  }

  .blocGauche {
   max-width: unset;
  }

  .grille4 {
   grid-template-columns: repeat(2, 1fr);
  }

  .grille3 {
   grid-template-columns: repeat(2, 1fr);
  }
 }

 @media (max-width: 768px) {
  .hero {
   padding-top: 3.6rem;
  }

  .section,
  .sectionFin,
  .zoneOffres {
   padding-left: 1rem;
   padding-right: 1rem;
  }

  .logoHero {
   width: 210px;
  }

  h1 {
   font-size: clamp(2rem, 9vw, 2.8rem);
  }

  .texteHero {
   font-size: 1rem;
   line-height: 1.65;
  }

  .ligneCartes,
  .grille4,
  .grille3 {
   grid-template-columns: 1fr;
  }

  .ligneEtapes {
   display: none;
  }

  .actionsHero {
   flex-direction: column;
  }


  .blocFin {
   padding: 2rem 1.2rem;
  }
 }

 @media (prefers-reduced-motion: reduce) {
  .carte,
  .blocInfo,
  .petiteStat,
  .btn {
   transition: none;
  }
 }
</style>