<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import moment from "moment";
import pt from "moment/dist/locale/pt";

moment.updateLocale("pt", pt);

defineProps({
    groups: {
        type: Array,
        default: () => [],
    },
});

const headers = ["Nome", "Removido", "Ações"];

const form = useForm({});

const deleteGroup = (id) => {
    form.delete(`groups/${id}`);
};
const restoreGroup = (id) => {
    form.get(`groups/${id}/restore`);
};
</script>

<template>
    <Head title="Grupos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Grupos
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="p-6 text-gray-900">Lista de grupos</div>
                        <div class="my-auto px-5">
                            <Link
                                :href="route('groups.create')"
                                class="p-3 rounded my-auto text-white bg-blue-500"
                            >
                                Criar
                            </Link>
                        </div>
                    </div>
                    <div class="flex flex-col p-6">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 sm:px-6 lg:px-8"
                            >
                                <div class="overflow-hidden">
                                    <table
                                        class="min-w-full border rounded text-left font-light text-surface"
                                    >
                                        <thead
                                            class="border-b border-neutral-200 font-medium dark:border-white/10"
                                        >
                                            <tr>
                                                <th
                                                    v-for="header in headers"
                                                    :key="header"
                                                    scope="col"
                                                    class="p-1"
                                                >
                                                    {{ header }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="group in groups"
                                                :key="group.id"
                                            >
                                                <td>
                                                    {{ group.name }}
                                                </td>
                                                <td>
                                                    <span
                                                        v-if="group.deleted_at"
                                                    >
                                                        {{
                                                            moment(
                                                                group.deleted_at
                                                            )
                                                                .locale("pt")
                                                                .format("LLL")
                                                        }}
                                                    </span>
                                                    <span v-else>-</span>
                                                </td>
                                                <td>
                                                    <Link
                                                        :href="`groups/${group.id}/edit`"
                                                        class="p-1 rounded my-auto text-white bg-yellow-500 m-2"
                                                        >Editar</Link
                                                    >
                                                    <button
                                                        @click="
                                                            deleteGroup(
                                                                group.id
                                                            )
                                                        "
                                                        class="p-1 rounded my-auto text-white bg-red-500 m-2"
                                                    >
                                                        Deletar
                                                    </button>
                                                    <button
                                                        v-if="group.deleted_at"
                                                        @click="
                                                            restoreGroup(
                                                                group.id
                                                            )
                                                        "
                                                        class="p-1 rounded my-auto text-white bg-green-500"
                                                    >
                                                        Restaurar
                                                    </button>
                                                    <Link
                                                        :href="`groups/${group.id}`"
                                                        class="p-1 rounded my-auto text-white bg-blue-500 m-2"
                                                        >Ver detalhes</Link
                                                    >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
