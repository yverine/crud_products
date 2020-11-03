<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><p>Create</p> new product</div>
            <div class="panel-body">
                <form>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Product name</label>
                            <input type="text" v-model="product.name_product" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Product description</label>
                            <input type="text" v-model="product.description" class="form-control">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3" v-if="product.image_name">
                                <img :src="product.image_name" class="img-responsive" height="70" width="90">
                            </div>
                            <div class="col-md-6">
                                <input type="file" v-on:change="onImageChange" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success btn-block" @click="saveForm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      //  name: "create-product",

        data: function () {
            return {
                product: {
                    name_product: '',
                    description: '',
                    image_name: ''
                },

            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newProduct = app.product;
                axios.post('/api/v1/products', newProduct)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        alert("Could not create your product");
                    });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.product.image_name = e.target.result;
                };
                reader.readAsDataURL(file);
            },
        }
    }
</script>

<style scoped>

</style>