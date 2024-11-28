<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

defineProps({
    gifts: {
        type: Array,
        default: () => [],
    },
});

const headers = ["Nome", "Descrição", "URL", "Ações"];

const form = useForm({});

const deleteGift = (id) => {
    form.delete(`gifts/${id}`);
};
</script>

<template>
    <Head title="Sugestões de presentes" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Sugestões de presentes
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="p-6 text-gray-900">List of events</div>
                        <div class="my-auto px-5">
                            <Link
                                :href="route('gifts.create')"
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
                                                v-for="gift in gifts"
                                                :key="gift.id"
                                            >
                                                <td>
                                                    {{ gift.name }}
                                                </td>
                                                <td>{{ gift.description }}</td>
                                                <td>
                                                    {{ gift.url }}
                                                    <button
                                                        v-clipboard="gift.url"
                                                    >
                                                        <svg
                                                            class="w-6 h-6 text-gray-800 dark:text-dark"
                                                            aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke="currentColor"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M14 4v3a1 1 0 0 1-1 1h-3m4 10v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h2m11-3v10a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7.87a1 1 0 0 1 .24-.65l2.46-2.87a1 1 0 0 1 .76-.35H18a1 1 0 0 1 1 1Z"
                                                            />
                                                        </svg>
                                                    </button>
                                                </td>
                                                <td>
                                                    <Link
                                                        :href="`gifts/${gift.id}/edit`"
                                                        class="p-1 rounded my-auto text-white bg-yellow-500 m-2"
                                                        >Editar</Link
                                                    >
                                                    <button
                                                        @click="
                                                            deleteGift(gift.id)
                                                        "
                                                        class="p-1 rounded my-auto text-white bg-red-500"
                                                    >
                                                        Deletar
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
