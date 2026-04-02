<script lang="ts">
    let { offre = $bindable() }= $props();

</script>
    <div>

        <h1>{offre.nom}<br></h1>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h2>{offre.description}</h2>
    </div>

    <style>
        h1 {
            font-size: 2em;
        }
        div {
            border: 1px solid black;
            border-radius: 1%;
            margin-left: 20%;
            margin-right: 20%;
        }
    </style>