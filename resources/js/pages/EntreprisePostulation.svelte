<script lang="ts">
    import Header from '@/components/Header.svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { useForm } from '@inertiajs/svelte';

    let postulation = [1,2,3,4,5,6,7,8,9,10];
</script>

<AppHead title="Postulations"/>

<Header/>
<main class="page-container">
    <center>
        <br><br><br><br>
        <h1>Vous avez <b><span style="color:blue">{postulation.length} nouvelles</span> candidatures!</b></h1>
        <p>Consultez les maintenant!</p>
        <br><br>
    </center>
    {#each postulation as p}
        <div class="main">
            <h2>Théo Maynadier</h2>
            <hr><br>
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h3>
            <br>
            <h3>Voir cv : <span style="color:blue">file.cv</span></h3>
            <center>
              <button class="close"><p>✅</p></button>
                <button class="close"><p>❌</p></button>
            </center>
            </div>
    {/each}
</main>

<style>
        div.main {
            padding: 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-left: 15%;
            margin-right: 15%;
            margin-bottom: 30px;
            margin-top: 30px;
        }


        .close {
        
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: background 0.15s;
            margin-left: 40px;
        }

        .close:hover {
             background-color: rgba(201, 201, 201, 0.567);
             color: #1e293b;
        }

        h1 {
            font-size: 3em;

        }

        h2 {
            font-size: 1.5em;
        }

        p  {
            font-size: 1.2em;
        }
</style>

