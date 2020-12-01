<template>
  <div>
      <img :src="imageObject.data.attributes.path" 
        ref="userImage"
        alt="User background image" class="object-cover w-full">
    </div>
</template>

<script>
import Dropzone from 'dropzone';

export default {
    name: 'UploadableImage',

    props: [
        'userImage',
        'imageWidth',
        'imageHeight',
        'location',
    ],

    data:()=>{
        return {
            dropzone: null,
        }
    },

    mounted() {
        this.dropzone = new Dropzone(this.$refs.userImage, this.settings);

    },
    computed: {
        settings(){
            return {
                paramName: 'image',
                url: '/api/user-images',
                acceptedFiles: 'image/*',
                params: {
                    'width': this.imageWidth,
                    'height': this.imageHeight,
                    'location': this.location,
                },
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                },
                success: (e, res) => {
                    alert('uploaded');
                }
            }
        },
        imageObject() {
            return this.userImage
        }
    }

}
</script>

<style>

</style>