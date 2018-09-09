<template>
    <div class="col-sm-12" id="comment-form">
        <form action="#" method="post" onsubmit="return false;" name="add_comment_form"
              v-on:submit="addComment(comment)">
            <div class="form-group col-sm-12 no-padding">
            <textarea name="content" class="form-control" id="comment" rows="3" v-model="comment.content"
                      placeholder="Comment*" required></textarea>
            </div>
            <div class="form-group col-sm-6 no-padding-left">
                <input type="text" name="name" value="" class="form-control" v-model="comment.name"
                       id="name" placeholder="Name*" required>
            </div>
            <div class="form-group col-sm-6 no-padding-right">
                <input type="email" name="email" value="" class="form-control" v-model="comment.email"
                       id="email" placeholder="Email*" required>
            </div>
            <div class="form-group col-sm-6 col-sm-offset-6 no-padding-right checkbox">
                <label>
                    <input type="checkbox" name="notify" v-model="comment.notify"> Notify me about new article
                </label>
                <button type="submit"
                        class="btn btn-primary pull-right"
                        id="submit-comment-btn">Comment</button>
            </div>
        </form>
    </div>
</template>

<script>
    import * as Ladda from 'ladda';
    export default {
        props: {
            add_comment_url: String,
        },
        data() {
            return {
                comment: {
                    content: '',
                    name: '',
                    email: '',
                    notify: false,
                },
            }
        },

        methods: {
            addComment: function (comment) {
                console.log(this.add_comment_url, comment);

                let l = Ladda.create(document.querySelector('#submit-comment-btn'));
                l.start();

                axios.post(this.add_comment_url, comment)
                    .then(function (response) {
                        //hide comment form
                        $("#comments").html(response.body);
                        $('#comment-form').hide();
                        //show success alert
                        let successAlert = $('#success-alert');
                        successAlert.show();
                        successAlert.fadeOut(1000 * 10);
                        $('#success-msg').html('Success! your comment will be published soon');
                        //clear form values
                        $('input').val('');
                        $('textarea').val('');
                        l.stop();
                    })
                    .catch(function (error) {
                        console.log(error);
                        //show error alert
                        let errorAlert = $('#error-alert');
                        errorAlert.show();
                        errorAlert.fadeOut(1000 * 10);
                        $('#error-msg').html(error);
                        l.stop();
                    });
            }
        }
    }
</script>

<style scoped>

</style>