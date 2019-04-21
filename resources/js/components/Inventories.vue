<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Inventories List
                    </div>
                    <div class="card-body">
                        <alert :alert-message="alertMessage" :alert-type="alertType" v-if="isAlertActive"></alert>
                        <b-modal small size="lg"  centered  ref="my-modal" hide-footer title="Car Modal Lists" @carModelSold="sellCarModel">
                            <div class="d-block text-center">
                                <car-model-list :model-list="modelList"></car-model-list>
                            </div>
                            <div class="d-block text-right">
                                <b-button class="mt-3" variant="outline-danger" @click="hideModal">Close</b-button>
                            </div>
                        </b-modal>
                        <div v-show="isProcessing" class="loader">Loading...</div>
                        <template>
                            <div class="table-responsive"  v-if="carModels.total > 0">
                                <b-table striped bordered small hover :select-mode="selectMode" :items="carModels.data" :fields="fields" @row-clicked="showCarModels">
                                    <template slot="SN" slot-scope="data">
                                        {{ data.item.id }}
                                    </template>

                                    <template slot="Model Name" slot-scope="data">
                                        {{ data.item.car_models.length ? data.item.car_models[0]['name'] : '' }}
                                    </template>

                                    <template slot="Count" slot-scope="data">
                                        {{ data.item.car_models.length }}
                                    </template>
                                </b-table>
                            </div>

                            <pagination :data="carModels" @pagination-change-page="loadCarModels"></pagination>

                            <div v-if="carModelsNotAvailable">
                                <H4>You Don't have Models Yet, Click on <router-link :to="{ name: 'car-model' }">Add Model
                                </router-link> Link to add car model</H4>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .loader{
        width: 100%;
        height: 100%;
        display: block;
        position: fixed;
        background: #0000000a;
        top: 0;
        left: 0;
        text-align: center;
        font-size: 15px;
        z-index: 100;
    }
</style>

<script>
    import Pagination from 'laravel-vue-pagination'
    import CarModelList from './CarModelList'
    import Alert from './Alert'
    export default {
        components: {
            Pagination,
            CarModelList,
            Alert
        },
        data(){
            return {
                alertType: '',
                alertMessage: '',
                isAlertActive: false,
                resetTimeLimit: 5000,
                carModels : {},
                isProcessing: false,
                carModelsNotAvailable: false,
                modelList: {},
                modelListShow: false,
                fields: [
                    'SN',
                    { key: 'name', label: 'Manufacturer Name' },
                    'Model Name',
                    'Count'
                ],
                selectMode: 'single'
            }
        },
        created(){
            this.loadCarModels()
        },
        methods: {
            loadCarModels(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.isProcessing = true;
                axios.get("api/car-model-list/?page=" + page).then(response => {
                    this.carModels = response.data
                    if(response.data.total <= 0) {
                        this.carModelsNotAvailable = true;
                    }
                    this.isProcessing = false
                }).catch(error => {
                    this.showAlert(error.response.data.error.manufacturerName[0], 'danger')
                });
            },
            showCarModels(item) {
                this.modelList = item
                this.modelListShow = true
                this.$refs['my-modal'].show()
            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            sellCarModel(item, index,manufactureId) {
                this.isProcessing = true;
                axios.delete("api/car-model/"+item.id).then(response => {
                    if(response.status) {
                        this.alertType = 'success',
                        this.alertMessage = "Model Sold Successfully.",
                        this.isAlertActive = true
                        setTimeout(() => {
                            this.alertType = '',
                            this.alertMessage = '',
                            this.isAlertActive = false
                        },this.resetTimeLimit);

                        this.carModels.data.filter(mdl => mdl.id == manufactureId)[0].car_models.splice(index,1)
                    }
                    this.isProcessing = false
                })
            }

        }
    }
</script>