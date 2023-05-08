<template>
    <footer class="bg-gray-800" aria-labelledby="footer-heading">

        <div class="bg-gray-100">
            <div class="mx-auto container max-w-7xl flex items-center gap-x-6 px-6 py-4 sm:pr-3.5 lg:pl-8">

                <SvgLoader name="code4_logo"/>
                <div class="flex flex-col md:flex-row text-sm font-semibold leading-5 gap-1">
                    <p class="text-gray-700">O solutie Code for Romania.</p>
                    <a class="text-blue-500" href="#">Afla mai multe</a>
                </div>
            </div>
        </div>

        <h2 id="footer-heading" class="sr-only">Footer</h2>

        <div class="mx-auto max-w-7xl px-6 pb-8 lg:px-8 mt-10 lg:mt-16">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">

                    <div class="md:grid md:grid-cols-2 md:gap-4">

                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400">LINKURI UTILE</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Despre Bursa Binelui</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Termeni și condiții</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Politica de confidențialitate</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Contact</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="md:grid md:grid-cols-2 md:gap-4">
                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400">NAVIGHEAZA</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Înregistrează ONG</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Devino donator</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Organizații</a></li>
                                <li><a href="login" class="text-sm leading-6 text-gray-400 hover:text-white">Proiecte active</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-10 xl:mt-0">
                    <h3 class="text-sm font-semibold leading-5 text-gray-400">ABONEAZA-TE LA NEWSLETTER</h3>
                    <p class="mt-4 text-sm leading-6 text-gray-400">Cele mai noi informații, proiecte și vești de bine despre organizațiile tale preferate.</p>

                    <form class="mt-6 sm:flex items-center sm:max-w-md">
                        <Input
                            id="footer-email"
                            placeholder="Adresa de email"
                            type="email"
                            labelColor="white"
                        />

                        <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                            <PrimaryButton
                                background="turqoise-500"
                                hover="turqoise-400"
                                color="white"
                            >
                                Abonare
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 md:flex md:items-center md:justify-between mt-10 lg:mt-16">
                <div class="flex space-x-6 md:order-2">
                    <a href="#">
                        <SvgLoader name="facebook"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="instagram"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="twitter"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="github"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="drible"/>
                    </a>
                </div>
                <p class="mt-8 text-sm leading-5 text-gray-400 md:order-1 md:mt-0">&copy; {{ currentYear }} Bursa Binelui by BCR, Toate drepturile rezervate</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
    /** Import componets. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    const currentYear = new Date().getFullYear();
</script>
