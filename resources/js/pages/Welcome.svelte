<script lang="ts">
 import Header from '@/components/Header.svelte'
 import AppHead from '@/components/AppHead.svelte'
 import { page } from '@inertiajs/svelte'
 import { onMount } from 'svelte'
 import OffreDeStage from './OffreDeStage.svelte'
 import Modal from './Modal.svelte'
 import Login from './Login.svelte'
 import logo from './img/logo.png'

<<<<<<< HEAD
 let {entreprises = $bindable(), offres, competences = $bindable(), domaines = $bindable(), links_offres_competences, links_offres_domaines } = $props()

let showModal = $state(false)
 
 let showLogin = $state(false)
=======
    import logo from './img/logo.png';
    import Unconnect from './Unconnect.svelte';

    let { entreprises=$bindable(), offres, competences=$bindable(), domaines=$bindable(), links_offres_competences, links_offres_domaines, etudiant=$bindable() }= $props();
>>>>>>> 8f55180a704c043dfefc77ee95b7f3063183cbfb


 function recupDomaines(offre, liens, listeDomaines){
  
  
  let res = []
  
  for(let l of liens){
   if(offre.id == l.offre_id){
    res.push(listeDomaines[l.dom_id-1])
   }
  }
    
    return res
 }

 function recupEntreprise(offre, listeEntreprises){
    for(let e of listeEntreprises){
    if(offre.ent_id == e.id){
      return e
   }
  }
 }

 function recupCompetences(offre, liens, listeCompetences){
  let res = []
  for(let l of liens){
   if(offre.id == l.offre_id){
    res.push(listeCompetences[l.skill_id - 1])
   }
  }
  return res
 }

 let utilisateur = $derived(page?.props?.auth?.user ?? null)

 onMount(() => {
  
  let observer = new IntersectionObserver((entrees) => {
   entrees.forEach((entree) => {
    
    if(entree.isIntersecting){
     entree.target.classList.add('visible')
    }
   })
  }, {
   threshold: 0.14
  })

  let blocs = document.querySelectorAll('.apparition')
  
  blocs.forEach((b) => observer.observe(b))

  window.addEventListener('scroll', animScroll)

  return () => {
   observer.disconnect()
   window.removeEventListener('scroll', animScroll)
  }
 })
</script>

<AppHead title="Welcome">
 <link rel="preconnect" href="https://rsms.me/" />
 <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
 <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</AppHead>

<Header bind:showModal={showModal} bind:showLogin={showLogin} />

<main>
 <section class="hero">
  <div class="fond1"></div>
  <div class="fond2"></div>

  <div class="contenuHero">
   <div class="blocGauche apparition visible">
    <div class="zoneLogo">
     <img src={logo} alt="Logo CyStage" class="logoHero">
    </div>
<<<<<<< HEAD

    <div class="petitBadge">
     Plateforme de gestion de stages
=======
    {#if user}
    <div class="offres-list">
        {#if user.role_id == 2}
            {#each offres as o}
                <OffreDeStage offre={o} entreprise={entreprises} doms={getdoms(o,links_offres_domaines,domaines)} skills={getskills(o,links_offres_competences,competences)}/>
            {/each}
        {:else}
            {#each offres as o}
                <OffreDeStage  etudiant={etudiant} offre={o} entreprise={getent(o,entreprises)} doms={getdoms(o,links_offres_domaines,domaines)} skills={getskills(o,links_offres_competences,competences)}/>
            {/each}
        {/if}
>>>>>>> 8f55180a704c043dfefc77ee95b7f3063183cbfb
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

    {#if !utilisateur}
     <div class="actionsHero">
      <button class="btn btnBleu" onclick={() => showLogin = true}>
       Se connecter
      </button>

      <a href="/register" class="btn btnBlanc">
       Compte étudiant
      </a>

      <a href="/newent" class="btn btnBlanc">
       Compte entreprise
      </a>
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
    {/if}
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








 {#if !utilisateur}
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
     <button class="btn btnBleu" onclick={() => showLogin = true}>
      Connexion
     </button>

     <a href="/register" class="btn btnBlanc">
      Inscription étudiant
     </a>

     <a href="/newent" class="btn btnBlanc">
      Inscription entreprise
     </a>
    </div>
   </div>
  </section>
 {/if}











 {#if utilisateur}
  <section class="zoneOffres apparition visible">
   <div class="titreBloc titreGauche">
    <span>Espace connecté</span>
    <h2>Offres disponibles</h2>
    <p>Retrouvez ici les offres actuellement présentes sur la plateforme.</p>
   </div>







   <div class="listeOffres">
    {#if utilisateur.role_id == 2}
     {#each offres as offre}
      <OffreDeStage
       offre={offre}
       entreprise={entreprises}
       doms={recupDomaines(offre, links_offres_domaines, domaines)}
       skills={recupCompetences(offre, links_offres_competences, competences)}
      />
     {/each}
     
     
     
     
    {:else}
     {#each offres as offre}
      <OffreDeStage
       offre={offre}
       entreprise={recupEntreprise(offre, entreprises)}
       doms={recupDomaines(offre, links_offres_domaines, domaines)}
       skills={recupCompetences(offre, links_offres_competences, competences)}
      />
     {/each}
    {/if}
   </div>
  </section>
 {/if}
</main>

<<<<<<< HEAD


=======
<center>
    {#if !user}
        <Unconnect/>
    {/if}
</center>
>>>>>>> 8f55180a704c043dfefc77ee95b7f3063183cbfb

{#if showModal}


 <Modal
  bind:showModal={showModal}
  bind:domaines={domaines}
  bind:competences={competences}
  bind:entreprises={entreprises}
  user={utilisateur}
 />
{/if}









{#if showLogin}
    <Login bind:showLogin={showLogin} />
{/if}













<footer>
 <p>© CyStage - Tous droits réservés 2026</p>
</footer>










<style>
 :global(body){
  margin:0;
  background:linear-gradient(180deg,#f8fbff 0%,#ffffff 35%,#f8fafc 100%);
  color:#0f172a;
  font-family:"Plus Jakarta Sans", sans-serif;
 }

 *{
  box-sizing:border-box;
 }

 main{
  width:100%;
  overflow:hidden;
 }

 .hero{
  position:relative;
  padding:4.6rem 1.5rem 3.4rem 1.5rem;
  overflow:hidden;
 }

 .fond1{
  position:absolute;
  top:-220px;
  left:50%;
  width:1000px;
  height:1000px;
  border-radius:999px;
  pointer-events:none;
  z-index:0;
 }

 .fond2{
  position:absolute;
  top:90px;
  right:8%;
  width:260px;
  height:260px;
  border-radius:999px;
  pointer-events:none;
  z-index:0;
 }

 .contenuHero{
  position:relative;
  z-index:1;
  max-width:1220px;
  margin:0 auto;
  display:grid;
  grid-template-columns:1.15fr 0.95fr;
  gap:2.1rem;
  align-items:center;
 }

 .blocGauche{
  max-width:680px;
 }

 .zoneLogo{
  display:inline-flex;
  align-items:center;
  justify-content:flex-start;
  margin-bottom:1.2rem;
  position:relative;
 }

 .logoHero{
  position:relative;
  z-index:1;
  width:265px;
  max-width:100%;
  height:auto;
  display:block;
  object-fit:contain;
 }

 .petitBadge{
  display:inline-flex;
  align-items:center;
  gap:.4rem;
  padding:.55rem .95rem;
  border-radius:999px;
  background:rgba(37, 99, 235, 0.08);
  border:1px solid rgba(191, 219, 254, 0.85);
  color:#2563eb;
  font-size:.93rem;
  font-weight:700;
  margin-bottom:1rem;
  backdrop-filter:blur(10px);
 }

 h1{
  margin:0 0 1rem 0;
  font-size:clamp(2.5rem, 5vw, 4.6rem);
  line-height:1.04;
  letter-spacing:-0.04em;
  font-weight:800;
 }

 .texteHero{
  margin:0 0 2rem 0;
  max-width:620px;
  font-size:1.08rem;
  line-height:1.85;
  color:#475569;
 }

 .actionsHero{
  display:flex;
  flex-wrap:wrap;
  gap:.9rem;
 }

 .btn{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-height:50px;
  padding:.9rem 1.35rem;
  border-radius:16px;
  border:none;
  text-decoration:none;
  font-size:.98rem;
  font-weight:700;
  cursor:pointer;
 }



 .btnBleu{
  color:white;
  box-shadow:0 14px 30px rgba(37, 99, 235, 0.25);
 }

 .btnBleu:hover{
  box-shadow:0 18px 40px rgba(37, 99, 235, 0.32);
 }

 .btnBlanc{
  background:rgba(255,255,255,.9);
  color:#0f172a;
  border:1px solid #dbe4f0;
  box-shadow:0 10px 24px rgba(15, 23, 42, 0.05);
 }

 .btnBlanc:hover{
  border-color:#bfdbfe;
  box-shadow:0 14px 30px rgba(15, 23, 42, 0.08);
 }

 .statsHero{
  display:flex;
  flex-wrap:wrap;
  gap:.85rem;
  margin-top:1.4rem;
 }

 .petiteStat{
  min-width:116px;
  padding:.95rem 1rem;
  border-radius:18px;
  background:rgba(255,255,255,.75);
  backdrop-filter:blur(12px);
  border:1px solid rgba(219, 234, 254, 0.95);
  box-shadow:0 14px 34px rgba(37, 99, 235, 0.08);
  transition:transform .28s ease, box-shadow .28s ease, border-color .28s ease;
 }

 .petiteStat:hover{
  transform:translateY(-6px);
  box-shadow:0 20px 40px rgba(37, 99, 235, 0.12);
  border-color:#bfdbfe;
 }

 .petiteStat strong{
  display:block;
  font-size:1.25rem;
  line-height:1;
  color:#0f172a;
 }

 .petiteStat span{
  display:block;
  margin-top:.35rem;
  color:#64748b;
  font-size:.92rem;
 }

 .blocDroite{
  display:flex;
  flex-direction:column;
  gap:1rem;
 }

 .ligneCartes{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:1rem;
 }

 .carte{
  background:rgba(255,255,255,.84);
  backdrop-filter:blur(12px);
  border:1px solid rgba(226, 232, 240, 0.9);
  border-radius:24px;
  padding:1.45rem;
  box-shadow:0 22px 50px rgba(15, 23, 42, 0.07);
  transition:transform .3s ease, box-shadow .3s ease, border-color .3s ease;
  animation:floatY 6s ease-in-out infinite;
 }



 .carteGrande{
  min-height:190px;
  display:flex;
  flex-direction:column;
  justify-content:center;
 }


 .carteOffres{
  animation-delay:1s;
 }

 .miniTexte{
  display:inline-flex;
  margin-bottom:.8rem;
  color:#2563eb;
  font-weight:700;
  font-size:.88rem;
 }

 .carte h3{
  margin:0 0 .7rem 0;
  font-size:1.12rem;
 }

 .carte p{
  margin:0;
  color:#64748b;
  line-height:1.7;
 }

 .miniOffre{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:.8rem;
  padding:.95rem 0;
  border-top:1px solid #eef2f7;
 }

 .miniOffre:first-of-type{
  border-top:none;
  padding-top:.2rem;
 }

 .miniOffre h4{
  margin:0 0 .25rem 0;
  font-size:1rem;
 }

 .miniOffre p{
  margin:0;
  color:#64748b;
  font-size:.92rem;
 }

 .tagPetit{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  min-width:52px;
  padding:.45rem .7rem;
  border-radius:999px;
  background:#eff6ff;
  color:#2563eb;
  font-size:.82rem;
  font-weight:700;
  white-space:nowrap;
 }

 .section{
  max-width:1220px;
  margin:0 auto;
  padding:2rem 1.5rem 4rem 1.5rem;
 }

 .sectionMoins{
  padding-top:.5rem;
 }

 .titreBloc{
  max-width:760px;
  margin:0 auto 2.3rem auto;
  text-align:center;
 }

 .titreGauche{
  text-align:left;
  margin:0 0 2rem 0;
  max-width:unset;
 }

 .titreBloc span{
  display:inline-block;
  margin-bottom:.75rem;
  color:#2563eb;
  font-weight:700;
  font-size:.95rem;
 }

 .titreBloc h2,
 .blocFin h2{
  margin:0 0 .95rem 0;
  font-size:clamp(1.9rem, 3vw, 2.9rem);
  line-height:1.12;
 }

 .titreBloc p{
  margin:0;
  color:#64748b;
  line-height:1.8;
  font-size:1.02rem;
 }

 .grille4{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:1.2rem;
 }

 .grille3{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:1.2rem;
 }

 .blocInfo{
  background:white;
  border:1px solid #e5edf5;
  border-radius:24px;
  padding:1.55rem;
  box-shadow:0 16px 38px rgba(15, 23, 42, 0.05);
  transition:transform .28s ease, box-shadow .28s ease, border-color .28s ease;
 }

 .blocInfo:hover{
  transform:translateY(-8px);
  box-shadow:0 22px 48px rgba(15, 23, 42, 0.09);
  border-color:#bfdbfe;
 }

 .iconeBloc{
  width:46px;
  height:46px;
  border-radius:14px;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:1rem;
  background:linear-gradient(135deg,#eff6ff,#dbeafe);
  color:#2563eb;
  font-weight:800;
  font-size:1.15rem;
  box-shadow:0 10px 24px rgba(37, 99, 235, 0.10);
 }

 .blocInfo h3{
  margin:0 0 .75rem 0;
  font-size:1.08rem;
 }

 .blocInfo p{
  margin:0;
  color:#64748b;
  line-height:1.74;
 }

 .zoneEtapes{
  position:relative;
 }

 .ligneEtapes{
  position:absolute;
  top:29px;
  left:8%;
  right:8%;
  height:2px;
  z-index:0;
 }

 .zoneEtapes .grille3{
  position:relative;
  z-index:1;
 }

 .numeroEtape{
  width:44px;
  height:44px;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:1rem;
  border-radius:999px;
  background:rgba(37, 99, 235, 0.1);
  color:#2563eb;
  font-weight:800;
  box-shadow:0 10px 24px rgba(37, 99, 235, 0.18);
 }

 .sectionFin{
  max-width:1220px;
  margin:0 auto;
  padding:0 1.5rem 4.6rem 1.5rem;
 }

 .blocFin{
  padding:3rem 2rem;
  text-align:center;
  border-radius:30px;
  border:1px solid #dbeafe;
  box-shadow:0 22px 50px rgba(37, 99, 235, 0.08);
 }

 .miniTitreFin{
  display:inline-block;
  margin-bottom:.85rem;
  color:#2563eb;
  font-size:.95rem;
  font-weight:700;
 }

 .blocFin p{
  max-width:700px;
  margin:0 auto 1.9rem auto;
  color:#64748b;
  line-height:1.8;
 }

 .centre{
  justify-content:center;
 }

 .zoneOffres{
  max-width:1100px;
  margin:0 auto;
  padding:2rem 1.5rem 4rem 1.5rem;
 }

 .listeOffres{
  width:100%;
  display:flex;
  flex-direction:column;
  gap:1rem;
 }

 footer{
  padding:1.4rem 1rem 2rem 1rem;
  text-align:center;
  color:#64748b;
  font-size:.95rem;
 }

 footer p{
  margin:0;
 }



  .grille3{
   grid-template-columns:1fr;
  }

  .ligneEtapes{
   display:none;
  }
 


  .logoHero{
   width:210px;
  }

  .ligneCartes,
  .grille4{
   grid-template-columns:1fr;
  }

  .section,
  .sectionFin,
  .zoneOffres{
   padding-left:1rem;
   padding-right:1rem;
  }

  .blocFin{
   padding:2rem 1.2rem;
  }

  .actionsHero{
   flex-direction:column;
  }

  .btn{
   width:100%;
  }


</style>
