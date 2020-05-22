<template>
    <span class="float-right btn"
          v-bind:class="{
            'btn-info': likesList[user.id],
            'btn-link': !likesList[user.id]
          }"
          v-on:click="setLikes()">
        Лайк <span class="bg-white text-dark rounded-circle pl-1 pr-1"> {{ likesList.count }} </span>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                likesList: this.likes,
            }
        },
        props: ['likes', 'table', 'id'],
        watch: {
            likes: function (val) {
                this.likesList = this.likes
            },
        },
        methods: {
            setLikes() {
                event.preventDefault();
                let app = this;

                if (app.likesList[App.user.id]) {
                    axios.delete('/api/likes/' + app.table + '/' + app.id)
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.likesList = resp.data;
                            }
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Не удалось удалить лайк");
                        });
                } else {
                    axios.post('/api/likes', {
                        table: app.table,
                        element_id: app.id,
                    })
                        .then(function (resp) {
                            if (resp.data.error) {
                                alert(resp.data.error);
                            } else {
                                app.likesList = resp.data;
                            }
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Не удалось поставить лайк");
                        });
                }

            }
        }
    }
</script>
