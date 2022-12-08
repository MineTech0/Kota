<script lang="ts" setup>
import axios from "axios";
import {
    NForm,
    NFormItem,
    NInput,
    NSelect,
    NUpload,
    NButton,
    NSpace,
    NAlert,
    FormRules,
    FormItemRule,
    FormInst,
    FormValidationError,
    NSpin,
} from "naive-ui";
import { computed, reactive, ref } from "vue";
import { z } from "zod";
import Panel from "../Panel.vue";

const props = defineProps<{
    categories: string[];
}>();

const formRef = ref<FormInst | null>(null);
const loading = ref(false);

const formData = reactive({
    name: "",
    link: "",
    file: null,
    type: null,
    category: props.categories[0],
});
const messages = reactive({
    error: null,
    success: null,
});

const categoryOptions = computed(() =>
    props.categories.map((v) => ({
        label: v,
        value: v,
    }))
);

const typeOptions = computed(() =>
    ["Tiedosto", "Linkki"].map((v) => ({
        label: v,
        value: v,
    }))
);

const handleSubmit = (e: MouseEvent) => {
    e.preventDefault();
    formRef.value?.validate(
        (errors: Array<FormValidationError> | undefined) => {
            if (!errors) {
                const requestData = new FormData();
                if (formData) {
                    Object.keys(formData).forEach((key) => {
                        requestData.append(key, formData[key]);
                    });
                }
                loading.value = true;
                axios
                    .post("/files", requestData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        messages.success = response.data.message;
                        messages.error = null;
                        loading.value = false;
                        setTimeout(() => {
                            location.assign("/files");
                        }, 3000);
                    })
                    .catch((error) => {
                        messages.error = error.response.data.message;
                        messages.success = null;
                        loading.value = false;
                    });
            } else {
                console.log(errors);
            }
        }
    );
};

const handleChange = (data) => {
    formData.file = data.file.file;
};

const rules: FormRules = {
    name: [
        {
            required: true,
            trigger: ["input", "blur"],
            message: "Nimi vaaditaan",
        },
    ],
    category: [
        {
            required: true,
            trigger: ["input", "blur"],
            message: "Kategoria vaaditaan",
        },
    ],
    type: [
        {
            required: true,
            trigger: ["input", "blur"],
            message: "Tyyppi pitää valita",
        },
    ],
    link: [
        {
            validator(_rule: FormItemRule, value: string) {
                if (formData.type == "Linkki" && value.length === 0) {
                    return new Error("Osoite vaaditaan");
                }
                const validationResult = z.string().url().safeParse(value);
                if (!validationResult.success) {
                    return new Error("Pitää olla oikea osoite");
                }
                return true;
            },
            trigger: ["input", "blur"],
        },
    ],
    file: [
        {
            validator() {
                if (formData.type == "Tiedosto" && !formData.file) {
                    return new Error("Tiedosto vaaditaan");
                }
                return true;
            },
        },
    ],
};
</script>

<template>
    <Panel header="Uusi tiedosto">
        <n-space vertical>
            <n-form
                ref="formRef"
                :label-width="160"
                :model="formData"
                :style="{
                    maxWidth: '640px',
                }"
                :rules="rules"
            >
                <n-form-item label="Nimi" path="name">
                    <n-input v-model:value="formData.name" placeholder="Nimi" />
                </n-form-item>
                <n-form-item label="Kategoria" path="category">
                    <n-select
                        v-model:value="formData.category"
                        placeholder="Kategoria"
                        :options="categoryOptions"
                    />
                </n-form-item>
                <n-form-item label="Tyyppi" path="type">
                    <n-select
                        v-model:value="formData.type"
                        placeholder="Tyyppi"
                        :options="typeOptions"
                    />
                </n-form-item>
                <n-form-item
                    v-show="formData.type === 'Tiedosto'"
                    label="Tiedosto"
                    path="file"
                >
                    <n-upload
                        :multiple="false"
                        :default-upload="false"
                        @change="handleChange"
                        :max="1"
                    >
                        <n-button>Lataa tiedosto</n-button>
                    </n-upload>
                </n-form-item>
                <n-form-item
                    v-if="formData.type === 'Linkki'"
                    label="Linkki"
                    path="link"
                >
                    <n-input
                        v-model:value="formData.link"
                        placeholder="https://"
                    />
                </n-form-item>
                <n-form-item>
                    <n-spin v-if="loading" size="small" />
                    <n-button v-else @click="handleSubmit">Lähetä</n-button>
                </n-form-item>
            </n-form>
            <n-alert v-if="messages.success" title="Onnistui" type="success">
                Tiedoston lisääminen onnistui
            </n-alert>
            <n-alert v-if="messages.error" title="Virhe" type="error">
                {{ messages.error }}
            </n-alert>
        </n-space>
    </Panel>
</template>
