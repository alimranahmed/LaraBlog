<template>
    <div id="keywords">
        <div class="row">
            <div class="col-sm-1"><strong>Keywords:</strong></div>
            <div class="col-md-11">
                <a v-bind:href="keyword.articleUrl" v-for="keyword in keywords">
                    <span class="label label-info">{{ keyword.name}}</span>
                </a>
            </div>
        </div>
        <hr class="margin-bottom-10 margin-top-10">
    </div>
</template>

<script>
    export default {
        props: {
            keywords: Array,
        }
    }
</script>

<style scoped>

</style>