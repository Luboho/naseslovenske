<template>
  <div class="p-3">
          <h1 class="text-blue-500 uppercase italic font-bold"> Upraviť príspevok</h1> 
          <div class="py-10">
            <a href="#" class="text-indigo-400" @click="$router.back()">
                ← Back
            </a>
          </div>

      <form @submit.prevent="saveForm" enctype="multipart/form-data">
        <InputField name="title" label="Title" :errors="errors" placeholder="Titul" 
                        @update:field = "form.title = $event" :data="form.title" />
        <InputField name="description" label="Popis" :errors="errors" placeholder="Tu patrí článok" 
                        @update:field = "form.description = $event" :data="form.description" />

        <FileInput name="image" label="Obrázok" :errors="errors" @change = "form.image = $event" 
                    @update = "errors = $event" :data="form.image" />


        <!-- Buttons -->
        <div class="flex justify-end">
          <button @click.prevent="$router.back()" class="py-2 px-4 rounded text-red-700 border mr-5 hover:border-red-700">Cancel</button>
          <button class="bg-indigo-500 py-2 px-4 rounded text-white hover:bg-indigo-400">Save</button>
        </div>
  </form>
  </div>

</template>

<script>
    import InputField from '../../components/InputField';
    import FileInput from '../../components/FileInput';


export default {
    name: "PostsEdit",

    props: ['user'],

    components: {
        InputField,
        FileInput
    },

    mounted() {
        axios.get('/api/posts/' + this.$route.params.id)
                .then(response => {
                    this.form = response.data.data;
                    this.form.image = "";

                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                    if(error.response.status === 404) { // Redirect to / if response status is 404.
                        this.$router.push('/posts');
                    }
                });
    },

    data: function() {
        return {
            form: {
                'title': '',
                'description': '',
                'image': '',
            },

            errors: null,
        }
    },  

    methods: {
        saveForm: function() {
            axios.patch('/api/posts/' + this.$route.params.id  + '?api_token=' + this.user.api_token , this.form)
                .then(response => {
                        this.$router.push(response.data.links.self);
                    })
                .catch(errors => {
                    this.errors = errors.response.data.errors;
                });
        }
    },

    watch: {
        data: function (val) {
            this.value = val;
        }
    }

}
</script>

<style scoped>

</style>