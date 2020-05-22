<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'indexNews'}" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создание новости</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Название новости</label>
                            <input type="text" v-model="news.title" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Текст новости</label>
                            <textarea v-model="news.text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Текст новости</label>
                            <textarea v-model="news.preview_text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Редактировать новость</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                newsId: null,
                news: {
                    title: '',
                    text: '',
                    preview_text: '',
                }
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.newsId = id;
            axios.get('/api/news/' + id)
                .then(function (resp) {
                    if (!App.user || resp.data.user_id != App.user.id) {
                         app.$router.push({name: 'indexNews'});
                    } else {
                        app.news = resp.data;
                    }
                })
                .catch(function () {
                    app.$router.push({name: 'indexNews'});
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newNews = app.news;
                axios.post('/api/news', newNews)
                    .then(function (resp) {
                        app.$router.push({name: 'indexNews'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось создать новость");
                    });
            }
        }
    }
</script>
