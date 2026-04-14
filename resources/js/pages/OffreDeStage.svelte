<script lang="ts">
    let { offre = $bindable() }= $props();

</script>

    <div class="main">
        <header>

            <h1>{offre.nom}<br></h1>
            
            <div class="location">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                <p> {offre.adresse}</p>
            </div>
            <p>de {offre.entreprise}<br></p>
        </header>
        <br><br>
        <p>{offre.description}</p>

    </div>

    <style>
        h1 {
            font-size: 2em;
        }
        div.main {
            padding: 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-left: 15%;
            margin-right: 15%;
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
    </style>