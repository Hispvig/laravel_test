<template>
    <div>
        <div class="form-group" v-if="signedIn">
            <router-link :to="{name: 'createPhotos'}" class="btn btn-success">Загрузить фотографию</router-link>
        </div>
        <div class="panel panel-default">
            <h1>Фотографии</h1>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-md-2 col-sm-12 bg-white border-dark border" v-for="photo, index in photos">
                        <div class="row">
                            <div class="col-12">
                                <router-link :to="{name: 'showPhotos', params: {id: photo.id}}">
                                    <img class="w-100" :src="photo.name" alt="" />
                                </router-link>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ElementLikes
                                            v-bind:likes="photo.likes"
                                            v-bind:table="'photosTable'"
                                            v-bind:id="photo.id"
                                        />
                                    </div>
                                    <div class="col-sm-6"  v-if="photo.user_id == user.id ">
                                        <span class="btn btn-danger"
                                              v-on:click="deleteEntry(photo.id, index)">Удалить</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ElementLikes from '../functions/Likes.vue';

    export default {
        data() {
            return {
                photos: [],
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/photos')
                .then(function (resp) {
                    app.photos = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить фотографии");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы действительно хотите удалить фотографию?")) {
                    var app = this;
                    axios.delete('/api/photos/' + id)
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.photos.splice(index, 1);
                            }

                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить фотогрфию");
                        });
                }
            }
        },
        components: {
            ElementLikes,
        }
    }
</script>
