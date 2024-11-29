<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const nameInput = ref(null);
const props = defineProps({
    group: {
        type: Object,
        default: null,
    },
    isUpdating: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    name: "",
});

const submit = () => (props.isUpdating ? updateGift() : addGift());
const addGift = () => form.post("/groups");
const updateGift = () => form.put(`/groups/${props.group.id}`);
onMounted(() => {
    form.name = props.group?.name ?? "";
});
</script>

<template>
    <Head title="Novo Grupo" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Novo grupo
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col p-6">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 sm:px-6 lg:px-8"
                            >
                                <div class="overflow-hidden">
                                    <form
                                        @submit.prevent="submit"
                                        class="mt-6 space-y-6"
                                    >
                                        <InputLabel for="name" value="Nome" />
                                        <TextInput
                                            id="name"
                                            ref="nameInput"
                                            v-model="form.name"
                                            type="text"
                                            class="mt-1 block w-full"
                                        />
                                        <InputError
                                            :message="form.errors.name"
                                            class="mt-2"
                                        />

                                        <div class="flex items-center gap-4">
                                            <PrimaryButton
                                                :disabled="form.processing"
                                                >Save</PrimaryButton
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
                                                    Saved.
                                                </p>
                                            </Transition>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
