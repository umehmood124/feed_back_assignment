<template>
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="col-md-12 col-sm-12 row">
                    <div class="col-md-11 col-sm-11">

                    </div>
                    <div class="col-md-1 col-sm-1">
                        <button type="button"
                                class="btn btn-primary w-10 waves-effect waves-float waves-light"
                                @click="logout()">Logout
                        </button>
                    </div>

                </div>
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Left Text-->
                        <div class="col-lg-8 col-md-8 col-sm-12 d-none d-lg-flex">
                            <div class="row w-100" id="basic-table">
                                <div class="col-12">
                                    <div class="card" style="height:500px; overflow-y:scroll;">
                                        <div class="card-header">
                                            <h4 class="card-title">Feedbacks</h4>
                                        </div>
                                        <div class="table-responsive fix-header">
                                            <table class="table table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="sticky-th-center">Sr. #</th>
                                                    <th class="sticky-th-center">Title</th>
                                                    <th class="sticky-th-center">Description</th>
                                                    <th class="sticky-th-center">User</th>
                                                    <th class="sticky-th-center">Category</th>
                                                    <th class="sticky-th-center">Comments</th>
                                                    <th class="sticky-th-center">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(feedback, index) in feedbacks.data" :key="feedback.id">
                                                    <td>
                                                        <div class="col-md-1" style="text-align:center;">
                                                            {{ index + 1 }}
                                                        </div>
                                                    </td>
                                                    <td>{{ feedback.title }}</td>
                                                    <td>{{ feedback.description }}</td>
                                                    <td>{{ feedback.user.email }}</td>
                                                    <td>{{ feedback.feedback_category.name }}</td>
                                                    <td>
                                                        <ul v-if="feedback.comments.length > 0">
                                                            <li v-for="comment in feedback.comments" :key="comment.id"
                                                                v-html="comment.comment_text">
                                                            </li>
                                                        </ul>
                                                        <p v-else>No comments</p>
                                                    </td>
                                                    <td>
                                                        <button v-if="selectedRow !== index" class="btn btn-success"
                                                                @click="toggleRow(index)">
                                                            Comment
                                                        </button>
                                                        <button v-if="selectedRow === index" class="btn btn-primary"
                                                                @click="submitComment(feedback.id, comment)">
                                                            Submit
                                                        </button>
                                                        <div v-if="selectedRow === index">
                                                            <vue-editor v-model="comment" :editorToolbar="customToolbar"
                                                                        ref="editor"
                                                                        style="height:150px; margin-bottom:50px; min-width: 200px"
                                                                        id="mentionIntegration"
                                                                        placeholder="Enter @ to mention someone"></vue-editor>

                                                            <ejs-mention target="#mentionIntegration"
                                                                         :dataSource="users"
                                                                         :fields="commentsField"></ejs-mention>

                                                            <p v-if="commentErrors.length">
                                                                <ul>
                                                                    <li v-for="commentError in commentErrors"
                                                                        style="color:red;">{{ commentError }}
                                                                    </li>
                                                                </ul>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <pagination :data="feedbacks"
                                                        @pagination-change-page="get_feedback"></pagination>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Left Text-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h3 class="card-title fw-bold mb-1">Your feedbacks are welcome!</h3>
                                <div class="auth-login-form mt-2">
                                    <div class="mb-1">
                                        <label class="form-label">Feedback Title</label>
                                        <input type="text" v-model="title" class="form-control"
                                               placeholder="Enter feedback title">
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Category</label>
                                        <multiselect value="id" label="name" placeholder="Select category"
                                                     v-model="category"
                                                     :options="catagories">
                                        </multiselect>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Feedback Text</label>
                                        <textarea v-model="feedbackContent" placeholder="Enter feedback"
                                                  class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="row">
                                        <button type="button"
                                                class="btn btn-primary w-50 waves-effect waves-float waves-light"
                                                @click="submit_feedback()">Submit
                                        </button>
                                    </div>
                                    <p v-if="errors.length">
                                        <b>Please correct the following error(s):</b>
                                        <ul>
                                            <li v-for="error in errors" style="color:red;">{{ error }}</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>

<script>
import {VueEditor} from 'vue2-editor';
import {MentionComponent} from '@syncfusion/ej2-vue-dropdowns';

export default {
    components: {
        VueEditor,
        'ejs-mention': MentionComponent,
    },
    data() {
        return {
            commentsField: {text: 'name'},

            customToolbar: [
                ['bold', 'italic', 'underline'],
                ['blockquote', 'code-block'],
            ],
            catagories: [],
            users: [],
            errors: [],
            commentErrors: [],

            feedbacks: {},

            title: '',
            category: '',
            feedbackContent: '',

            index: 0,
            selectedRow: -1,
            comment: '',

            mentionUsersList: [],
        };
    },
    methods: {
        logout() {
            axios.post('/logout')
                .then(response => {
                    localStorage.removeItem('accessToken');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error logging out:', error);
                });
        },
        submit_feedback() {
            this.errors = [];
            !this.title ? this.errors.push('Feedback Title is required.') : null;
            !this.category.id ? this.errors.push('Category is required.') : null;
            !this.feedbackContent ? this.errors.push('Feedback Content is required.') : null;

            if (this.errors.length > 0) {
                return;
            } else {
                axios.post('./submit_feedback', {
                    title: this.title,
                    category: this.category.id,
                    feedbackContent: this.feedbackContent,
                })
                    .then(data => {
                        if (data.data.message === "success") {
                            this.feedbacks = data.data.data;
                            this.title = '';
                            this.category = null;
                            this.feedbackContent = '';
                        }
                    })
                    .catch(error => {
                        alert(error.response.statusText);
                        console.error('Error submitting feedback:', error.response.data.message);
                    })
            }
        },
        get_feedback(page = 1) {
            axios.get('/get_feedback?page=' + page)
                .then(response => {
                    this.feedbacks = response.data;
                })
                .catch(error => {
                    console.error('Error fetching feedback data:', error);
                });
        },
        toggleRow(index) {
            this.selectedRow = (this.selectedRow === index) ? -1 : index;
        },
        submitComment(feedbackId, comment) {
            this.selectedRow = -1;
            this.commentErrors = [];
            !feedbackId ? this.commentErrors.push('Commenting on invalid feedback') : null;
            !comment ? this.commentErrors.push('Comment is required.') : null;

            if (this.commentErrors.length > 0) {
                return;
            } else {
                axios.post('/insert_comment', {
                    feedback_id: feedbackId,
                    comment_text: comment
                })
                    .then(response => {
                        if (response.data.message === 'success') {
                            this.feedbacks = response.data.data;
                            this.comment = '';
                        }
                    })
                    .catch(error => {
                        alert(error.response.statusText);
                        console.error('Error submitting comment:', error.response.data.message);
                    });
            }
        },
    },
    mounted() {
        this.get_feedback();
        axios.get('get_users')
            .then(data => {
                this.users = data.data.users;
            })
            .catch(error => {
            });

        axios.get('get_catagories')
            .then(data => {
                let raw_catagories = data.data;
                this.catagories = [];
                this.catagories = raw_catagories.map((obj) => ({
                    id: obj.id,
                    name: obj.name,
                }));
            })
            .catch(error => {
            });
    }
}
</script>
<style>
.sticky-th-center {
    z-index: 1;
    position: sticky;
    position: -webkit-sticky;
    top: 0px;
    text-align: center;
    vertical-align: middle !important;
    background-color: #f3f2f7 !important;
}

.sticky-th-left {
    z-index: 1;
    position: sticky;
    top: 0px;
    text-align: left;
    vertical-align: middle !important;
}

.fix-header {
    overflow-x: initial !important;
}

@media (max-width: 500px) {
    .fix-header {
        overflow-x: auto !important;
    }
}
</style>
<style scoped>
.mention-list {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    z-index: 999;
}

.mention-list ul {
    list-style: none;
    padding: 0;
}

.mention-list li {
    cursor: pointer;
    padding: 5px 10px;
}

.mention-item {
    padding: 4px 10px;
    border-radius: 4px;
}

.mention-selected {
    background: rgb(192, 250, 153);
}
</style>
<style src="../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css"></style>
