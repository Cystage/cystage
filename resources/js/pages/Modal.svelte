<script lang="ts">
    let { showModal = $bindable() } = $props();
    function disable_modal() {
        showModal=!showModal;
        console.log(showModal);
    }
</script>

<div class="overlay">
    <center>

    <div class="modal">
        <div class="header">

            <h1 class="titre">Poster votre offre de stage </h1>
            <button class="close" onclick={disable_modal}><p>❌</p></button>
        </div>

        <br><br>
        <form action="?">
            <label for="Nom de l'offre">Nom de l'offre
                <br>
                <input type="text" name="text" id="">
            </label>
            <br>
            <label for="Description">Description de l'offre
                <br>
                <input type="text" name="text" id="">
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

    .modal {
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



</style> 
