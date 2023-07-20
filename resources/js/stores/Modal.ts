import { markRaw } from "vue";
import { defineStore } from "pinia";

export type Modal = {
    isOpen: boolean;
    view: {};
    props: {};
};

export const useModal = defineStore("modal", {
    state: (): Modal => ({
        isOpen: false,
        view: {},
        props: {},
    }),
    actions: {
        open(view: object, props) {
            this.isOpen = true;
            this.props = props;
            // using markRaw to avoid over performance as reactive is not required
            this.view = markRaw(view);
        },
        close() {
            this.isOpen = false;
            this.view = {};
        },
    },
});

export default useModal;
