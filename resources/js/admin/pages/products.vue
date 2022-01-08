<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        Products
                        <Button @click="addModal=true" style="float: right;margin-left: 5px;">
                            <Icon type="md-add" />Add Product
                        </Button>
                        <Button style="float: right"
                                type="error"
                                @click="showManyDeletingModal()"
                                >Delete Selected</Button>

                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>UPC</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(product, i) in productLists" :key="product.id" v-if="productLists.length">
                                <td><input @change="onChecked(i)" type="checkbox"  class="products-checkbox" :value="product.id" v-model="checkedProductIds"/></td>
                                <td class="">{{product.id}}</td>
                                <td class="">{{product.name}}</td>
                                <td class="">{{product.upc}}</td>
                                <td class="">{{product.price}}</td>
                                <td v-if="product.status"><span class="badge badge-success">Enabled</span></td>
                                <td  v-else><span class="badge badge-danger">Disabled</span></td>
                                <td class="table_image">
                                    <img :src="product.image" />
                                </td>
                                <td>
                                    <Button
                                        type="info"
                                        size="small"
                                        @click="showEditModal(product, i)"
                                        >Edit</Button>
                                    <Button
                                        type="error"
                                        size="small"
                                        @click="showDeletingModal(product, i)"
                                        :loading="product.isDeleting"
                                        >Delete</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!-- tag adding modal -->
                <Modal v-model="addModal" title="Add product" :mask-closable="false" :closable="false">
                    <label>Name</label>
                    <Input v-model="data.name" placeholder="Name" />
                    <div class="space"></div>
                    <label>UPC</label>
                    <Input v-model="data.upc" placeholder="UPC" />
                    <div class="space"></div>
                    <label>Price</label>
                    <Input v-model="data.price" placeholder="Price" />
                    <div class="space"></div>
                    <label>Status</label>
                    <select v-model="data.status" placeholder="Status" class="form-control">
                        <option value="">Select Status</option> 
                        <option value="1">Enable</option> 
                        <option value="0">Disable</option> 
                    </select>
                    <div class="space"></div>
                    <label>Image</label>
                    <Upload
                        ref="uploads"
                        type="drag"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg','jpeg','png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload"
                        >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="data.image">
                        <img :src="`${data.image}`" />
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteImage" ref="myDelBtn"></Icon>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button
                            type="primary"
                            @click="addProduct"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{isAdding ? 'Adding..' : 'Add Product'}}</Button>
                    </div>
                </Modal>
                <!-- tag editing modal -->
                <Modal v-model="editModal" title="Edit product" :mask-closable="false" :closable="false">
                    <label>Name</label>
                    <Input v-model="editData.name" placeholder="Name" />
                    <div class="space"></div>
                    <label>UPC</label>
                    <Input v-model="editData.upc" placeholder="UPC" />
                    <div class="space"></div>
                    <label>Price</label>
                    <Input v-model="editData.price" placeholder="Price" />
                    <div class="space"></div>
                    <label>Status</label>
                    <select  v-model="editData.status" placeholder="Status" class="form-control">
                        <option value="">Select Status</option> 
                        <option value="1">Enable</option> 
                        <option value="0">Disable</option> 
                    </select>
                    <div class="space"></div>
                    <label>Image</label>
                    <Upload
                        v-show="isIconImageNew"
                        ref="editDataUploads"
                        type="drag"
                        :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequest'}"
                        :on-success="handleSuccess"
                        :on-error="handleError"
                        :format="['jpg','jpeg','png']"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload"
                        >
                        <div style="padding: 20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                            <p>Click or drag files here to upload</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="editData.image">
                        <img :src="`${editData.image}`" />
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="closeEditModal">Close</Button>
                        <Button
                            type="primary"
                            @click="editProduct"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{isAdding ? 'Editing..' : 'Edit Product'}}</Button>
                    </div>
                </Modal>
                <deleteModal></deleteModal>
            </div>
        </div>
    </div>
</template>


<script>
    import deleteModal from "../components/deleteModal.vue";
    import { mapGetters } from "vuex";
    export default {
        data() {
            return {
                data: {
                    image: "",
                    name: "",
                    upc: "",
                    price: "",
                    status: "",
                },
                checkedProductIds: [],
                addModal: false,
                editModal: false,
                isAdding: false,
                productLists: [],
                selectedProductIds: [],
                editData: {
                    image: "",
                    name: "",
                    upc: "",
                    price: "",
                    status: "",
                },
                index: -1,
                showDeleteModal: false,
                showManyDeleteModal: false,
                isDeleing: false,
                deleteItem: {},
                deletingIndex: -1,
                deletingIndexs: [],
                token: "",
                isIconImageNew: false,
                isEditingItem: false,
                websiteSettings: []
            };
        },

        methods: {
            onChecked(id) {
                if (!this.selectedProductIds.includes(id)) {
                    this.selectedProductIds.push(id)
                } else {
                    this.selectedProductIds.splice(this.selectedProductIds.indexOf(id), 1)
                }

                console.log(this.selectedProductIds);
            },
            async addProduct() {

                if (this.data.name.trim() == "")
                    return this.e("Product name is required");
                if (this.data.upc.trim() == "")
                    return this.e("Product UPC is required");
                if (this.data.price.trim() == "")
                    return this.e("Product price is required");
                if (this.data.status.trim() == "")
                    return this.e("Product status is required");
                if (this.data.image.trim() == "")
                    return this.e("Product image is required");
                this.data.image = `${this.data.image}`;
                const res = await this.callApi("post", "app/create_product", this.data);
                if (res.status === 201) {
                    this.productLists.unshift(res.data);
                    this.s("Product has been added successfully!");
                    this.addModal = false;
                    this.data.name = "";
                    this.data.upc = "";
                    this.data.price = "";
                    this.data.status = "";
                    this.data.image = "";
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.name) {
                            this.e(res.data.errors.name[0]);
                        }
                        if (res.data.errors.upc) {
                            this.e(res.data.errors.upc[0]);
                        }
                        if (res.data.errors.price) {
                            this.e(res.data.errors.price[0]);
                        }
                        if (res.data.errors.image) {
                            this.e(res.data.errors.image[0]);
                        }
                    } else {
                        this.swr();
                    }
                }
            },
            async editProduct() {
                console.log("I AM CLLED");
                console.log(this.editData);
                if (this.editData.name.trim() == "")
                    return this.e("Product name is required");
                if (this.editData.upc.trim() == "")
                    return this.e("Product UPC is required");
                if (this.editData.price.trim() == "")
                    return this.e("Product price is required");
                if (this.editData.status == "")
                    return this.e("Product status is required");
                if (this.editData.image.trim() == "")
                    return this.e("Product image is required");
                const res = await this.callApi(
                        "post",
                        "app/edit_product",
                        this.editData
                        );
                if (res.status === 200) {
                    this.productLists[
                            this.index
                    ].name = this.editData.name;
                    this.productLists[
                            this.index
                    ].upc = this.editData.upc;
                    this.productLists[
                            this.index
                    ].price = this.editData.price;
                    this.productLists[
                            this.index
                    ].status = this.editData.status;
                    this.s("Product has been edited successfully!");
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.name) {
                            this.e(res.data.errors.name[0]);
                        }
                        if (res.data.errors.upc) {
                            this.e(res.data.errors.upc[0]);
                        }
                        if (res.data.errors.price) {
                            this.e(res.data.errors.price[0]);
                        }
                        if (res.data.errors.image) {
                            this.e(res.data.errors.image[0]);
                        }
                        if (res.data.errors.status) {
                            this.e(res.data.errors.status[0]);
                        }
                    } else {
                        this.swr();
                    }
                }
            },
            showEditModal(product, index) {
                console.log(product);
                this.editData = product;
                this.editModal = true;
                this.index = index;
                this.isEditingItem = true;
            },

            showDeletingModal(product, i) {
                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl: "app/delete_product",
                    data: product,
                    deletingIndex: i,
                    deletingIndexs: [],
                    isDeleted: false
                };
                this.$store.commit("setDeletingModalObj", deleteModalObj);
            },
            showManyDeletingModal() {
                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl: "app/delete_products",
                    data: this.checkedProductIds,
                    deletingIndex: false,
                    deletingIndexs: this.selectedProductIds,
                    isDeleted: false
                };
                console.log(this.checkedProductIds);
                this.$store.commit("setDeletingModalObj", deleteModalObj);
                console.log(this.selectedProductIds);
            },

            handleSuccess(res, file) {
                res = `/uploads/${res}`;
                if (this.isEditingItem) {
                    return (this.editData.image = res);
                } else {
                    this.data.image = res;
                }
            },
            handleError(res, file) {
                this.$Notice.warning({
                    title: "The file format is incorrect",
                    desc: `${
                            file.errors.file.length
                            ? file.errors.file[0]
                            : "Something went wrong!"
                            }`
                });
            },
            handleFormatError(file) {
                this.$Notice.warning({
                    title: "The file format is incorrect",
                    desc:
                            "File format of " +
                            file.name +
                            " is incorrect, please select jpg or png."
                });
            },
            handleMaxSize(file) {
                this.$Notice.warning({
                    title: "Exceeding file size limit",
                    desc: "File  " + file.name + " is too large, no more than 2M."
                });
            },
            async deleteImage(isAdd = true) {
                let image;

                if (!isAdd) {
                    this.isIconImageNew = true;
                    image = this.editData.image;
                    this.editData.image = "";
                    this.$refs.editDataUploads.clearFiles();
                } else {
                    image = this.data.image;
                    this.data.image = "";
                    this.$refs.uploads.clearFiles();
                }

                const res = await this.callApi("post", "app/delete_image", {
                    imageName: image
                });
                if (res.status != 200) {
                    this.data.image = image;
                    this.swr();
            }
            },
            closeEditModal() {
                this.isEditingItem = false;
                this.editModal = false;
            }
        },

        async created() {
            this.token = window.Laravel.csrfToken;
            const res = await this.callApi("get", "app/get_products");
            if (res.status == 200) {
                this.productLists = res.data;
            } else {
                this.swr();
            }
        },
        components: {
            deleteModal,
        },
        computed: {
            ...mapGetters(["getDeleteModalObj"]),
        },
        watch: {
            getDeleteModalObj(obj) {
                if (obj.isDeleted) {
                    if (this.selectedProductIds.length > 0) {
                        this.selectedProductIds.sort(function(a, b) {
                            return a - b;
                        });
                        var counter = 0;
                        this.selectedProductIds.forEach((value, index) => {
                            this.productLists.splice(value - counter, 1);
                            counter++;
                        });
                    } else {
                        this.productLists.splice(obj.deletingIndex, 1);
                    }
                    this.selectedProductIds = [];
                }
            }
        }
    };
</script>
