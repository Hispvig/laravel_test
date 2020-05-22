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
                            <button class="btn btn-success">Создать новость</button>
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
                news: {
                    title: '',
                    text: '',
                    preview_text: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                let app = this,
                    newNews = app.news;
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
