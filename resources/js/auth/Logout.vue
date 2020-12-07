<template>
  <div>
      <!-- Template is empty, because default Laravel Auth: is used for logout. -->
  </div>
</template>

<script>
export default {

    props: ['user'],

    data: function() {
        return {
            errors: null,

        }
    },

    mounted() {
            axios.post('/logout')
                .then(respone => {
                    localStorage.removeItem('authenticated');
                    localStorage.removeItem('user_api');
                    this.$router.push('/login');
                    location.reload();
                })
                .catch(errors => {
                    this.error = errors.response;
                });
    }
    

}
</script>

<style>

</style>