<template>
    <div>
        <button
            @click="open = !open"
            :class="triggerModalClasses"
        >
            {{ triggerModalText }}
        </button>

        <Teleport to="body">
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-50" @close="open = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                     enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                     leave-to="opacity-0">
                        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"/>
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                             enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                             enter-to="opacity-100 translate-y-0 sm:scale-100"
                                             leave="ease-in duration-200"
                                             leave-from="opacity-100 translate-y-0 sm:scale-100"
                                             leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                    <div>
                                        <div
                                            class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                                            <CheckIcon class="w-6 h-6 text-green-500" aria-hidden="true"/>
                                        </div>

                                        <div class="mt-3 text-center sm:mt-5">
                                            <DialogTitle as="h3"
                                                         class="text-base font-semibold leading-6 text-gray-900">
                                                {{ title }}
                                            </DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    {{ body }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">

                                        <button type="button"
                                                class="inline-flex justify-center w-full px-3 py-2 mt-3 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0"
                                                @click="open = false">
                                            {{ cancelModalText }}
                                        </button>

                                        <button
                                            @click="action"
                                            type="button"
                                            class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-white rounded-md shadow-sm bg-turqoise-500 hover:bg-turqoise-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-turqoise-500 sm:col-start-2"
                                        >
                                            {{ actionModalText }}
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </Teleport>
    </div>
</template>

<script setup>
/** Import from vue. */
import {ref} from 'vue';

/** Import from inertia */
import {useForm} from '@inertiajs/vue3';

/** Import plugins. */
;
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue';
import {CheckIcon} from '@heroicons/vue/24/outline';

/** Component props. */
const props = defineProps({
    triggerModalText: String,
    cancelModalText: String,
    actionModalText: String,
    triggerModalClasses: String,
    title: String,
    body: String,
    actionRoute: String,
    actionType: {
        String,
        default: 'delete'
    },
    id: [String, Number],
    data: [Object, Array]
});

/** Local state. */
const open = ref(false);

/** Delete action. */
const action = () => {
    /** Initialize inertia from Object. */

    if (props.actionType === 'approve') {
        const form = useForm({});
       approveForm(form)
        return;
    }
    if (props.actionType==='reject'){
        const form = useForm({});
        rejectForm(form)
        return;
    }
    if (props.actionType === 'deleteVolunteer') {
        const form = useForm({
            project_ids: []
        });
        form.project_ids = props.data.map(project => project.id);
        detachVolunteerFromProjects(form)
        return;
    }
    const form = useForm({});
    form.delete(props.actionRoute, {
        onSuccess: () => {
            open.value = false
        },
        onError: () => {
            open.value = true
        },
        onFinish: () => {
            open.value = false
        }
    });
};
const approveForm= (form)=>{
    form.post(props.actionRoute, {
        onSuccess: () => {
            open.value = false
        },
        onError: () => {
            open.value = true
        },
        onFinish: () => {
            open.value = false
        }
    });
}
const rejectForm= (form)=>{
    form.post(props.actionRoute, {
        onSuccess: () => {
            open.value = false
        },
        onError: () => {
            open.value = true
        },
        onFinish: () => {
            open.value = false
        }
    });
}

const detachVolunteerFromProjects=(form) =>{
    form.post(props.actionRoute, {
        onSuccess: () => {
            open.value = false
        },
        onError: () => {
            open.value = true
        },
        onFinish: () => {
            open.value = false
        }
    });
}
</script>
