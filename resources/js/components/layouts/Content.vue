<template>
    <div class="content" style="min-height: 1184px;">

        <!-- Main content -->
        <section class="content">
            <transition name="slide-fade" mode="out-in">

                <router-view></router-view>

            </transition>
        </section>

    </div>
</template>

<script>
export default {
    props: ['basepath'],
}
</script>

<style>

</style>
