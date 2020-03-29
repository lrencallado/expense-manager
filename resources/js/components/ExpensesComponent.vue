<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Expenses</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Expense Category</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Entry Date</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
    
                                <tr class="" v-if="expenses.length === 0">
                                    <td class="lead text-center" :colspan="4">No data found.</td>
                                </tr>
                                <tr v-for="(data, key1) in expenses" :key="data.id" class="m-datatable__row" @click="updateModal(data)">
                                    <td>{{ data.category_name }}</td>
                                    <td>{{ data.amount }}</td>
                                    <td>{{ data.entry_date }}</td>
                                    <td>{{ data.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-2">
            <button class="btn btn-dark" @click="addModal()">Add Expense</button>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="expenseModal" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!updateMode">Add Expense</h5>
                    <h5 class="modal-title" v-show="updateMode">Update Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="updateMode = false">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form >
                        <div class="form-group row">
                            <label for="category_id" class="col-sm-4 col-form-label">Expense Category</label>
                            <div class="col-sm-8">
                                <select v-model="form.category_id" class="form-control" id="category_id" name="category_id">
                                    <option v-for="(item, index) in $attrs.expensecategory" v-bind:value="index">{{ item }}</option>
                                </select>
                                <has-error :form="form" field="category_id"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label">Amount</label>
                            <div class="col-sm-8">
                                <input v-model="form.amount" type="number" step="0.01" min="0.00" class="form-control" id="amount" name="amount" :class="{'is-invalid': form.errors.has('amount')}">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="entry_date" class="col-sm-4 col-form-label">Entry Date</label>
                            <div class="col-sm-8">
                                <input v-model="form.entry_date" type="date" class="form-control" id="entry_date" name="entry_date" :class="{'is-invalid': form.errors.has('entry_date')}">
                                <has-error :form="form" field="entry_date"></has-error>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-show="updateMode" type="submit" class="btn btn-danger " @click="removeExpense();">Delete</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" @click="updateMode = false">Cancel</button>
                    <button v-show="!updateMode" type="submit" class="btn btn-primary" @click="createExpense()">Save</button>
                    <button v-show="updateMode" type="submit" class="btn btn-primary" @click="updateExpense()">Update</button>
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
                expenses: [],
                form: new Form({
                    id:"",
                    category_id: "",
                    amount:"",
                    entry_date:""
                }),
                expensecategory:{}
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
                        this.expenses = response.data;
                        
                    });
            },
            createExpense(){
                
                this.$Progress.start();
                this.form.post("/expenses/create-expense")
                    .then(response => {
                        this.$emit("created");
                        $("#expenseModal").modal("hide");
                        this.$swal(
                            "Added!",
                            "New expense has been added.",
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
                $("#expenseModal").modal("show");
            },
            updateModal(expense){
                this.updateMode = true;
                this.form.reset();
                $("#expenseModal").modal("show");
                this.form.fill(expense);
            },
            updateExpense(){
                this.$Progress.start();
                this.form.post("/expenses/update/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#expenseModal").modal("hide");
                        this.$swal(
                            "Updated!",
                            "Expense has been added.",
                            "success"
                            );
                        this.$Progress.finish();
                    })
                    .catch(error => {
                        this.$Progress.fail();
                    });
            },
            removeExpense(){
                this.$Progress.start();
                this.form.post("/expenses/delete/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#expenseModal").modal("hide");
                        this.$swal(
                            "Deleted!",
                            "Expense has been deleted.",
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
