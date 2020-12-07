<template>
  <div class="p-3">
        <h1 class="text-blue-500 pb-4 uppercase italic font-bold"> Nový príspevok na reklamný portál</h1> 
        <a href="#" class="py-5 text-indigo-400" @click="$router.back()">
            ← Back
        </a>

      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <InputField name="title" label="Titul" :errors="errors" placeholder="Titul" 
                        @update:field = "form.title = $event" />
        <InputField name="description" label="Popis" :errors="errors" placeholder="Tu patrí článok" 
                        @update:field = "form.description = $event" />
        <FileInput name="image" label="Obrázok" :errors="errors"
                        @change = "form.image = $event" @update = "errors = $event" />
                        
        <!-- Buttons -->
        <div class="flex justify-end">
            <button class="bg-indigo-500 py-2 px-4 rounded text-white hover:bg-indigo-400">Pridať príspevok</button>
        </div>
  </form>
  </div>

</template>

<script>
    import InputField from '../../components/InputField';
    import FileInput from '../../components/FileInput';

export default {
    name: "PostCreate",
    props: ["user"],
    components: {
        InputField,
        FileInput,
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
        
        submitForm: function() {
            if (this.form.image === ''){
                this.errors = {'image': ['Pole obrázok je povinné.']};
            } else {
                
                axios.post('/api/posts?api_token=' + this.user.api_token, this.form)
                    .then(response => {
                        
                        this.$router.push(response.data.links.self);
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                    });
            }
        }
    },


}
</script>

<style>

</style>