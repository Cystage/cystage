<script lang="ts">
    import { useForm } from '@inertiajs/svelte';

    let { showLogin = $bindable() } = $props();
    function disable_login() {
        showLogin=!showLogin;
        console.log(showLogin);
    }
    //'nom','entreprise','adresse','description'
    const form = useForm({ name: '',email: '',password: ''});

    function submit(e) {
        e.preventDefault();
        $form.post('/offre', { 
        preserveState: true, 
        onSuccess: () => {$form.reset();showLogin = false; }
    });

    }
</script>

<div class="overlay">
    <center>

    <div class="login">
        <div class="header">

            <h1 class="titre">Login</h1>
            <button class="close" onclick={disable_login}><p>❌</p></button>
        </div>

        <br><br>
        <form onsubmit={submit}>
            <label for="Nom de l'offre">Nom de l'offre
                <br>
                <input bind:value={$form.nom} type="text" name="text" id="">
                {#if $form.errors.nom}
                                    <br>
                    <span class="erreur">{$form.errors.nom}</span>
                {/if}
            </label>
            <br>
            <label for="Entreprise">Entreprise
                <br>
                <input bind:value={$form.entreprise} type="text" name="text" id="">
                {#if $form.errors.entreprise}
                    <br>
                    <span class="erreur">{$form.errors.entreprise}</span>
                {/if}
            </label>
            <br>
            <label for="Adresse">Adresse
                <br>
                <input bind:value={$form.adresse} type="text" name="text" id="">
                {#if $form.errors.adresse}
                                    <br>
                    <span class="erreur">{$form.errors.adresse}</span>
                {/if}
            </label>
            <br>
            <label for="Description">Description de l'offre
                <br>
                <input bind:value={$form.description} type="text" name="text" id="">
                {#if $form.errors.description}
                                    <br>
                    <span class="erreur">{$form.errors.description}</span>
                {/if}
            </label>
            <br>

            <input class="submit" type="submit" name="text" id="">
        </form>
    </div>
    </center>
</div>


<style>
    .overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        z-index: 10;
    }

    .login {
        position: relative;
        margin-top: 10%;
        width: 50%;
        height: 50%;
        background-color: white;
        border-radius: 1%;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;

    }

    .header {
        display: grid;
        grid-template-columns: 1fr auto;
    }

    .titre {
        width: 80%;
    }
    
    button.close {
        position: absolute;
        top:0;
        right: 0;
        width: 10%;
        z-index: 1;
    }

    input.submit {
        background-color: rgb(220, 201, 201);
        padding: 0.55em;
        border-radius: 7%;
        margin-bottom: 20px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        transition: background-color 2s;

    }


    input.submit:hover{

        background-color: #efbf04;
        animation: shake 2s infinite;

    }

    @keyframes shake {
        0% { transform: rotate(0deg);}
        33% { transform: rotate(-5deg);}
        66% { transform: rotate(5deg);}
        100% { transform: rotate(0deg);}
    }

    span.erreur {
        color:red;
        font-size: 0.8em;
    }



</style> 
