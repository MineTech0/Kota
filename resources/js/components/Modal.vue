<script lang="ts" setup>
import { NCard, NModal } from "naive-ui";
import { storeToRefs } from "pinia";
import useModal from "../stores/Modal";
const modal = useModal();

// convert all state properties to reactive references to be used on view
const { isOpen, view } = storeToRefs(modal);
</script>

<template>
    <n-modal :show="isOpen">
        <n-card
            :bordered="false"
            style="max-width: 90vw; margin: 1rem;"
            role="dialog"
            aria-modal="true"
        >
            <component :is="view" v-bind="modal.props"></component>

            <template #footer>
                <button
                    type="button"
                    class="btn btn-secondary"
                    @click="modal.close()"
                >
                    Sulje
                </button>
            </template>
        </n-card>
    </n-modal>
</template>
