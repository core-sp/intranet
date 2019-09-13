<template>
    <div>
        <form enctype="multipart/form-data">
            <slot></slot>
            <label for="customFile">Inserir anexo: </label><br>
            <input type="file" id="customFile" ref="file" name="file" @change="onSelect">
            <h5 v-if="message">{{ message }}</h5>
        </form>
        <input v-if="fileName" type="hidden" name="fileName" :value="fileName">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                file: '',
                message: '',
                fileName: ''
            }
        },
        methods: {
            onSelect() {
                const file = this.$refs.file.files[0];
                this.file = file;
                // Novo objeto com o arquivo
                const formData = new FormData();
                formData.append('file', this.file);
                // Manda o POST com o AXIOS
                axios.post('/upload', formData)
                .then(response => { 
                    if(response.data.message) {
                        this.message = response.data.message;
                    } else {
                        this.message = '';
                        this.fileName = response.data.fileName;
                    }
                });
            }
        }
    }
</script>

<style>

</style>