<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head title="Register"/>

        <!-- Auth template. -->
        <Auth :content="content">

            <!-- Steps -->
            <div class="mt-6">
                <component
                    :is="steps[current]"
                    :current="steps[current]"
                    :form="form"
                    :social="social"
                    :activity_domains="activity_domains"
                    :counties="counties"
                    @prev="prev"
                    @next="next"
                    @google="google"
                    @success="success"
                />
            </div>
        </Auth>
    </PageLayout>
</template>

<script setup>
/** Import form vue. */
import {ref, computed, onMounted } from 'vue';

/** Import form inertia. */
import {Head, useForm} from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import Auth from '@/Components/templates/Auth.vue';
import Step1 from '@/Components/registration/Step1.vue';
import Step2 from '@/Components/registration/Step2.vue';
import Step3 from '@/Components/registration/Step3.vue';
import Step4 from '@/Components/registration/Step4.vue';
import Step5 from '@/Components/registration/Step5.vue';
import Success from '@/Components/registration/Success.vue';

/** Intialize inertia form object. */
const form = useForm({
    user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    },
    ong: {
        name: '',
        description: '',
        street_address: '',
        cif: '',
        contact_email: '',
        contact_phone: '',
        contact_person: '',
        activity_domains_ids: '',
        counties_ids: '',
        volunteer:false,
        why_volunteer: '',
        logo: '',
        statute: '',

    },
    type: '',
});

const social = useForm({
    info: ''
});

const props = defineProps({
    activity_domains: {
        type: Array,
        default: () => []
    },
    counties: {
        type: Array,
        default: () => []
    },
});

/** Current component. */
const current = ref(0);

/** Registration components steps. */
const steps = computed(() => {
    /** Intial components. */
    let components = [Step1, Step2];

    /** Check if registration is of type oragnization */
    if ('ong' === form.type) {
        components = [...components, Step3, Step4, Step5];
    }

    return [...new Set([...components, Success])];
});

/** Page content. */
const content = computed(() => {
    if (5 == current.value) {
        return {
            title: 'Felicitări!',
            description: 'Contul tău a fost creat. Lorem ipsum massa rhoncus, volutpat. Dignissim sed eget risus enim.'
        }
    }

    return {
        title: "Creează cont",
        description: "Ești deja utilizator?",
        link: {
            text: "Intră în cont",
            href: "login"
        }
    };
});

/** Previous step. */
const prev = (() => (0 < current.value) && current.value--);

/** Next step. */
const next = () => {
    if ('donor' === form.type && current.value === 1) {
        submit()
    } else if ('ong' === form.type && current.value === 4) {
        submit()
    } else if('' !== form.type) {
        current.value++
    }
}

/** Login with Google. */
const google = () => {
    console.log('google login')
}

/** Create user. */
const submit = () => {
    if (form.type==='donor')
    {
        delete form.ong;
    }
    form.post(route('register'), {
        onError: (error) => {
            /** Set active component in case of validation errors. */
            if (error['user.name'] || error['user.password'] || error['user.email'] || error['user.password_confirmation']) {
                current.value = 1
            } else if (error['ong.name'] ||  error['ong.cif'] || error['ong.description'] || error['ong.activity_domains_ids']) {
                current.value = 2
            }else if (error['ong.counties_ids'] ||  error['ong.street_address'] || error['ong.contact_person'] || error['ong.contact_phone'] || error['ong.contact_email'] || error['ong.webiste']) {
                current.value = 3
            }else if (error['ong.volunteer'] ||  error['ong.cif'] || error['ong.why_volunteer']) {
                current.value = 4
            }
        },
        onSuccess: (data) => {
            current.value = steps.value.length - 1
        }
    });
};

/** After user is registered update data. */
const success = () => {
    social.put(route('register'), {
        onError: (error) => {}
    });
}
</script>
