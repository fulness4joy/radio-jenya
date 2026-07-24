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

function increase() {
    counter.value ++
}

const counter = ref(0);
const price = ref(43)

const total = computed(()=>counter.value * price.value)

const search = ref('')

watch(
    () => search.value,
    (old, param) => {
        console.log(old, param)
    }
)
</script>

<template>
    <Head title="Welcome" />
    <input type="text" placeholder="Input..." v-model="search">
    {{ search }}
    <h1>Counter: {{ counter }} * {{ price }} =  {{ total }}</h1>
    <button @click="increase">Plus 1</button>
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

                        <button class="banner-btn bg-pastel-primary 
                                        hover:bg-green-300">
                            Go
                        </button>
                    </div>

                    </div>



                    <h1 class="title text-center hidden sm:block">Channels</h1>

                    <div class="container mx-auto px-4">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            
                            <!-- <div 
                                v-for="channel in channels" 
                                :key="channel.id"
                                class="card"
                            >
                                <img src="https://picsum.photos/1200/400" class="card-img">

                                <div class="card-body">
                                    <h5 class="card-title">{{ channel.name }}</h5>
                                    <p class="card-text">{{ channel.description }}</p>
                                </div>

                                <div class="card-footer">
                                    <span>👍 {{ channel.likes }}</span>
                                    <a href="/channel/id">More</a>
                                </div>
                            </div> -->

                            <Card 
                                v-for="channel in channels" 
                                :key="channel.id"

                                :title="channel.name"
                                :description="channel.description"
                                :image="channel.image"
                            />
                            <button href="/channel" class="btn-primary">View</button>



                        </div>

                        <div class="text-center mt-8">
                            <button class="btn">Test</button>
                        </div>

                    </div>

                </div>
</template>
