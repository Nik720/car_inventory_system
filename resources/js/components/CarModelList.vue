<template>
    <div>
        <b-table
                :striped=true
                :bordered=true
                :small=true
                :hover=true
                :items="modelList.car_models"
                :fields="fields"
                v-if="modelList.car_models"
        >
            <template slot="action" slot-scope="data">
                <b-button size="sm" @click="soldModel(data.item, data.index, $event.target)" class="mr-1 btn-danger">
                    Sold
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    export default {
        name: "CarModelList.vue",
        props: ['modelList'],
        data(){
            return {
                fields: [
                    {
                        key: 'name',
                    },
                    {
                        key: 'color',
                    },
                    {
                        key: 'mf_year',
                        label: 'Manufacturing Year',
                    },
                    {
                        key: 'registration_no',
                        label: 'Registration No',
                    },
                    {
                        key: 'note',
                    },
                    'action'
                ]

            }
        },
        methods: {
            soldModel(item, index, target) {
                let manufactureId = this.modelList.id
                this.$parent.$emit('carModelSold', item,index,manufactureId)
            }
        }
    }
</script>

<style scoped>

</style>