<template>
    <div class="TableUser">
        <h2 class="Pragraf v-cloak">{{ user.contact_name }}</h2>

        <form @submit.prevent="updateUser" class="user-profile-form">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_name">Contact Name:</label>
                        <input v-model="user.contact_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <div @click="emitEmail" class="form-control">{{ user.email }}</div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" v-model="user.phone">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="business_name">Business Name:</label>
                        <input type="text" class="form-control" v-model="user.business_name">
                    </div>

                    <div class="form-group">
                        <label for="vat_number">VAT Number(Cui):</label>
                        <input type="text" class="form-control" v-model="user.vat_number">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" v-model="user.address">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update Profile</button>
        </form>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    name: 'UserProfile',
    data() {
        return {
            user: {},
        };
    },
    mounted() {
        this.fetchUserProfile();
    },
    methods: {
        fetchUserProfile() {
            axios.get('/api/user-profile').then((response) => {
                this.user = response.data;
            }).catch((error) => {
                console.error('Error fetching user profile:', error);
            });
        },
        updateUser() {
            axios.put('/api/user-profile/update', this.user).then((response) => {
                this.user = response.data;
                window.location.href = '/bills';
            }).catch((error) => {
                console.error('Error updating user profile:', error);
            });
        },
    },
};
</script>

<style>
@import '@/Assets/Components/UserProfile.css';
</style>
