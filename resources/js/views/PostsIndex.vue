<template>
  <PostsList endpoint="/api/posts" />
</template>

<script>
    import PostsList from '../components/PostsList';

    export default {
        name: "PostsIndex",

        components: {
            PostsList
        }, 
    }
</script>

<style>

</style>