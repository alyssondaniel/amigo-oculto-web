<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import moment from "moment";
import pt from "moment/dist/locale/pt";
import { onMounted, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

moment.updateLocale("pt", pt);

const nameInput = ref(null);
const props = defineProps({
    group: { type: Object },
    users: {
        type: Array,
        default: () => [],
    },
    drawLots: {
        type: Object,
        default: () => null,
    },
});

const headers = ["Nome"];
const headersDrawLots = ["Sorteados"];
const form = useForm({
    email: "",
});
const formDrawLots = useForm({});
const submit = () => form.put(`/groups/${props.group?.id}/invite`);
const drawLots = () =>
    formDrawLots.post(`/groups/${props.group?.id}/run-draw-lots`);
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
                    <div class="flex flex-col p-6">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 sm:px-6 lg:px-8"
                                v-if="props.group?.id"
                            >
                                <div class="overflow-hidden">
                                    <div class="flex justify-between">
                                        <div class="p-6 text-gray-900">
                                            Lista de grupos
                                        </div>
                                        <div
                                            class="my-auto px-5"
                                            v-if="
                                                $page.props.auth.user.id ===
                                                props.group?.user_id
                                            "
                                        >
                                            <Link
                                                :href="route('groups.create')"
                                                class="p-3 rounded my-auto text-white bg-blue-500"
                                            >
                                                Criar
                                            </Link>
                                        </div>
                                    </div>
                                    <div class="flex flex-col p-6">
                                        <div
                                            class="overflow-x-auto sm:-mx-6 lg:-mx-8"
                                        >
                                            <div
                                                class="inline-block min-w-full py-2 sm:px-6 lg:px-8"
                                            >
                                                <div class="overflow-hidden">
                                                    <p>
                                                        Nome do grupo:
                                                        <b>{{ group.name }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="overflow-hidden"
                                    v-if="
                                        $page.props.auth.user.id ===
                                        props.group?.user_id
                                    "
                                >
                                    <form
                                        @submit.prevent="submit"
                                        class="mt-6 space-y-6"
                                    >
                                        <InputLabel
                                            for="email"
                                            value="E-mail"
                                        />
                                        <TextInput
                                            id="email"
                                            ref="emailInput"
                                            v-model="form.email"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError
                                            :message="form.errors.email"
                                        />

                                        <div class="flex items-center gap-4">
                                            <PrimaryButton
                                                :disabled="form.processing"
                                                >Enviar convite</PrimaryButton
                                            >

                                            <Transition
                                                enter-active-class="transition ease-in-out"
                                                enter-from-class="opacity-0"
                                                leave-active-class="transition ease-in-out"
                                                leave-to-class="opacity-0"
                                            >
                                                <p
                                                    v-if="
                                                        form.recentlySuccessful
                                                    "
                                                    class="text-sm text-gray-600"
                                                >
                                                    Enviado convite.
                                                </p>
                                            </Transition>
                                        </div>
                                    </form>
                                </div>
                                <div class="overflow-hidden mt-4">
                                    <h2>Lista de participantes</h2>
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
                                                v-for="user in users"
                                                :key="user.id"
                                            >
                                                <td>
                                                    {{ user.name }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button
                                        @click="drawLots()"
                                        class="p-1 rounded my-auto text-white bg-green-900 mt-2"
                                    >
                                        Sortear
                                    </button>
                                    <table
                                        class="min-w-full border rounded text-left font-light text-surface mt-4"
                                    >
                                        <thead
                                            class="border-b border-neutral-200 font-medium dark:border-white/10"
                                        >
                                            <tr>
                                                <th
                                                    v-for="header in headersDrawLots"
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
                                                v-for="(
                                                    key, value
                                                ) in props.drawLots"
                                                :key="key"
                                            >
                                                <td>
                                                    <span class="font-bold">{{
                                                        value
                                                    }}</span>
                                                    escolheu
                                                    <span class="font-bold">{{
                                                        key
                                                    }}</span>
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
