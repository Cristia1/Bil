<template>
    <div>
        <header>
            <div>
                <div>
                    <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                        <router-link to="/" class="nav-link">
                            <text id="WebPad-Solution" class="text-logo"></text>
                        </router-link>
                        <li>
                            <router-link to="/customers" class="nav-link">
                                Customers
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/bills" class="nav-link">
                                Bills
                            </router-link>
                        </li>
                        <!--                        <li>-->
                        <!--                            <router-link to="/portfolio" class="nav-link">-->
                        <!--                                Portfolio-->
                        <!--                            </router-link>-->
                        <!--                        </li>-->
                        <!--                        <li>-->
                        <!--                            <router-link to="/contact" class="nav-link">-->
                        <!--                                Contact-->
                        <!--                            </router-link>-->
                        <!-- </li>
                        -->
                        <router-link to="/user-profile" class="nav-item ml-auto" role="button" right>
                            {{ contact_name }}
                        </router-link>

                        <li nav-dropdown>
                            <div class="dropdown">
                                <button @click="toggleDropdown" class="nav-link btn arrow-button" role="button">
                                    &#8595;<!-- Unicode pentru o săgeată dreaptă -->
                                </button>
                                <div b-nav-item-dropdown v-show="isDropdownOpen">
                                    <button @click="logout" class="dropdown-item logout-button">Logout</button>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </header>

        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <router-view :contact_name="contact_name"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import UserProfile from '@/Components/Commons/UserProfile.vue';
import Logout from '@/Components/Commons/Logout.vue';


// import ApplicationLogo from "../Components/ApplicationLogo.vue";
// import "../Assets/navbar.css"

export default {
    components: {
        UserProfile,
        Logout,
    },
    data() {
        return {
            users: {},
            contact_name: '',
            user_id: '',
            isDropdownOpen: false,
        };
    },
    mounted() {
        this.fetchUserProfile();
    },
    methods: {
        async fetchUserProfile() {
            try {
                const response = await axios.get('/api/user-profile');
                this.users = response.data;
                this.contact_name = this.users.contact_name;
                this.user_id = this.users.user_id;
            } catch (error) {
                console.error('Error fetching user profile:', error);
            }
        },
        async logout() {
            try {
                await axios.post('/api/logout');
                window.location.href = '/login';
            } catch (error) {
                console.error('Error during logout:', error);
            }
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
    },
};
</script>

<style>
@import '@/Assets/Components/UserProfile.css';
</style>
