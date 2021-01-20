<template>
<div>
    <Navbar :basepath="basepath" :auth_user="authUser"></Navbar>

    <Content :basepath="basepath"></Content>

    <Footer :basepath="basepath"></Footer>

</div>
</template>

<script>
import Navbar from './layouts/Navbar';
import Content from './layouts/Content';
import Footer from './layouts/Footer';

export default {
    components: {Navbar,Content,Footer},
    props: ['basepath'],
    mounted() {
        EventBus.$on('verifyAuthenticatedUser', () => {
            this.getAuthUser();
        });

        this.getAuthUser();
    },
    data() {
        return {
            authUser: JSON.parse(localStorage.getItem('authUser')) || null,
        }
    },
    methods: {
        getAuthUser() {
            const url = '/api/auth/user';

            axios.get(url)
            .then(res => {
                this.authUser = res.data;
                localStorage.setItem('authUser', JSON.stringify(this.authUser));
            })
            .catch(err => {
                localStorage.removeItem('access_token');
                localStorage.removeItem('authUser');
                delete axios.defaults.headers.common['Authorization'];
                this.authUser = null;
                this.$router.push({name: 'home'});
            });
        },
    },
}
</script>
