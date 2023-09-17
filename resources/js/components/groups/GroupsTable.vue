<script lang="ts" setup>
import DataTable from "@/components/DataTable.vue";
import { Group, User } from "@/types";
import { DataTableColumns, NButton, NTag } from "naive-ui";
import { computed } from "vue";
import { h } from "vue";

const props = defineProps<{
    groups: Group[];
    canEdit: boolean;
    ageGroups: string[];
}>();

const columns = computed((): DataTableColumns<Group> => {
    let cols: DataTableColumns<Group>  = [
        {
            title: "Nimi",
            key: "name",
            minWidth: 120,
            sorter: "default",
        },
        {
            title: "Johtajat",
            key: "leaders",
            minWidth: 120,
            sorter: "default",
            render: (row) => {
                if (row.leaders) {
                    const tags = row.leaders.map((tagKey) => {
                        return h(
                            NTag,
                            {
                                style: {
                                    marginRight: "6px",
                                    marginTop: "6px",
                                },
                                type: "info",
                                bordered: false,
                            },
                            {
                                default: () => tagKey.name,
                            }
                        );
                    });
                    return tags;
                }
            },
        },
        {
            title: "Kokouspäivä",
            key: "meeting_day",
            minWidth: 120,
            sorter: "default",
        },
        {
            title: "Kokousaika",
            key: "meeting_start",
            minWidth: 120,
            sorter: "default",
            render: (row) => {
                return `${row.meeting_start} - ${row.meeting_end}`;
            },
        },
        {
            title: "Kokoontuu",
            key: "repeat",
            minWidth: 120,
            sorter: "default",
        },
        {
            title: "Ikäkausi",
            key: "age",
            minWidth: 120,
            sorter: (a, b) => {
                const aIndex = props.ageGroups.indexOf(a.age);
                const bIndex = props.ageGroups.indexOf(b.age);
                return aIndex - bIndex;
            },
        },
    ];
    if (props.canEdit) {
        cols.push({
            title: "",
            key: "actions",
            render(row) {
                if (!props.canEdit) return null;
                return h(
                    NButton,
                    {
                        strong: true,
                        tertiary: true,
                        size: "small",
                        onClick: () => {
                            window.location.href = `/groups/${row.id}/edit`;
                        },
                    },
                    { default: () => "Muokkaa" }
                );
            },
        });
    }
    return cols;
});
</script>
<template>
    <DataTable
        :single-line="false"
        :columns="columns"
        :data="groups"
        :row-key="(row) => row.id"
    />
</template>
<style scoped></style>
