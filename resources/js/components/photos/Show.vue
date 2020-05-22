<template>
    <div class="row  bg-white border border-dark pt-3 pb-3">
        <div class="col-12">
            <router-link :to="{name: 'indexPhotos'}" class="btn btn-success">Назад</router-link>
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-6">
                    <ElementLikes
                        v-bind:likes="photo.likes"
                        v-bind:table="'photosTable'"
                        v-bind:id="photoId"
                    />
                </div>
                <div class="col-6" v-if="photo.user_id == user.id ">
                <span class="btn btn-danger float-right"
                      v-on:click="deleteEntry(photoId)">Удалить</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <img :src="photo.name"/>
        </div>
    </div>
</template>

<script>
    import ElementLikes from "../functions/Likes";

    export default {
        data: function () {
            return {
                photoId: null,
                photo: {
                    name: '',
                    user_id: 0,
                    likes: Object,
                }
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.photoId = id;
            axios.get('/api/photos/' + id)
                .then(function (resp) {
                    app.photo = resp.data;
                })
                .catch(function () {
                    alert('Ошибка при получении изображения');
                });
        },
        methods: {
            deleteEntry(id) {
                if (confirm("Вы действительно хотите удалить изображение?")) {
                    var app = this;
                    axios.delete('/api/photos/' + id)
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.$router.push({name: 'indexPhotos'});
                            }

                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить изображение");
                        });
                }
            }
        },
        components: {
            ElementLikes,
        }
    }
</script>
