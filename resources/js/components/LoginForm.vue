<template>

    <div class="alert alert-warning" v-if="message != ''" role="alert">
        {{ message }}
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" v-model="email">
        <p class="text-danger" v-if="errors.length !== 0 && errors.email != undefined">{{ errors.email[0] }}</p>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" v-model="password">
    </div>

    <br>
    
    <button @click="login()" type="submit" class="btn btn-primary">Login</button>
</template>

<script>
export default {
    name: 'LoginForm',
    data() {
        return {
            errors: [],
            message: '',
            email: '',
            password: ''
        }
    },
    mounted() {
        if ( localStorage.getItem( 'token' ) !== '' && localStorage.getItem( 'token' ) !== undefined ) {
            window.location.href = '/home'
        }
    },
    methods: {

        login() {

            window.axios.post('/api/login', { email: this.email, password: this.password})
                .then( response => {

                    if (response.data.status == 'success') {
                        this.setToken( response.data )
                    } else {
                        this.message = response.data.message
                    }

                }).catch( error => {
                    this.message = error.response.data.message
                } )
        },

        setToken ( user ) {

            localStorage.setItem('token', `Bearer ${user.token}`)
            localStorage.setItem('userName', `${user.data.name}`)
            window.location.href = '/home'
        },

    }
}
</script>
