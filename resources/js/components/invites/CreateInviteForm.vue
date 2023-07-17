<script lang="ts" setup>
import { ref } from "vue";
import { FormRules, NButton, NFormItem, NInput, NSpace, NForm } from "naive-ui";
import useService from "@/composables/useService";
import { reactive } from "vue";
import InviteService from "@/services/InviteService";
import Message from "@/components/Message.vue";

const formValue = reactive({
    email: "",
});

const { fetch, loading, messages } = useService();

const rules: FormRules = {
    email: [
        {
            required: true,
            trigger: ["input"],
            message: "Kirjoita sähköpostiosoite",
            type: "email",
        },
    ],
};

const sendInvite = () => {
    fetch(InviteService.sendInvite(formValue.email)).then(() => {
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    });
};
</script>
<template>
    <n-form
        ref="formRef"
        inline
        :label-width="80"
        :model="formValue"
        :rules="rules"
    >
        <n-form-item class="form-input" label="Sähköposti" :path="`email`">
            <n-input :placeholder="''" v-model:value="formValue.email" />
        </n-form-item>
        <n-form-item>
            <n-button :loading="loading" type="primary" @click="sendInvite"
                >Kutsu</n-button
            >
        </n-form-item>
    </n-form>
    <Message :messages="messages" />
</template>
<style>
.n-form-item-label {
    margin-bottom: 0;
}
</style>
