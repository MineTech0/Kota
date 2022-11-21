<script setup lang="ts">
import Panel from "../Panel.vue";

const props = defineProps<{
    equipment: any[]
}>();

defineEmits(['addEquipment'])

</script>
<template>
    <Panel header="Varusteet" id="equipment">
        <div class="table-responsive">
            <table
                id="loanTable"
                class="display table table-striped table-bordered table-hover"
                cellspacing="0"
                width="100%"
            >
                <thead>
                    <tr>
                        <th>Nimi</th>
                        <th>Sarjanumero</th>
                        <th>Kunto</th>
                        <th>Määrä</th>
                        <th>Laina-aika</th>
                        <th>Tiedot</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in props.equipment">
                        <td>{{ item.name }}</td>
                        <td>{{ item.serial }}</td>
                        <td>{{ item.form }}</td>
                        <td>
                            <span
                                v-if="item.quantity === 0"
                                class="badge badge-info"
                                >Lainassa</span
                            >
                            <template v-else>
                                {{ item.quantity }}
                            </template>
                        </td>
                        <td>
                            <template v-if="item.loan_time === 0">
                                Ei rajoitettu
                            </template>
                            <template v-else>
                                {{ item.loan_time }}
                            </template>
                        </td>
                        <td>{{ item.info }}</td>
                        <td>
                            <button
                                class="btn btn-primary btn-sm addBtn"
                                :disabled="item.quantity === 0 || item.loaned"
                                @click="$emit('addEquipment', item.id)"
                            >
                                Lainaa
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Panel>
</template>
