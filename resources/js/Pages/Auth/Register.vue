<template>
    <AuthLayout :title="$t('create_account')">
        <!-- Steps -->
        <component
            :is="steps[current]"
            :current="steps[current]"
            :form="form"
            :social="social"
            @prev="prev"
            @next="next"
            @google="google"
            @success="success"
            :finalize="finalize"
        />
    </AuthLayout>
</template>

<script setup>
    import { ref, computed } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import Step1 from '@/Pages/Auth/Registration/Step1.vue';
    import Step2 from '@/Pages/Auth/Registration/Step2.vue';
    import Step3 from '@/Pages/Auth/Registration/Step3.vue';
    import Step4 from '@/Pages/Auth/Registration/Step4.vue';
    import Step5 from '@/Pages/Auth/Registration/Step5.vue';
    import Success from '@/Pages/Auth/Registration/Success.vue';

    /** Intialize inertia form object. */
    const form = useForm({
        user: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
        ngo: {
            name: '',
            description: '',
            street_address: '',
            cif: '',
            contact_email: '',
            contact_phone: '',
            contact_person: '',
            domains: [],
            counties: [],
            volunteer: false,
            why_volunteer: '',
            logo: '',
            statute: '',
        },
        type: '',
        terms: false,
        subscribe: false,
    });

    const social = useForm({
        referrer: '',
    });

    const props = defineProps({
        domains: {
            type: Array,
            default: () => [],
        },
        counties: {
            type: Array,
            default: () => [],
        },
        flash: Object,
    });

    /** Current component. */
    const current = ref(0);

    const usrid = ref(null);

    /** Registration components steps. */
    const steps = computed(() => {
        /** Intial components. */
        let components = [Step1, Step2];

        /** Check if registration is of type oragnization */
        if ('organization' === form.type) {
            components = [...components, Step3, Step4, Step5];
        }

        return [...new Set([...components, Success])];
    });

    /** Page content. */
    const content = computed(() => {
        if (steps.value.length - 1 == current.value) {
            return {
                title: 'Felicitări!',
                description: 'Contul tău a fost creat. Te poți loga folosind butonul ”Intră în cont” din meniul principal.',
            };
        }

        return {
            title: 'Creează cont',
            description: 'Ești deja utilizator?',
            link: {
                text: 'Intră în cont',
                href: 'login',
            },
        };
    });

    /** Previous step. */
    const prev = () => 0 < current.value && current.value--;

    /** Next step. */
    const next = () => {
        if ('user' === form.type && current.value === 1) {
            submit();
        } else if ('organization' === form.type && current.value === 4) {
            submit();
        } else if ('' !== form.type) {
            current.value++;
        }
    };

    /** Login with Google. */
    const google = () => {
        console.log('google login');
    };

    /** Create user. */
    const submit = () => {
        if (form.type === 'donor') {
            delete form.ngo;
        }

        form.post(route('register'), {
            onError: (error) => {
                /** Set active component in case of validation errors. */
                if (
                    error['terms'] ||
                    error['user.name'] ||
                    error['user.password'] ||
                    error['user.email'] ||
                    error['user.password_confirmation']
                ) {
                    current.value = 1;
                } else if (
                    error['ngo.name'] ||
                    error['ngo.cif'] ||
                    error['ngo.description'] ||
                    error['ngo.activity_domains_ids'] ||
                    error['ngo.statute'] ||
                    error['ngo.logo']
                ) {
                    current.value = 2;
                } else if (
                    error['ngo.counties_ids'] ||
                    error['ngo.street_address'] ||
                    error['ngo.contact_person'] ||
                    error['ngo.contact_phone'] ||
                    error['ngo.contact_email'] ||
                    error['ngo.website']
                ) {
                    current.value = 3;
                } else if (error['ngo.volunteer'] || error['ngo.cif'] || error['ngo.why_volunteer']) {
                    current.value = 4;
                }

                /** Repopulate array as objects. */
                if (form.type === 'organization') {
                    if (0 < form.ngo.activity_domains_ids.length) {
                        form.ngo.activity_domains_ids = props.activity_domains.filter((domain) =>
                            form.ngo.activity_domains_ids.includes(domain.id)
                        );
                    }

                    if (0 < form.ngo.counties_ids.length) {
                        form.ngo.counties_ids = props.counties.filter((county) =>
                            form.ngo.counties_ids.includes(county.id)
                        );
                    }
                }
            },
            onSuccess: (data) => {
                current.value = steps.value.length - 1;
                if (data?.props?.flash?.success_message?.usrid) {
                    usrid.value = data.props.flash.success_message.usrid;
                }
            },
        });
    };

    let finalize = ref(false);
    /** After user is registered update data. */
    const success = () => {
        if (usrid.value) {
            finalize.value = true;
            social.patch(route('user.update', { id: usrid.value }), {
                onSuccess: (data) => {
                    social.referrer = '';
                },
            });
        }
    };
</script>
