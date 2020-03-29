<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email Address</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
    
                                <tr class="" v-if="users.length === 0">
                                    <td class="lead text-center" :colspan="4">No data found.</td>
                                </tr>
                                <tr v-for="(data, key1) in users" :key="data.id" class="m-datatable__row" @click="updateModal(data)">
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.email }}</td>
                                    <td>{{ data.role }}</td>
                                    <td>{{ data.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-2">
            <button class="btn btn-dark" @click="addModal()">Add User</button>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="userModal" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!updateMode">Add User</h5>
                    <h5 class="modal-title" v-show="updateMode">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="updateMode = false, updateRoleField = true">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8">
                                <input v-model="form.name" type="text" class="form-control" id="name" name="name" :class="{'is-invalid': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email Address</label>
                            <div class="col-sm-8">
                                <input v-model="form.email" type="text" class="form-control" id="email" name="email" :class="{'is-invalid': form.errors.has('email')}">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-4 col-form-label">Role</label>
                            <div class="col-sm-8">
                                <select v-model="form.role_id" class="form-control" id="role" name="role">
                                    <option v-for="(item, index) in $attrs.roles" v-bind:value="index">{{ item }}</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button v-show="updateMode && updateRoleField" type="submit" class="btn btn-danger " @click="removeUser();">Delete</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal" @click="updateMode = false , updateRoleField = true">Cancel</button>
                    <button v-show="!updateMode" type="submit" class="btn btn-primary" @click="createUser()">Save</button>
                    <button v-show="updateMode && updateRoleField" type="submit" class="btn btn-primary" @click="updateUser()">Update</button>
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
                users: [],
                form: new Form({
                    id:"",
                    name: "",
                    email: "",
                    role_id:""
                }),
                roles:{}
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
                        this.users = response.data;
                        
                    });
            },
            createUser(){
                
                this.$Progress.start();
                this.form.post("/users/create-user")
                    .then(response => {
                        this.$emit("created");
                        $("#userModal").modal("hide");
                        this.$swal(
                            "Added!",
                            "New user has been added.",
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
                $("#userModal").modal("show");
            },
            updateModal(user){
                if(user.role_id == 1 || user.role_id == "Administrator"){
                    this.updateRoleField = false;
                }
                this.updateMode = true;
                this.form.reset();
                $("#userModal").modal("show");
                this.form.fill(user);
            },
            updateUser(){
                this.$Progress.start();
                this.form.post("/users/update/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#userModal").modal("hide");
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
            removeUser(){
                this.$Progress.start();
                this.form.post("/users/delete/"+this.form.id)
                    .then(response => {
                        this.$emit("created");
                        $("#userModal").modal("hide");
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
