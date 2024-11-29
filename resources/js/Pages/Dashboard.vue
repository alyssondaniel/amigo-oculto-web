<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

defineProps({
    groups: {
        type: Array,
        default: () => [],
    },
});
const form = useForm({});
const acceptInvite = (id) => {
    form.put(`groups/${id}/accept-invite`);
};
const headers = ["Nome", "Dono", ""];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Grupos que você participa
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
                                                    {{
                                                        group.user_id ===
                                                        $page.props.auth.user.id
                                                            ? "Sim"
                                                            : "Não"
                                                    }}
                                                </td>
                                                <td>
                                                    <Link
                                                        v-if="
                                                            group.accepted_invite ||
                                                            group.user_id ===
                                                                $page.props.auth
                                                                    .user.id
                                                        "
                                                        :href="`groups/${group.id}`"
                                                        class="p-2 mb-3 rounded my-auto text-white bg-blue-500 m-2"
                                                        >Ver detalhes</Link
                                                    >
                                                    <button
                                                        v-else
                                                        @click="
                                                            acceptInvite(
                                                                group.id
                                                            )
                                                        "
                                                        class="p-2 mb-3 rounded my-auto text-white bg-blue-500"
                                                    >
                                                        Aceitar convite
                                                    </button>
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
