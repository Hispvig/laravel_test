<template>
    <div class="container">
        <div class="large-12 medium-12 small-12 cell">
            <div class="row">
            <div class="col-md-8 col-sm-12">
                <h1>Загрузка фотографии</h1>
            </div>
            <div class="col-md-2 col-sm-6">
                <router-link :to="{name: 'indexPhotos'}" class="btn btn-success">Назад</router-link>
            </div>
            </div>
            <label>
                <input type="file" id="file" ref="file" accept="image/*" v-on:change="handlePhotoUpload()"/>
            </label>

            <button v-on:click="submitPhoto()">Загрузить</button>
            <img v-bind:src="imagePreview" v-show="showPreview"/>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                file: '',
                showPreview: false,
                imagePreview: ''
            }
        },
        methods: {
            submitPhoto() {
                let app = this,
                    formData = new FormData();

                formData.append('image', this.file);
                axios.post('/api/photos', formData)
                    .then(function (resp) {
                        app.$router.push({name: 'indexPhotos'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось создать новость");
                    });
            },
            handlePhotoUpload() {
                this.file = this.$refs.file.files[0];
                let reader = new FileReader();
                reader.addEventListener("load", function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);
                if (this.file) {
                    if (/\.(jpe?g|png|gif)$/i.test(this.file.name)) {
                        reader.readAsDataURL(this.file);
                    }
                }
            }
        }
    }
</script>
