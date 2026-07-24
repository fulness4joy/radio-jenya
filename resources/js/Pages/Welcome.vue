<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import { ref, computed, watch } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

const $page = usePage();
console.log($page.props.auth.user);
const access_admin = $page.props.auth.access_admin;
const channels = $page.props.channels;

let filter_channels = channels;

const search = ref('')

watch(
    () => search.value,
    (param, old) => {

        filter_channels = channels.filter((channel) =>
                                    channel.name.toLowerCase().includes(param.toLowerCase()));

        console.log(filter_channels);

        // for(let i = channels.length - 1; i >= 0; i--){

        //     console.log(channels[i].name, param);

        //     if (channels[i].name != param){

        //         channels.splice(i, 1);

        //     }

        // };
    }
)
</script>

<template>
    <Head title="Welcome" />
    <!-- <a 
    v-if = "access_admin"
    href="/admin" class="inline-block bg-black rounded-lg text-white py-4 px-2 absolute z-50 left-0 top-0">
        Admin panel
    </a> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3
                            bg-pastel-bg text-pastel-text
                            bg-pastel-primary"
                >
                    <!-- ЛОГО -->
                    <div class="nav-logo">
                        MyApp
                    </div>

                    <!-- НАВИГАЦИЯ -->
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <div v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </div>
                    </nav>
                </header>


                <div class="bg-pastel-bg text-pastel-text">

                    <div class="banner relative flex items-center justify-center text-center">

                    <!-- Фон -->
                    <img 
                        src="https://picsum.photos/1200/400" 
                        class="banner-bg"
                    >

                    <!-- Затемнение -->
                    <div class="banner-overlay"></div>

                    <!-- Контент -->
                    <div class="banner-content">
                        <h1 class="banner-title">Welcome to Best radio</h1>
                        <p class="banner-subtitle">Check the best channels</p>

                        <!-- <button class="banner-btn bg-pastel-primary 
                                        hover:bg-green-300">
                            Go
                        </button> -->
                    </div>

                    </div>




                    <h1 class="title text-center hidden sm:block">Listen radio</h1>
                    <!-- <Link :href="route('radio', channel.id)">
                        Go
                    </Link> -->

                    



                    <h1 class="title text-center hidden sm:block">Channels</h1>
                    
                    <div class="search text-center">
                        <input type="text" placeholder="Input..." v-model="search">
                        {{ search }}

                        <img src="/storage/search.png" class="w-12">
                    </div>



                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 p-4">
                        <div
                            v-for="channel in filter_channels"
                            :key="channel.id"
                            class="card"
                        >
                            <img 
                                v-if="channel.image"
                                :src="'/storage/' + channel.image"
                            />
                            <div v-else class="noimg">
                                no image
                            </div>

                            <div class="card-body">
                                <h2 class="card-title">
                                    {{ channel.name }}
                                </h2>

                                <p class="card-description">
                                    {{ channel.description }}
                                </p>

                                <Link :href="route('view', channel.id)">
                                    Go
                                </Link>

                                <Link :href="route('radio', channel.id)">
                                    Radio
                                </Link>
                            </div>
                        </div>
                    </div>

                </div>




    <footer>
        <h5>Best tracks</h5>
        Since 2026
    </footer>
</template>
