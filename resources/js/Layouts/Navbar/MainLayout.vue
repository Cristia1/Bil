<template>
    <div>
      <header>
        <div>
          <div>
            <ul class="navbar navbar-light" style="background-color: #e3f2fd;">
              <router-link to="/">
                <text id="-Solution"></text>
              </router-link>
              <li>
                <router-link to="/customers">Customers</router-link>
              </li>

              <li>
                <router-link to="/bills">Bills</router-link>
              </li>

              <router-link to="/user-profile" class="nav-item ml-auto" role="button" right>
                {{ contact_name }}
              </router-link>

              <li nav-dropdown>
                <div class="dropdown">
                  <button @click="toggleDropdown" class="nav-link btn arrow">&#8595;</button>
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
import UserProfile from '/resources/js/Components/Commons/UserProfile.vue';
import Logout from '/resources/js/Components/Commons/Logout.vue';


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
/* @import '@/Assets/Components/UserProfile.css'; */
</style>