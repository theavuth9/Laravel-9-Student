<template>
    <ul class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        <li class="nav-item" v-if="checkLogin === false">
            <a class="nav-link" href="/login">Login</a>
        </li>
    
        <li class="nav-item" v-if="checkLogin === false">
            <a class="nav-link" href="/register">Register</a>
        </li>
        
        <li class="nav-item dropdown" v-if="checkLogin !== false">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                Menu
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" @click="logout()" >
                    Logout
                </a>
            </div>
        </li>
    </ul>
</template>
<script>
    export default {
        name: 'NavigationMenu',
        data() {
            return {
                checkLogin: false,
                userName: '',
            }
        },
        mounted() {
    
            if ( localStorage.getItem( 'token' ) !== undefined && localStorage.getItem( 'token' ) !== '' ) {
                this.checkLogin = true
                this.userName = localStorage.getItem( 'userName' )
            } else {
                this.checkLogin = false
                this.userName = ''
            }
    
        },
        methods: {
            logout() {
                localStorage.setItem( 'token', '' )
                localStorage.setItem( 'userName', '' )
                window.location.href = '/login'
            }
        }
    }
    </script>