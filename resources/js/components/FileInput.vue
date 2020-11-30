<template>
  <div class="relative pb-4">
    <label :for="name" class="text-blue-500 pt-2 uppercase text-xs font-bold absolute">{{ label }}</label>
    
    <!-- File preview -->  
    <div class="pt-8 pb-2 w-full outline-none border-blue-400">
        <div v-if="previewImage"
            class=" imagePreviewWrapper rounded-lg"
            :style="{ 'background-image': `url(${previewImage})` }"
            @click="selectImage">
        </div>
    </div>

    <div v-if="enableCurrentImgElement" class="w-200px pb-2">
        <img :src="'/storage/uploads/' + getFileNameFromUrl()" class="rounded-lg" >
    </div>

    <input
     :id="name"
      ref="fileInput"
      type="file"
      @change="filesSelected"
      @input="pickFile" 
      class="w-full text-gray-900 border-b pb-2"
     :class="errorClassObject()"
      >
    <!-- end of File preview-->

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
            previewImage: null,
            fileNameFromUrl: '',
            enableCurrentImgElement: false,
        }
    },

     computed: {
        hasError: function(msg) {
                return this.errors && this.errors[this.name] && this.errors[this.name].length > 0 ; 
        }
    },

    methods: {
// =========  Preview Image methods=========
        selectImage () {
          this.$refs.fileInput.click()
        },

        pickFile () {
            let input = this.$refs.fileInput
            let file = input.files

            if (file && file[0]) {
            let reader = new FileReader
            reader.onload = e => {
                this.previewImage = e.target.result
            }
            reader.readAsDataURL(file[0])
            this.$emit('input', file[0])
            }
        },
// =========== end of preview image methods=============

        filesSelected: function(e) {
            this.clearErrors();
            this.enableCurrentImgElement = false;
            // Refresh 'image' input variable.
            this.$emit("change", '');
            let file = e.target.files[0];
            let reader = new FileReader();
        
            if(file.size > 650000) {
                this.value = { 'image': ['Súbor nesmie byť väčší ako 5MB.'] };
                this.$emit("update", this.value);
                reader.abort();
            } else if(file == undefined ) {
                this.value = { 'image': ['Pole obrázok je povinné.'] };
                this.$emit("update", this.value);
            } else if(file && file.type.match('image.jpg') 
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
// Current img preview methods
        getFileNameFromUrl: function() {
           const urlPath = window.location.search;
           const getUrlFileName = urlPath.split('?file_name=');    // Array

            return getUrlFileName[1];
        },

        enableCurrentImagePreview: function() {

           const urlPath = window.location.href;
           const enableCurrentImgElement = urlPath.search('edit');
           if(enableCurrentImgElement != -1) {
               this.enableCurrentImgElement = true;
           } else if(this.previewImage) {
               this.enableCurrentImgElement = false;
           }
        },
// end current img preview methods

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

    // Watch data atribute if change (edit/update data)
    watch: {
        data: function(val) {
            this.value = val;
        }
    },

    created: function(){
        this.enableCurrentImagePreview()
    },


    
}
</script>

<style scoped>
.imagePreviewWrapper {
    width: 200px;
    height: 150px;
    cursor: pointer;
    background-size: cover;
}
.error-field {
        @apply .border-red-500 .border-b-2
    }
</style>