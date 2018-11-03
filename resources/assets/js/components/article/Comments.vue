<template>
    <div>
        <div v-for="comment in comments">
            <div class="row margin-bottom-5">
                <div class="col-sm-12 text-md">
                    <b>{{ comment.user.name }}</b>&nbsp;said:
                </div>
                <div class="col-sm-12 text-justify">{{ comment.content }}
                    <span class="text-grey">&nbsp;{{ comment.createdAtHuman }}</span>
                    <span class="text-primary pointer" data-toggle="modal"
                          data-target="#reply-form"
                          v-on:click="initiateReplyForm(comment.id)"
                    >&nbsp;Reply</span>
                </div>
            </div>

            <div class="row margin-bottom-5 margin-left-30" v-for="commentReply in comment.replies">
                <div class="col-sm-12 text-md">
                    <b>{{ commentReply.user.name }}</b>&nbsp;replied:
                </div>
                <div class="col-sm-12 text-justify">{{commentReply.content}}
                    <span class="text-grey">&nbsp;{{commentReply.createdAtHuman}}</span>
                </div>
            </div>

        </div>

        <div class="row" v-if="comments.length === 0">
            <div class="col-sm-12">
                <span class="text-grey">No comment yet</span>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="reply-form" tabindex="-1" role="dialog" aria-labelledby="reply-form">
            <div class="modal-dialog" role="document">
                <form action="#" method="post" onsubmit="return false;"
                      name="add_comment_form"
                      v-on:submit.prevent="addReply(reply)">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Reply</h4>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-12">
                                <input type="hidden" v-model="reply.parent_comment_id" name="parent_comment_id"
                                       id="parent_comment_id">
                                <div class="form-group col-sm-12 no-padding">
                                <textarea name="content" class="form-control" rows="3" v-model="reply.content"
                                  placeholder="Comment*" required></textarea>
                                </div>
                                <div class="form-group col-sm-6 no-padding-left">
                                    <input type="text" name="name" value="" class="form-control"
                                           v-model="reply.name"
                                           placeholder="Name*" required>
                                </div>
                                <div class="form-group col-sm-6 no-padding-right">
                                    <input type="email" name="email" class="form-control"
                                           v-model="reply.email"
                                           placeholder="Email*" required>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group col-sm-12 no-padding-right checkbox">
                                <label class="padding-right-5">
                                    <input type="checkbox" v-model="reply.notify"
                                           name="notify"> Notify me about new article
                                </label>
                                <button type="submit"
                                        class="btn btn-primary pull-right"
                                        id="reply-submit-btn">Reply</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import * as Ladda from 'ladda';

    export default {
        name: "Comments",
        props: {
            comments: Array,
            add_comment_url: String,
        },

        data() {
            return {
                reply: {
                    parent_comment_id: '',
                    content: '',
                    name: '',
                    email: '',
                    notify: false,
                }
            }
        },
        methods: {
            initiateReplyForm(commentID) {
                this.reply.parent_comment_id = commentID;
            },

            addReply (reply) {
                let l = Ladda.create(document.querySelector('#reply-submit-btn'));
                l.start();

                axios.post(this.add_comment_url, reply)
                    .then( (response) => {
                        console.log(response);
                        //hide comment form
                        $("#comments").html(response.body);
                        $('.modal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        //show success alert
                        let successAlert = $('#success-alert');
                        successAlert.show();
                        successAlert.fadeOut(1000 * 10);
                        $('#success-msg').html('Success! your reply will be published soon');
                        //clear form values
                        $('input').val('');
                        $('textarea').val('');
                        l.stop();
                    })
                    .catch( (response) => {
                        //show error alert
                        var errorAlert = $('#error-alert');
                        errorAlert.show();
                        errorAlert.fadeOut(1000 * 10);
                        $('#error-msg').html(response.body.errorMsg);
                    });

                return false;
            }
        }
    }
</script>

<style scoped>

</style>