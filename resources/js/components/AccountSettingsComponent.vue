<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-header">Account Settings</div>
                        
                    <div class="card-body ">
                        <form class="" @submit.prevent="updatePW()">
                            <div class="form-group">
                                <label for="new_password" class="col-sm-4 col-form-label">New Password</label>
                                <div class="col-sm-8">
                                    <input v-model="form.new_password" type="password"  class="form-control" id="new_password" name="new_password" :class="{'is-invalid': form.errors.has('new_password')}">
                                    <has-error :form="form" field="new_password"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-4 col-form-label">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input v-model="form.confirm_password" type="password"  class="form-control" id="confirm_password" name="confirm_password" :class="{'is-invalid': form.errors.has('confirm_password')}">
                                    <has-error :form="form" field="confirm_password"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            form: new Form({
                new_password:"",
                confirm_password:""
            })
        }
        
    },
    created(){
        
    },
    methods:{
        updatePW(){
            this.$Progress.start();
            this.form.post("/users/updatePW")
                .then(response => {
                    this.$swal(
                        "Updated!",
                        "Password has been updated.",
                        "success"
                        );
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(error => {
                    this.$Progress.fail();
                });
        },
    }
}
</script>