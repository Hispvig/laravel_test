<template>
    <div>
        <div class="form-group" v-if="signedIn">
            <router-link :to="{name: 'createNews'}" class="btn btn-success">Создать новость</router-link>
        </div>
        <div class="panel panel-default">
            <h1>Новости</h1>
            <div class="panel-body">
                <div class="row">
                    <div class="col-12 bg-white border-dark border" v-for="post, index in news">
                        <div class="row">
                            <div class="col-md-10 col-sm-12">
                                <router-link :to="{name: 'showNews', params: {id: post.id}}">
                                    <h2>
                                        {{post.title}}
                                    </h2>
                                </router-link>
                                <p>
                                    {{post.preview_text}}
                                </p>
                            </div>
                            <div class="col-md-2 col-sm-12" v-if="post.user_id == user.id ">
                                <div class="row">
                                    <div class="col-md-12 col-sm-6">
                                        <router-link
                                            :to="{name: 'editNews', params: {id: post.id}}"
                                            class="btn btn-info"
                                        >
                                            Редактировать
                                        </router-link>
                                    </div>
                                    <div class="col-md-12 col-sm-6">
                                        <span class="btn btn-danger"
                                              v-on:click="deleteEntry(post.id, index)">Удалить</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <span class="float-left">{{post.created_at}}</span>
                                <ElementLikes
                                    v-bind:likes="post.likes"
                                    v-bind:table="'newsTable'"
                                    v-bind:id="post.id"
                                />
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
                news: [],
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/news')
                .then(function (resp) {
                    app.news = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Не удалось загрузить новость");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы действительно хотите удалить новость?")) {
                    var app = this;
                    axios.delete('/api/news/' + id)
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.news.splice(index, 1);
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
