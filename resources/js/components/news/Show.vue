<template>
    <div class="row  bg-white border border-dark pt-3 pb-3">
        <div class="col-12">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <h1>{{ news.title }}</h1>
                </div>
                <div class="col-md-2 col-sm-6">
                    <router-link :to="{name: 'indexNews'}" class="btn btn-success">Назад</router-link>
                </div>

                <div class="col-md-2 col-sm-6">
                    <ElementLikes
                        v-bind:likes="news.likes"
                        v-bind:table="'newsTable'"
                        v-bind:id="newsId"
                    />
                </div>
            </div>
        </div>
        <div class="col-12" v-if="news.user_id == user.id ">
            <div class="row">
                <div class="col-6">
                    <router-link
                        :to="{name: 'editNews', params: {id: newsId}}"
                        class="btn btn-info float-left"
                    >
                        Редактировать
                    </router-link>
                </div>
                <div class="col-6">
                <span class="btn btn-danger float-right"
                      v-on:click="deleteEntry(newsId)">Удалить</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <hr>
            <span>Дата публикации: <b>{{news.created_at}}</b></span>
            <hr>
        </div>
        <div class="col-12">
            <p>
                {{news.text}}
            </p>
        </div>
    </div>
</template>

<script>
    import ElementLikes from "../functions/Likes";

    export default {
        data: function () {
            return {
                newsId: null,
                news: {
                    title: '',
                    text: '',
                    user_id: 0,
                    created_at: '',
                    likes: Object,
                }
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.newsId = id;
            axios.get('/api/news/' + id)
                .then(function (resp) {
                    app.news = resp.data;
                })
                .catch(function () {
                    alert('Ошибка при получении новости');
                });
        },
        methods: {
            deleteEntry(id) {
                if (confirm("Вы действительно хотите удалить новость?")) {
                    var app = this;
                    axios.delete('/api/news/' + id)
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.$router.push({name: 'indexNews'});
                            }

                        })
                        .catch(function (resp) {
                            alert("Не удалось удалить новость");
                        });
                }
            }
        },
        components: {
            ElementLikes,
        }
    }
</script>
