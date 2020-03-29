<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Role</div>

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
                                <tr class="" v-if="roles.length === 0">
                                    <td class="lead text-center" :colspan="3">No data found.</td>
                                </tr>
                                <tr v-for="(data, key1) in roles" :key="data.id" class="m-datatable__row" @click="updateModal(data)">
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
            <button class="btn btn-dark" @click="addModal()">Add Role</button>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="roleModal" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!updateMode">Add Role</h5>
                    <h5 class="modal-title" v-show="updateMode">Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="updateMode = false , updateRoleField = true">
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
                                <input v-model="form.description" type="text" class="form-control" id="description" name="description" :class="{'is-invalid': form.errors.has('description')}">
                                <has-error :form="form" field="description"></has-error>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-show="updateMode && updateRoleField" type="submit" class="btn btn-danger " @click="removeRole();">Delete</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" @click="updateMode = false , updateRoleField = true">Cancel</button>
                    <button v-show="!updateMode" type="submit" class="btn btn-primary" @click="createRole()">Save</button>
                    <button v-show="updateMode && updateRoleField" type="submit" class="btn btn-primary" @click="updateRole()">Update</button>
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
                updateRoleField: true,
                roles: [],
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
                this.updateRoleField = true;
                this.fetchData(this.fetchUrl);
            });
        },
        methods: {
            fetchData(url){
                //const self = this;
                axios.get(url)
                    .then(response => {
                        //this.users = Object.assign({}, this.users, response.data);
                        this.roles = response.data;
                        
                    });
            },
            createRole(){
                
                this.$Progress.start();
                this.form.post("/roles/create-role")
                    .then(response => {
                        this.$emit("created");
                        $("#roleModal").modal("hide");
                        this.$swal(
                            "Added!",
                            "New role has been added.",
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
                $("#roleModal").modal("show");
            },
            updateModal(role){
                if(role.id == 1 || role.id == "Administrator"){
                    this.updateRoleField = false;
                }
                this.updateMode = true;
                this.form.reset();
                $("#roleModal").modal("show");
                this.form.fill(role);
            },
            updateRole(){
                this.$Progress.start();
                this.form.post("/roles/update/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#roleModal").modal("hide");
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
            removeRole(){
                this.$Progress.start();
                this.form.post("/roles/delete/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#roleModal").modal("hide");
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
