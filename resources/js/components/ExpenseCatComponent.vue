<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Expense Categories</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="" v-if="expenseCat.length === 0">
                                    <td class="lead text-center" :colspan="3">No data found.</td>
                                </tr>
                                <tr v-for="(data, key1) in expenseCat" :key="data.id" class="m-datatable__row" @click="updateModal(data)">
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.description }}</td>
                                    <td>{{ data.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-2">
            <button class="btn btn-dark" @click="addModal()">Add Category</button>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expenseCatModal" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!updateMode">Add Category</h5>
                    <h5 class="modal-title" v-show="updateMode">Update Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="updateMode = false">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form >
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Display Name</label>
                            <div class="col-sm-8">
                                <input v-model="form.name" type="text" class="form-control" id="name" name="name" :class="{'is-invalid': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label">Display Description</label>
                            <div class="col-sm-8">
                                <input v-model="form.description" type="text" class="form-control" id="description" name="email" :class="{'is-invalid': form.errors.has('description')}">
                                <has-error :form="form" field="description"></has-error>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-show="updateMode " type="submit" class="btn btn-danger " @click="removeExpenseCat();">Delete</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" @click="updateMode = false">Cancel</button>
                    <button v-show="!updateMode" type="submit" class="btn btn-primary" @click="createExpenseCat()">Save</button>
                    <button v-show="updateMode" type="submit" class="btn btn-primary" @click="updateExpenseCat()">Update</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                updateMode: false,
                expenseCat: [],
                form: new Form({
                    id:"",
                    name: "",
                    description: ""
                }),
                count: 0
            }
        },
        props: {
            fetchUrl: { type: String, required: true }
        },
        watch: {

        },
        created() {
            this.fetchData(this.fetchUrl);
            this.$on("created", () =>{
                this.updateMode = false;
                this.fetchData(this.fetchUrl);
            });
        },
        methods: {
            fetchData(url){
                //const self = this;
                axios.get(url)
                    .then(response => {
                        //this.users = Object.assign({}, this.users, response.data);
                        this.expenseCat = response.data;
                        
                    });
            },
            createExpenseCat(){
                
                this.$Progress.start();
                this.form.post("/expensecat/create-expensecat")
                    .then(response => {
                        this.$emit("created");
                        $("#expenseCatModal").modal("hide");
                        this.$swal(
                            "Added!",
                            "New category has been added.",
                            "success"
                            );
                        
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    })
            },
            addModal(){
                this.form.reset();
                $("#expenseCatModal").modal("show");
            },
            updateModal(cat){
                this.updateMode = true;
                this.form.reset();
                $("#expenseCatModal").modal("show");
                this.form.fill(cat);
            },
            updateExpenseCat(){
                this.$Progress.start();
                this.form.post("/expensecat/update/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#expenseCatModal").modal("hide");
                        this.$swal(
                            "Updated!",
                            "User info has been added.",
                            "success"
                            );
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            },
            removeExpenseCat(){
                this.$Progress.start();
                this.form.post("/expensecat/delete/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#expenseCatModal").modal("hide");
                        this.$swal(
                            "Deleted!",
                            "User has been deleted.",
                            "success"
                            );
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            }
        }
    }
</script>
