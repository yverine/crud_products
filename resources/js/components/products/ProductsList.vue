<template>
    <div>
        <div class="form-group pull-right">
            <router-link :to="{name: 'create-product'}" class="btn btn-primary">Create new product</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><p>Product List</p></div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, key) in products" :key="key" >
                        <td>{{ product.name_product }}</td>
                        <td>{{ product.description }}</td>
                        <td>  <img :src="'images/'+product.image_name" style="width:70px;height: 70px;"> </td>
                        <td>
                            <router-link :to="{name: 'edit-product', params: {id: product.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(product.id, key)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       // name: "list-products",
        data: function () {
            return {
                products: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/products')
                .then(function (resp) {
                    app.products = resp.data;
                })
                .catch(function (resp) {
                    alert("Could not load products");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/products/' + id)
                        .then(function (resp) {
                            app.products.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete product");
                        });
                }
            },
            changeStatus(index, id, status){
                var app = this;
                app.products[index].status = status;
                var editProduct = app.products[index];
                axios.patch('/api/v1/products/' + id, editProduct)
                    .then(function (resp) {
                       // app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        alert("Could not edit your product");
                    });
            }
        }
    }
</script>

<style scoped>

</style>