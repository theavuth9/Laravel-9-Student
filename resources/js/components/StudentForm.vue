<template>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" v-model="student.name">
            <p class="text-danger" v-if="errors.length !== 0 && errors.name != undefined">{{ errors.name[0] }}</p>
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" v-model="student.gender">
                <option class="Male">Male</option>
                <option class="Female">Female</option>
            </select>
            <p class="text-danger" v-if="errors.length !== 0 && errors.gender != undefined">{{ errors.gender[0] }}</p>
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="text" class="form-control" id="dob" v-model="student.dob">
            <p class="text-danger" v-if="errors.length !== 0 && errors.dob != undefined">{{ errors.dob[0] }}</p>
        </div>

        <div class="form-group">
            <label for="major">Major</label>
            <input type="text" class="form-control" id="major" v-model="student.major">
        </div>

        <div class="form-group">
            <label for="profile">Profile</label>
            <input @change="onChange" type="file" class="form-control" id="profile">
        </div>

        <br>
        
        <button @click="save()" type="submit" class="btn btn-primary">Save</button>
</template>

<script>
import axios from 'axios';

    export default {
        name: 'StudentForm',
        mounted() {
            if (this.id) {
                this.loadStudent( this.id );
            }
        },
        data() {
            return {
                errors: [],
                file: '',
                student: {
                    id: "",
                    name: "",
                    gender: "",
                    dob: "",
                    major: "",
                    profile: null
                }
            }
        },
        props: [ 'id' ],
        methods: {

            save() {
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        Authorization: localStorage.getItem( 'token' )
                    }
                }

                /**
                 * Append file into student.profile
                 */
                this.student.profile = this.file;

                /**
                 * Handling for save data
                 * through API
                 */
                axios.post( `/api/students/save`, this.student, config )
                    .then( result => {

                        if (result.data.status == 'success') {
                            window.location.href = '/home'
                        }

                    })
                    .catch( error => this.errors = error.response.data.errors )

            },

            onChange(e) {
                this.file = e.target.files[0]
            },

            loadStudent( id ) {
                /**
                 * Handling for save data
                 * through API
                 */
                axios.get( `/api/students/${id}`, { headers: { Authorization: localStorage.getItem( 'token' ) } } )
                    .then( result => {

                        if( result.data.status === 'success' ) {
                            this.student = result.data.data
                        }

                    })
                    .catch( error => this.errors = error.response.data.errors )

            }

        }
    }
</script>
