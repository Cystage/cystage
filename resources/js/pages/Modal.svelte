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
        <p>Poster votre offre de stage </p>
        <button onclick={disable_modal}><p>❌</p></button>
        <br><br>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid ipsa tempora quidem consequatur sit nesciunt consequuntur illum reiciendis dolorum? Autem incidunt, voluptas vel quaerat ad soluta! Id sequi commodi unde voluptatum minima. Et quaerat nihil omnis repellat earum cumque minima fugit ab saepe rerum magni deserunt commodi modi, nesciunt unde quidem nam voluptas ex corporis sit porro mollitia distinctio ratione aperiam. Cupiditate animi, ullam, expedita deserunt impedit ipsum aliquam accusamus quos omnis suscipit sapiente officia beatae. Distinctio nulla consequatur modi, illo itaque suscipit, repellendus doloribus aut culpa autem reiciendis sint illum unde voluptatibus velit rerum sed quae, ea fugiat praesentium!</p>
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
        margin-top: 10%;
        width: 50%;
        height: 50%;
        background-color: white;
        border-radius: 1%;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;

    }


</style> 
