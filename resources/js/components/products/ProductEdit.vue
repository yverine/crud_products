<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><p>Edit product</p></div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
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
                            <div class="col-md-3" v-if="product.image_name && load">
                                 <img :src="'images/'+product.image_name" class="img-responsive" height="70" width="90">
                            </div>
                            <div class="col-md-3" v-if="product.image_name && !load">
                                <img :src="product.image_name" class="img-responsive" height="70" width="90">
                            </div>
                            <div class="col-md-6">
                                <input type="file" v-on:change="onImageChange" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      //  name: "edit-product",
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.productId = id;
            axios.get('/api/v1/products/' + id)
                .then(function (resp) {
                    app.product = resp.data;
                })
                .catch(function () {
                    alert("Could not load your product")
                });
        },
        data: function () {
            return {
                productId: null,
                product: {
                    name_product: '',
                    description: '',
                    image_name: ''
                },
                load: true
            }
        },
        methods: {
            saveForm() {
                var app = this;
                var newProduct = app.product;
                axios.patch('/api/v1/products/' + app.productId, newProduct)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your product");
                    });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.load = false
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