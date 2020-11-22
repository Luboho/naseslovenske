<template>
  <div class="relative pb-4">
    <label :for="name" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">{{ label }}</label>
    
    <input :id="name" 
            type="file"
            class="pt-8 w-full text-gray-900 border-b pb-2 focus:outline-none focus:border-blue-400"
            @change="filesSelected"
            :class="errorClassObject()"
            multiple
    >
    <p class="text-red-600 text-sm" v-text="errorMessage()"></p> <!--(name) represents name in particular input. attribut in component InputField-->
    </div>
</template>

<script>
export default {
    name: "FileInput",
    props: [
        'name', 'label', 'placeholder', 'errors', 'data',
    ],

    data: function() {
        return {
            value: '',
        }
    },

     computed: {
        hasError: function(msg) {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0 ; 
        }
    },

    methods: {
        
        filesSelected: function(e) {

            this.clearErrors();
            // Refresh 'image' input variable.
            this.$emit("change", '');

            let file = e.target.files[0];
            let reader = new FileReader();

            if(file && file.type.match('image.jpg') 
                    || file && file.type.match('image.png') 
                        || file && file.type.match('image.jpeg')) {

                reader.onloadend = (file) => {

                    this.$emit("change", reader.result);
                }
                reader.readAsDataURL(file);   

            } else {
                this.value = { 'image': ['Nepodporovaný súbor'] };
                this.$emit("update", this.value);
                reader.abort();
            }
        },

        errorMessage: function() {
            if (this.hasError) {
                return this.errors[this.name][0];
            }
        },

        clearErrors: function () {
                if (this.hasError) {
                    this.errors[this.name] = null;
                }
            },

        errorClassObject: function() {
            return {
                'error-field' : this.hasError
            }
        }
    },

    watch: {
        data: function(val) {
            this.value = val;
        }
    }
    
}
</script>

<style>
.error-field {
        @apply .border-red-500 .border-b-2
    }
</style>