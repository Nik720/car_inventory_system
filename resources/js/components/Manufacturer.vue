<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <alert :alert-message="alertMessage" :alert-type="alertType" v-if="isAlertActive"></alert>

                <div class="form-group row">
                    <label for="manuf_name" class="col-md-4 col-form-label text-md-right">Manufacturer Name</label>
                    <div class="col-md-6">
                        <input id="manuf_name" type="text" class="form-control" v-model="manufacturerName">
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary" @click="handleSubmit">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from './Alert'
    export default {
        name: "Manufacturer.vue",
        components: {
            Alert
        },
        data() {
            return {
                manufacturerName: "",
                alertType: '',
                alertMessage: '',
                isAlertActive: false,
                resetTimeLimit: 5000
            }
        },
        methods: {
            handleSubmit(e) {
                if (this.manufacturerName != "") {
                    let manufacturerName = this.manufacturerName
                    axios.post('api/manufacturer', { manufacturerName }).then(response => {
                        if (response.status) {
                            this.manufacturerName = "";
                            this.showAlert('Manufacturer Added!', 'success')
                        }
                    }).catch(error => {
                        this.showAlert(error.response.data.error.manufacturerName[0], 'danger')
                    });
                } else {
                    this.showAlert('Please Fill Manufacturer name.', 'danger')
                }
            },
            showAlert(msg, type) {
                this.alertType = type,
                this.alertMessage = msg,
                this.isAlertActive = true
                setInterval(() => {
                    this.alertType = '',
                    this.alertMessage = '',
                    this.isAlertActive = false
                },this.resetTimeLimit);
            }
        }

    }
</script>