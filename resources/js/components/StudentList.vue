<template>

    <div class="alert alert-warning" v-if="message !== ''" role="alert">
        {{ message }}
    </div>
                        
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-md">
            <thead>
                <tr class="">
                    <th scope="col" class="text-center">Profile</th>
                    <th scope="col" class="text-center">Full Name</th>
                    <th scope="col" class="text-center">Gender</th>
                    <th scope="col" class="text-center">Date of Birth</th>
                    <th scope="col" class="text-center">Major</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="students.length === 0">
                    <td class="text-center" colspan="6">No Student</td>
                </tr>
                <tr v-for="student of students" :key="student.id">
                    <td>
                        <img v-if="student.profile !== '' || student.profile !== undefined" :src="'/storage/' + student.profile" width="60" alt="">
                    </td>
                    <td>{{student.name}}</td>
                    <td class="text-center">{{student.gender}}</td>
                    <td class="text-center">{{student.dob}}</td>
                    <td>{{student.major}}</td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-primary" :href="'/edit/' + student.id">Edit</a> &nbsp;
                        <span class="btn btn-sm btn-danger" @click="doDelete( student.id )">Delete</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        name: 'StudentList',
        mounted() {

            /**
             * Fetching Student Records
             * from Database
             * through API
             */
            this.fetchStudents();

        },
        data() {
            return {
                message: '',
                students: []
            }
        },
        methods: {

            fetchStudents() {

                window.axios.get( `/api/students`, { headers: { Authorization: localStorage.getItem( 'token' ) } } )
                    .then( result => {

                        if (result.data.status == 'success') {

                            this.students = result.data.data;

                        } else {

                            this.message = 'Woops, something was wrong!!';

                        }

                    }).catch( error => this.message = error )
            },

            doDelete( id ) {
                if (id) {
                    axios.delete( `/api/students/${id}/delete`, { headers: { Authorization: localStorage.getItem( 'token' ) } } )
                        .then( result => {

                            if (result.data.status == 'success') {

                                window.location.reload();

                            } else {

                                this.message = 'Woops, something was wrong!!';

                            }

                        })
                        .catch( error => this.message = error )
                }
            }
        }
    }
</script>
