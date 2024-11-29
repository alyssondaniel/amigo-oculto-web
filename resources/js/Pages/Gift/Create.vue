<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";

const nameInput = ref(null);
const props = defineProps({
    gift: {
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
    description: "",
    url: "",
});

const submit = () => (props.isUpdating ? updateGift() : addGift());
const addGift = () => form.post("/gifts");
const updateGift = () => form.put(`/gifts/${props.gift.id}`);
onMounted(() => {
    form.name = props.gift?.name ?? "";
    form.description = props.gift?.description ?? "";
    form.url = props.gift?.url ?? "";
});
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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                ></div>
                <form @submit.prevent="submit" class="mt-6 space-y-6">
                    <InputLabel for="name" value="Nome" />
                    <TextInput
                        id="name"
                        ref="nameInput"
                        v-model="form.name"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />

                    <InputLabel for="description" value="Descrição" />
                    <TextAreaInput
                        id="description"
                        ref="descriptionInput"
                        v-model="form.description"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError
                        :message="form.errors.description"
                        class="mt-2"
                    />

                    <InputLabel for="url" value="URL" />
                    <TextInput
                        id="url"
                        ref="urlInput"
                        v-model="form.url"
                        type="text"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.url" class="mt-2" />

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing"
                            >Save</PrimaryButton
                        >

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-if="form.recentlySuccessful"
                                class="text-sm text-gray-600"
                            >
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
