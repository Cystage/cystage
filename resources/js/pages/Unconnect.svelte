<script lang="ts">
    import Header from '@/components/Header.svelte';  
    import AppHead from '@/components/AppHead.svelte';
    import { createInertiaApp } from '@inertiajs/svelte';
    import OffreDeStage from './OffreDeStage.svelte';
    import Modal from './Modal.svelte';
    import Login from './Login.svelte';
    import logo from './img/logo.png';

    
    let {entreprises = $bindable(), offres, competences = $bindable(), domaines = $bindable(), links_offres_competences, links_offres_domaines } = $props();
    
    let showModal= $state(false);
    let showLogin= $state(false);

    function recupererDesDomaines(offres,liens,listeDesDomaines){
        let domaines = $state([]);
        for(let varListe of liens){
            if(offres.id == l.offre_id){
                domaines.push(d[varListe.dom_id-1]);
            }
        }
        return domaines;
    }

    function recupererEntreprise(offre,listeEntreprises){
        for(let entreprises of listeEntreprises){
            if(offre.ent_id == entreprises.id){
                return entreprises;
            }
        }
    }

    function recupererCompetences(offre,liens,listeCompetences){
        let tabCompetences=[];
        for(let varListe of liens){
            if(offre.id == varListe.offre_id){
                res.push(listeCompetences[varListe.skill_id-1]);
            }
        }
        return tabCompetences;
    }


    function modal() {
        showModal=!showModal;
    }

    function login() {
        showLogin=!showLogin;
    }

    let ListePhraseInspirante = [
        "Trouvez votre futur ici",
        "Débutez votre carrière profesionnelle!",
        "Votre futur commence aujourd'hui",
        "L'avenir est entre vos mains",
        "Reprenez votre destin en main",
        "Découvrez le monde profesionnel!",
        "N'arrêtez jamais d'apprendre!",
        "Construisons la génération de demain!",
    ]

    const phraseInspirante = ListePhraseInspirante[Math.floor(Math.random() * ListePhraseInspirante.length)];

    
    
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
            <!-- #if !utilisateur} -->
                <div class="nonConnecte">
                    <button class="bouttonLogin"  onclick={() => showLogin = true}>
                        Se connecter
                    </button>
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
                <!-- {/if} -->
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
    <Modal bind:showModal={showModal}/>
{/if}

{#if showLogin}
    <Login bind:showLogin={showLogin}/>
{/if}   


<style>
    * {
        font-family: "Plus Jakarta Sans", sans-serif;
        font-optical-sizing: auto;
        font-style: normal;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 1rem;
    }

    .hero {
        text-align: center;
        margin-bottom: 2rem;
    }

    .hero img {
        margin-bottom: 1rem;
    }

    .phrase {
        font-size: 1.1rem;
        color: #64748b;
        font-style: italic;
    }

    .offres-list {
        width: 100%;
        max-width: 800px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    footer {
        background-color: rgb(223, 223, 223);
        padding-top: 50px;
        justify-content: center;
    }
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

 .style1{
  position:relative;
  z-index:1;
  max-width:1220px;
  margin:0 auto;
  display:grid;
  grid-template-columns:1.15fr 0.95fr;
  gap:2.1rem;
  align-items:center;
 }

 .divGauche{
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

 .texte1{
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

 .texte2{
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

 .previsualisationStatistiques{
  min-width:116px;
  padding:.95rem 1rem;
  border-radius:18px;
  background:rgba(255,255,255,.75);
  backdrop-filter:blur(12px);
  border:1px solid rgba(219, 234, 254, 0.95);
  box-shadow:0 14px 34px rgba(37, 99, 235, 0.08);
  transition:transform .28s ease, box-shadow .28s ease, border-color .28s ease;
 }

 .previsualisationStatistiques:hover{
  transform:translateY(-6px);
  box-shadow:0 20px 40px rgba(37, 99, 235, 0.12);
  border-color:#bfdbfe;
 }

 .previsualisationStatistiques strong{
  display:block;
  font-size:1.25rem;
  line-height:1;
  color:#0f172a;
 }

 .previsualisationStatistiques span{
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
