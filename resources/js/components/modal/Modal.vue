<template>
    <div>
        <div class="modal" v-if="visible">
            <article :style="modalSize ? 'width:' + modalSize + 'px !important' : '500px'" class="modal-container">
                <div class="close-btn">
                    <button class="icon-button" @click="close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z" />
                            <path fill="currentColor"
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </div>

                <div class="modal-container-header">
                    <slot name="header">
                        <h2 class="modal-container-title">Default Header</h2>
                    </slot>
                </div>
                <section class="modal-container-body">
                    <slot name="body">
                        <p>Default Body</p>
                    </slot>
                </section>
                <!-- <footer class="modal-container-footer">
                    <slot name="footer">
                        <button class="button is-ghost" @click="close">Decline</button>
                        <button class="button is-primary" @click="close">Accept</button>
                    </slot>
                </footer> -->
            </article>
        </div>
    </div>
</template>

<script setup>

import { ref, defineProps, defineEmits, watch } from 'vue';
const emit = defineEmits(['close']);

const props = defineProps({
    modalSize: {
        type: String,
        default: '500px', // Default width
    },
    show: {
        type: Boolean,
        default: false,
    }
});

const visible = ref(props.show);
const close = () => {
    visible.value = false;
    props.show = false;
    emit('close', false);
};

watch(() => props.show, (newVal) => {
    visible.value = newVal;
});


</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.5);
}

.modal-container {
    max-height: 90vh;
    max-width: 100%;
    background-color: #fff;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.25);
}

.modal-container-header {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 32px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    letter-spacing: -1.6px;
}

/* .modal-container-title {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 32px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
    letter-spacing: -1.6px;
} */

.modal-container-body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.modal-container-footer {
    padding: 16px;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.icon-button {
    background: none;
    border: none;
    cursor: pointer;

}

.close-btn {
    display: flex;
    justify-content: end;
    margin: 20px;
}
</style>
