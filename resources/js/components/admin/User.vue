<template>
    <div v-if="showSuccessMsg">
        <alert-message :successMsg="this.successMsg"></alert-message>
    </div>
    <div class="row w-100 mx-auto justify-content-center">
        <div class="col-md-12">
            <div class="row mx-auto w-100 g-0">
                <div class="col-md-12 my-2 my-md-auto text-end">
<!--                    <modal :button-name="'Add User'" :functionAction="1"></modal>-->
                    <button type="button"
                            class="btn padding-button-cancel px-4 bg-button font-14 text-label rounded-8 border-0"
                            data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                        <img :src="'../assets/images/plus.svg'" width="10" alt=""> Add User
                    </button>
                    <div class="modal fade" id="modalCreateUser" aria-hidden="true"
                         aria-labelledby="exampleModalLabel" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content bg-main mx-md-5 rounded-top-20 rounded-bottom-20">
                                <div class="modal-header bg-linear rounded-top-20 border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabel">Create a user</h5>
                                    <button type="button" class="btn border-0 p-0 ms-auto" id="CloseCreateUser"
                                            data-bs-dismiss="modal" aria-label="Close">
                                        <img :src="'../assets/images/icons8-cancel-30.png'" width="16" alt="">
                                    </button>
                                </div>
                                <div class="modal-body px-4 py-2 bg-main rounded-bottom-20 text-start">
                                    <form @submit.prevent="AddUser" method="post" enctype="multipart/form-data"
                                          class="mx-2">
                                        <div class="form-group mb-0 text-center">
                                            <div id="file-upload-filename"
                                                 class="text-right text-truncate w-75 name-file-upload position-absolute"></div>
                                            <label for="file-upload-communication-comments-create"
                                                   class="btn text-muted text-center p-1 mb-0 mx-auto position-relative bg-image-border p-0 bg-sub shadow-sm">
                                                <img id="selected-image" class="w-100 h-100 object-fit-cover" style="display:none;" src="" alt="">
                                            </label>
                                            <small class="text-muted d-block py-2 font-12 fw-light">Click to Add Your Profile Image</small>

                                            <input type="file" v-on:change="selectedFile" class="input-file start-0 file-upload-communication-comments-create"
                                                   id="file-upload-communication-comments-create"/>
                                            <div class="file-upload-filename-communication-comments-create mx-auto w-100 text-truncate"></div>
                                            <span v-if="flashMsg.image"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.image[0] }}</span>

                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Name</label>
                                            <input type="text" v-model="user.name"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.name" class="text-danger font-12 fw-400">{{ flashMsg.name[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Number System</label>
                                            <input type="text" v-model="user.num_system"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.num_system" class="text-danger font-12 fw-400">{{ flashMsg.num_system[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Email</label>
                                            <input type="email" v-model="user.email"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.email"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.email[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Phone</label>
                                            <input type="text" v-model="user.phone"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.phone" class="text-danger font-12 fw-400">{{ flashMsg.phone[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Password</label>
                                            <input type="password" v-model="user.password"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.password"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.password[0] }}</span>
                                        </div>
                                        <div class="text-center my-2">
                                            <button type="submit"
                                                    class="btn px-4 bg-button font-14 text-label rounded-10 border-0">
                                                <span>Create</span><i v-if="loading_create" class="fas fa-spinner ms-1 fa-spin text-white"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditUser" aria-hidden="true"
                         aria-labelledby="exampleModalLabel" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content bg-main mx-md-5 rounded-top-20 rounded-bottom-20">
                                <div class="modal-header bg-linear rounded-top-20 border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabelEditUser">Edit a user</h5>
                                    <button type="button" class="btn border-0 p-0 ms-auto" id="CloseEditUser"
                                            data-bs-dismiss="modal" aria-label="Close">
                                        <img :src="'../assets/images/icons8-cancel-30.png'" width="16" alt="">
                                    </button>
                                </div>
                                <div id="updateUser_easy" class="modal-body px-4 py-2 bg-main rounded-bottom-20 text-start">
                                    <form @submit.prevent="UpdateUser" method="post" enctype="multipart/form-data"
                                          class="mx-2">
                                        <div class="form-group mb-0 text-center">
                                            <div id="file-upload-filename"
                                                 class="text-right text-truncate w-75 name-file-upload position-absolute"></div>
                                            <label for="file-upload-communication-comments-update"
                                                   class="btn text-muted text-center p-1 mb-0 mx-auto position-relative bg-image-border p-0 bg-sub shadow-sm">
                                                <img id="selected-update-image" v-if="users_update.image == null" class="w-100 h-100 object-fit-cover" style="display:none;" src="" alt="">
                                                <img id="selected-update-image" v-else class="w-100 h-100 object-fit-cover" :src="'../storage/'+users_update.image" alt="">
                                            </label>
                                            <small class="text-muted d-block py-2 font-12 fw-light">Click to Add Your Profile Image</small>

                                            <input type="file" v-on:change="selectedFileEdit" class="input-file start-0 file-upload-communication-comments-create"
                                                   id="file-upload-communication-comments-update"/>
                                            <div class="file-upload-filename-communication-comments-create mx-auto w-100 text-truncate"></div>
                                            <span v-if="flashMsg.image"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.image[0] }}</span>

                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 form-label font-14">Name</label>
                                            <input type="text" v-model="users_update.name"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.name" class="text-danger font-12 fw-400">{{ flashMsg.name[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 form-label font-14">Number System</label>
                                            <input type="text" v-model="users_update.num_system"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.num_system" class="text-danger font-12 fw-400">{{ flashMsg.num_system[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Email</label>
                                            <input type="email" v-model="users_update.email"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.email"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.email[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 form-label font-14">Phone</label>
                                            <input type="text" v-model="users_update.phone"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.phone" class="text-danger font-12 fw-400">{{ flashMsg.phone[0] }}</span>
                                        </div>
                                        <div class="form-group mb-3 text-start">
                                            <label class="fw-400 text-label font-14">Password</label>
                                            <input type="password" v-model="users_update.password"
                                                   class="form-control shadow-input mt-2 border-transparent bg-sub font-14 text-muted">
                                            <span v-if="flashMsg.password"
                                                  class="text-danger font-12 fw-400">{{ flashMsg.password[0] }}</span>
                                        </div>
                                        <div class="text-center my-2">
                                            <button type="submit"
                                                    class="btn px-4 bg-button font-14 text-label rounded-10 border-0">
                                                <sapn>Update</sapn><i v-if="loading_update" class="fas fa-spinner ms-1 fa-spin text-white"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalDeleteUser" aria-hidden="true"
                         aria-labelledby="exampleModalLabel" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content bg-main mx-md-5 rounded-top-20 rounded-bottom-20">
                                <div class="modal-header bg-linear rounded-top-20 border-bottom-0">
                                    <h5 class="modal-title" id="exampleModalLabelDeleteUser">Delete a user</h5>
                                    <button type="button" class="btn border-0 p-0 ms-auto" id="CloseDeleteUser"
                                            data-bs-dismiss="modal" aria-label="Close">
                                        <img :src="'../assets/images/icons8-cancel-30.png'" width="16" alt="">
                                    </button>
                                </div>
                                <div class="modal-body px-4 py-2 bg-main rounded-bottom-20 text-start">
                                    <h5 class="text-center mb-0">Are you sure to delete this user ?</h5>
                                </div>
                                <div class="modal-footer border-0 bg-main justify-content-center">
                                    <button type="button" class="btn btn-secondary close-btn ms-auto"
                                            data-bs-dismiss="modal">Cancel
                                    </button>
                                    <button type="button" @click="DestroyUser" class="btn btn-danger"><span>Yes, delete</span><i v-if="loading_delete" class="fas fa-spinner ms-1 fa-spin text-white"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-sub shadow-input px-3 py-3 mt-3 rounded-top-4 overflow-auto">
                <div class="d-flex mx-auto w-100">
                    <div class="w-10 my-2 my-md-auto text-center ps-2">
                        <h5 class="text-label font-16 mb-0">#</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2">
                        <h5 class="text-label font-16 mb-0">Image</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2">
                        <h5 class="text-label font-16 mb-0">Name</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2">
                        <h5 class="text-label font-16 mb-0">Number System</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2 ">
                        <h5 class="text-label font-16 mb-0">Email</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2 ">
                        <h5 class="text-label font-16 mb-0">Phone</h5>
                    </div>
                    <div class="w-20 my-2 my-md-auto text-center ps-2">
                        <h5 class="text-label font-16 mb-0">Action</h5>
                    </div>

                </div>
            </div>
            <div class="h-default">
                <div class="bg-sub shadow-input px-3 py-3 my-4 rounded-top-4 overflow-auto "
                     v-for="(user, index) in users" :key="user.id">
                    <div class="d-flex mx-auto w-100">
                        <div class="w-10 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">{{ index + 1 }}</h5>
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center">
                            <img :src="user.image ? '../storage/'+user.image : '../assets/images/logo.png'"
                                 :width="'35'" class="align-middle " alt="">
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">{{ user.name }}</h5>
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">{{ user.num_system }}</h5>
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">{{ user.email }}</h5>
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">{{ user.phone }}</h5>
                        </div>
                        <div class="w-20 my-2 my-md-auto text-center ps-2">
                            <h5 class="text-label font-14 mb-0">
                                <button type="button" class="mx-2 bg-transparent border-0" data-bs-toggle="modal"
                                        @click="editUser(user.id, index)"
                                        :data-bs-target="'#modalEditUser'">
                                    <img :src="'../assets/images/edit.svg'" width="16" alt="">
                                </button>
                                <button type="button" class="mx-2 bg-transparent border-0" data-bs-toggle="modal"
                                        @click="deleteUser(user.id, index)"
                                        :data-bs-target="'#modalDeleteUser'">
                                    <img :src="'../assets/images/delete.svg'" width="16" alt="">
                                </button>
                            </h5>
                        </div>
                    </div>
                </div>
                <div v-if="this.loading === true" id="loader" class="w-100 text-center mt-4">
                    <i class="fas fa-spinner fa-spin fa-2x" style="color: #797D90;"></i>
                </div>
                <button type="button" class="btn d-block text-center text-white font-14 fw-400 mx-auto" v-if="!this.finished && !this.loading" @click="plusPage()">Show More</button>
            </div>
        </div>
    </div>
</template>

<script>
import {reactive} from "vue/dist/vue.esm-bundler";
import AlertMessage from "../layout/alertMessage.vue";
import Modal from "../layout/modal.vue";

export default {
    components: {Modal, AlertMessage},
    props: [
        'users_data',
        'users_add',
        'users_edit',
        'users_delete',
        'users_show',
    ],
    data() {
        const user = reactive({
            name: '',
            password: '',
            email: '',
            phone: '',
            num_system: '',
        })

        const del_id = null;

        return {
            users: [],
            users_update: [],
            user,
            flashMsg: [],
            showModal: false,
            loading: false,
            loading_data: false,
            loading_delete: false,
            loading_update: false,
            loading_create: false,
            del_id,
            showSuccessMsg: false,
            successMsg: '',
            image: '',
            finished: false,
            page: 1,
            key_index: null,
        }
    },

    methods: {
        async plusPage(){
            this.page++;
            this.getUser()
        },
        async getUser() {
            this.loading = true;
            axios.post(this.users_data + '?page=' + this.page)
                .then(response => {
                    this.users = this.users.concat(response.data.data.data);
                    this.loading = false;
                    if (response.data.data_count === this.users.length) {
                        this.finished = true;
                    }
                })
                .catch((err) => {
                    this.loading = false;
                    console.log(err);
                });
        },
        async AddUser() {
            document.getElementById("selected-image").src = "";
            document.getElementById('selected-image').style.display = 'none';
            this.loading_create = true;
            let formData = new FormData();
            formData.append('image', this.image);
            formData.append('email', this.user.email);
            formData.append('name', this.user.name);
            formData.append('num_system', this.user.num_system);
            formData.append('phone', this.user.phone);
            formData.append('password', this.user.password ? this.user.password : '');
            const config = {
                headers: {'content-type': 'multipart/form-data'}
            }
            axios.post(this.users_add, formData, config)
                .then((res) => {
                    localStorage.setItem('name', res.data.name);
                    if (this.users.length + 1 === res.data.data_count) {
                        this.users.push(res.data.data)
                    }
                    this.showModal = false;
                    this.user = []
                    this.image = ''
                    document.getElementById('CloseCreateUser').click();
                    this.loading_create = false;
                    if (res.data.status == 200 && res.data.success == true) {
                        this.showSuccessMsg = true;
                        this.successMsg = res.data.message;
                        setTimeout(() => this.showSuccessMsg = false, 2500);
                    }
                    this.flashMsg = ''
                })
                .catch((err) => {
                    this.loading_create = false;
                    console.log(err)
                    this.flashMsg = err.response.data.message;
                });
        },
        selectedFile(e) {
            this.image = e.target.files[0];
            document.getElementById("selected-image").src= URL.createObjectURL(this.image);
            // Show the image
            document.getElementById('selected-image').style.display = 'block';
            },
        selectedFileEdit(event) {
            this.image = event.target.files[0];
            document.getElementById("selected-update-image").src= URL.createObjectURL(this.image);
            document.getElementById('selected-update-image').style.display = 'block';
        },
        async editUser(id, index) {
            document.getElementById('updateUser_easy').style.opacity='0';
            this.flashMsg = '';
            this.loading_data = true;
            axios.post(this.users_show + '/' + id)
                .then((res) => {
                    this.users_update = res.data;
                    this.key_index = index;
                    this.loading_data = false;
                    document.getElementById('updateUser_easy').style.transition='1.2s ease';
                    document.getElementById('updateUser_easy').style.opacity='1';
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async UpdateUser() {
            this.loading_update = true;
            let formDataEdit = new FormData();
            formDataEdit.append('image', this.image);
            formDataEdit.append('email', this.users_update.email);
            formDataEdit.append('name', this.users_update.name);
            formDataEdit.append('num_system', this.users_update.num_system);
            formDataEdit.append('phone', this.users_update.phone);
            formDataEdit.append('password', this.users_update.password ? this.users_update.password : '');
            const config = {
                headers: {'content-type': 'multipart/form-data'}
            }
            axios.post(this.users_edit + '/' + this.users_update.id, formDataEdit, config)
                .then((res) => {
                    localStorage.setItem('name', res.data.name);
                    this.users[this.key_index] = res.data.data;
                    this.users[this.key_index].id = res.data.id;
                    this.key_index = null;
                    document.getElementById('CloseEditUser').click();
                    document.getElementById('updateUser_easy').style.opacity='0';
                    this.loading_update = false;
                    if (res.data.status == 200 && res.data.success == true) {
                        this.showSuccessMsg = true;
                        this.successMsg = res.data.message;
                        setTimeout(() => this.showSuccessMsg = false, 2500);
                    }
                    this.flashMsg = ''
                })
                .catch((err) => {
                    this.loading_update = false;
                    console.log(err);
                    this.flashMsg = err.response.data.message;
                });
        },
        async deleteUser(id, index) {
            this.del_id = id;
            this.key_index = index;
        },
        async DestroyUser() {
            this.loading_delete = true;
            axios.post(this.users_delete + '/' + this.del_id, this.user)
                .then((res) => {
                    localStorage.setItem('name', res.data.name);
                    this.users.splice(this.key_index, 1)
                    document.getElementById('CloseDeleteUser').click();
                    if (res.data.status == 200 && res.data.success == true) {
                        this.loading_delete = false;
                        this.showSuccessMsg = true;
                        this.successMsg = res.data.message;
                        setTimeout(() => this.showSuccessMsg = false, 2500);
                    }
                })
                .catch((err) => {
                    this.loading_delete = false;
                    console.log(err);
                    this.flashMsg = err.response.data.message;
                });
        }
    },
    async created() {
        this.getUser();
        this.__ = window.__;
    },
}
</script>
