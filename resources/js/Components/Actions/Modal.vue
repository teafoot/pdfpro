<script setup>

</script>

<template>
    <!-- You can open the modal using ID.showModal() method -->
    <button class="btn" onclick="modal.showModal()">open modal</button>
    <dialog id="modal" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg">Hello!</h3>
            <p class="py-4">Press ESC key or click on ✕ button to close</p>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</template>

<style scoped>

</style>
