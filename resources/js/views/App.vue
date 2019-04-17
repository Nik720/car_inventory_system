<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                    <div class="container">
                        <router-link :to="{name: 'manufacturer'}" class="navbar-brand">Inventory Store</router-link>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <router-link :to="{ name: 'manufacturer' }"
                                             class="nav-link">Add Manufacturer
                                </router-link>
                                <router-link :to="{ name: 'car-model' }"
                                             class="nav-link">Add Model
                                </router-link>
                                <router-link :to="{ name: 'inventories' }"
                                             class="nav-link">View Inventory
                                </router-link>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <main class="py-4">
                    <div class="container">
                        <router-view></router-view>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App.vue",
        data() {
            return {
            }
        },
    }
</script>

<style scoped>

</style>