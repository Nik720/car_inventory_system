<template>
    <div class="row justify-content-center">
        <alert :alert-message="alertMessage" :alert-type="alertType" v-if="isAlertActive"></alert>
        <div class="col-md-10">
            <div class="addModelForm">
                <form action="#" id="modelForm" method="POST" @submit="createModel" novalidate >
                    <div class="row form-group">
                        <label class="col-md-3">Model Name:</label>
                        <div class="col-md-9">
                            <input type="text" :class="'form-control ' + errors.modelName.type" name="modelName" id="modelName" v-model="modelName">
                            <span class="text-danger">{{  errors.modelName.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3">Manufacturer:</label>
                        <div class="col-md-9">
                            <select :class="'form-control ' + errors.manufacturer.type" name="manufacturer" id="manufacturer" v-model="manufacturer">
                                <option value="">Select Manufacturer</option>
                                <template v-if="manufacturer_list.length > 0">
                                    <option :value="item.id" v-for="(item, index) in manufacturer_list" :key="index">
                                        {{ item.name }} {{item.id }}
                                    </option>
                                </template>
                            </select>
                            <span class="text-danger">{{  errors.manufacturer.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3">Color:</label>
                        <div class="col-md-9">
                            <input type="text" :class="'form-control ' + errors.color.type" name="color" id="color" v-model="color">
                            <span class="text-danger">{{  errors.color.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3">Manufacturing Year:</label>
                        <div class="col-md-9">
                            <input type="text" :class="'form-control ' + errors.manuf_year.type" name="manuf_year" id="manuf_year" v-model="manuf_year">
                            <span class="text-danger">{{  errors.manuf_year.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3">Registration Number:</label>
                        <div class="col-md-9">
                            <input type="text" :class="'form-control ' + errors.reg_number.type" name="reg_number" id="reg_number" v-model="reg_number">
                            <span class="text-danger">{{  errors.reg_number.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3">Description:</label>
                        <div class="col-md-9">
                            <textarea :class="'form-control ' + errors.note.type" name="note" id="note" v-model="note"></textarea>
                            <span class="text-danger">{{  errors.note.message }}</span>
                        </div>
                    </div>

                    <div class="row form-group" >
                        <label class="col-md-3">Images:</label>
                        <div class="col-md-9">
                            <div class="dropbox" >
                                <input type="file" multiple
                                       :name="image"
                                       :disabled="isSaving"
                                       @change="onFileChange"
                                       accept="image/*" class="input-file" id="attachments">
                                <p v-if="isInitial">
                                    Drag your file(s) here to begin<br> or click to browse
                                </p>
                                <div v-if="attachments.length > 0">
                                    <img :src="image" v-for="image of attachments" class="img-responsive" width="100px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-3"></label>
                        <div class="col-md-9">
                            <button class="btn btn-success" type="submit" >Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Alert from './Alert'
    export default {
        name: "CarModel.vue",
        components: {
            Alert
        },
        data () {
            return {
                isEditMode: false,
                errors: {
                    modelName: {
                        type: '',
                        message: ''
                    },
                    manufacturer: {
                        type: '',
                        message: ''
                    },
                    note: {
                        type: '',
                        message: ''
                    },
                    color: {
                        type: '',
                        message: ''
                    },
                    manuf_year: {
                        type: '',
                        message: ''
                    },
                    reg_number: {
                        type: '',
                        message: ''
                    },
                    image: {
                        type: '',
                        message: ''
                    }
                },
                fieldList: ['modelName', 'manufacturer', 'color', 'manuf_year', 'reg_number', 'note','image'],
                modelName: '',
                manufacturer: '',
                note: '',
                color: '',
                manuf_year: '',
                reg_number: '',
                image: false,
                attachments: [],
                attachmented_images: [],
                alertType: '',
                alertMessage: '',
                isAlertActive: false,
                manufacturer_list: [],
                isSaving: false,
                isInitial: true,
                data: new FormData(),
            }
        },
        props: ['id'],
        created () {
            this.getManufaturerList();
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                for (let i = 0; i < files.length ; i++) {
                    this.attachmented_images.push(files[i]);
                    this.createImage(files[i]);
                }
                document.getElementById("attachments").value = [];
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.attachments.push(e.target.result);
                };
                reader.readAsDataURL(file);
            },
            prepareFields() {
                if (this.attachmented_images.length > 0) {
                    for (var i = 0; i < this.attachmented_images.length; i++) {
                        let attachment = this.attachmented_images[i];
                        this.data.append('attachments[]', attachment);
                    }
                }
            },
            createModel: function(e) {
                e.preventDefault();
                let validate = this.validateCreateModelForm();
                if(validate) {
                    this.prepareFields();
                    var config = {
                        headers: { 'Content-Type': 'multipart/form-data' } ,
                        onUploadProgress: function(progressEvent) {
                            this.percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                            this.$forceUpdate();
                        }.bind(this)
                    };

                    this.data.append('modelName', this.modelName)
                    this.data.append('note', this.note)
                    this.data.append('manufacturer', this.manufacturer)
                    this.data.append('color', this.color)
                    this.data.append('manuf_year', this.manuf_year)
                    this.data.append('reg_number', this.reg_number)
                    console.log(this.data);

                    axios.post('api/car-model', this.data, config).then(res => {
                        if(res.data.status == 'error') {
                            let errorMsg = res.data.message
                            for (let key in errorMsg) {
                                if (errorMsg.hasOwnProperty(key)) {
                                    this.errors[key].type = 'is-invalid'
                                    this.errors[key].message = errorMsg[key][0]
                                }
                            }
                            return false;
                        }
                        if(res.status) {
                            let successMsg = res.data.message
                            this.alertType = 'success'
                            this.alertMessage = successMsg
                            this.isAlertActive = true
                            setTimeout(() => {
                                this.alertType = ''
                                this.alertMessage = ''
                                this.isAlertActive = false
                            },5000)
                            this.resetForm();
                        }
                    })
                }
            },
            validateCreateModelForm() {
                let that = this;
                let isError = false;
                that.fieldList.map(field => {
                    if((!['new_arrival'].includes(field))) {
                        if(that[field] == "" && field != 'image') {
                            that.errors[field].type = 'is-invalid'
                            that.errors[field].message = 'Field should not be blank.'
                            isError = true;
                        } else {
                            that.errors[field].type = ''
                            that.errors[field].message = ''
                        }
                    }
                });
                return (isError) ? false : true;
            },
            resetForm() {
                this.modelName = ""
                this.note = ""
                this.color = ""
                this.manufacturer = ""
                this.manuf_year = ""
                this.reg_number = ""
                this.image = ""
                this.data = new FormData()
                this.attachments = []
                this.attachmented_images = []
                document.getElementById("image").value = ""
            },
            getManufaturerList() {
                axios.get('api/manufacturer-list').then(response => {
                    if (response.status) {
                        this.manufacturer_list = response.data.data
                    }
                }).catch(error => {
                    alert("Server Error")
                });
            }
        }
    }
</script>

<style scoped>
    .dropbox {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: lightcyan;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
    }
    .input-file {
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .dropbox:hover {
        background: lightblue;
    }
    .dropbox p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 0;
    }
</style>