<template>
<div>
    <Navbar :basepath="basepath"></Navbar>

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

    },
    data() {
        return {
            d: 'd'
        }
    },
    methods: {

    },
}
</script>
