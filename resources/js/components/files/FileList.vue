<script lang="ts" setup>
import { h, computed, ref, reactive } from "vue";
import {
    NButton,
    DataTableColumns,
    NSpace,
    useDialog,
    useMessage,
} from "naive-ui";
import DataTable from "@/components/DataTable.vue";
import { FileI } from "../../types";
import useService from "@/composables/useService";
import FileService from "@/services/FileService";

const props = defineProps<{
    files: FileI[];
    token: string;
    categories: string[];
    canDelete: boolean;
}>();

const rows = ref(props.files);

const dialog = useDialog();

const message = useMessage();

const { fetch, messages, loading } = useService();

const columns = computed((): DataTableColumns<FileI> => {
    const cols: DataTableColumns<FileI> = [
        {
            title: "Nimi",
            key: "name",
        },
        {
            title: "Kategoria",
            key: "category",
            defaultFilterOptionValues: props.categories,
            filterOptions: props.categories.map((category) => ({
                label: category,
                value: category,
            })),
            filter(value, row) {
                return !!~row.category.indexOf(String(value));
            },
        },
        {
            title: "Tiedosto",
            key: "actions",
            render(row) {
                return h(
                    NButton,
                    {
                        strong: true,
                        tertiary: true,
                        size: "small",
                        onClick: () => download(row),
                        download,
                    },
                    { default: () => getLabel(row) }
                );
            },
        },
    ];

    if (props.canDelete) {
        cols.push({
            title: "",
            key: "delete",
            render: (row) => {
                if (!props.canDelete) return "";
                return h(
                    NButton,
                    {
                        strong: true,
                        secondary: true,
                        circle: true,
                        type: "error",
                        title: "Poista",
                        onClick: () => {
                            deleteExpense(row.id);
                        },
                    },
                    {
                        default: () => h("i", { class: "fas fa-trash" }),
                    }
                );
            },
        });
    }

    return cols;
});

const pagination = reactive({ pageSize: 8 });

const download = (row: FileI) => {
    //Avataan tiedosto selaimessa
    if (row.isUrl) {
        window.open(row.path, "_blank")?.focus();
    }
    //ladataan tiedosto
    const url = `files/${row.id}/token/${props.token}`;
    window.open(url, "_blank")?.focus();
};

/**
 * Get label for action button
 * @param row
 */
const getLabel = (row: FileI) => {
    return row.isUrl ? "Avaa" : "Lataa";
};

/**
 * Deletes file from server
 * @param id
 */
const deleteExpense = (id: number) => {
    if (!props.canDelete) return;
    dialog.warning({
        title: "Poista tiedosto",
        content: "Haluatko varmasti poistaa tiedoston?",
        positiveText: "Poista",
        negativeText: "Peruuta",
        onPositiveClick: () => {
            fetch(FileService.deleteFile(id))
                .then(() => {
                    message.success(messages.success);
                    rows.value = rows.value.filter((row) => row.id !== id);
                })
                .catch(() => {
                    dialog.error({
                        title: "Virhe",
                        content: messages.error,
                    });
                });
        },
    });
};
</script>

<template>
    <DataTable
        :loading="loading"
        :columns="columns"
        :data="rows"
        :pagination="pagination"
    />
</template>
