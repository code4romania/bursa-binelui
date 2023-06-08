<template>
     <PageLayout>
        <!-- Inertia page head -->
        <Head title="Register" />

        <!-- Auth template. -->
        <Auth :content="content">

            <!-- Steps -->
            <form class="mt-6">
                <component
                    :is="steps[current]"
                    :current="steps[current]"
                    :form="form"
                    @prev="prev"
                    @next="next"
                    @google="google"
                />
            </form>
        </Auth>
    </PageLayout>
</template>

<script setup>
    /** Import form vue. */
    import { ref, computed } from 'vue';

    /** Import form inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

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
    const form = useForm({});

    /** Current component. */
    const current = ref(0);

    /** Registration components steps. */
    const steps = computed(() => {
        /** Intial components. */
        let components = [ Step1, Step2 ];

        /** Check if registration is of type oragnization */
        if ('ong' === form.type) {
            components = [ ...components, Step3, Step4, Step5 ];
        }

        return [ ...new Set([...components, Success]) ];
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
                href: "#"
            }
        };
    });

    /** Previous step. */
    const prev = (() => (0 < current.value) && current.value--);

    /** Next step. */
    const next = () => {
        if (current.value == steps.value.length -1) {
            submit();
        } else {
            current.value++
        }
    }

    /** Login with google. */
    const google = () => {
        console.log('google login')
    }

    /** Create user. */
    const submit = () => {
        form.post(route('register'), {
            onError: (error) => { console.log(error) },
            onFinish: () => {}
        });
    };
</script>
