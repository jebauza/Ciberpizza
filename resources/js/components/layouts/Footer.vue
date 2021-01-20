<template>
    <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © {{ now.format('YYYY') }} CiberPizza
        </div>
    </footer>

</template>

<script>
import moment from 'moment'

export default {
    props: ['basepath'],
    data() {
        return {
            now: moment()
        }
    }
}
</script>

<style>

</style>
