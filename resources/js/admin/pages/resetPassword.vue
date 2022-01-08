<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                  <div class="login_header">
                      <h1>Reset Password</h1>
                  </div>
                  <div class="space">
                        <Input type="email" v-model="data.email"  placeholder="Email"  />
                    </div>
                    <div class="login_footer">
                        <Button type="primary" @click="login" :disabled="isResetting" :loading="isResetting">{{isResetting ? 'Resetting...' : 'Reset Password'}}</Button>
                        <Button type="default" @click="goToLogin()">Login</Button>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            data : {
                email : ''
            }, 
            isResetting: false, 
        }
    }, 

    methods : {
        goToLogin(){
            this.$router.push('/login'); 
        },
        async login(){
            if(this.data.email.trim()=='') return this.e('Email is required')
            this.isResetting = true
            const res = await this.callApi('post', 'password/reset', this.data)
            if(res.status===200){
                this.s(res.data.msg)
                window.location = '/'
            }else{
                if(res.status===401){
                    this.i(res.data.msg)
                }else if(res.status==422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                }
                else{
                    this.swr()
                }
            }
            this.isResetting = false
        }
    }
}
</script>
<style scoped>
    ._1adminOverveiw_table_recent {
        margin: 0 auto;
        margin-top: 220px;
    }
    .login_footer{
        text-align: center;
    }
    .login_header{
        text-align: center;
        margin-bottom: 25px;
    }
</style>