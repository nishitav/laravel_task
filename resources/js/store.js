import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        deleteModalObj : {
            showDeleteModal: false,
            deleteUrl : '',
            data : null,
            deletingIndex: -1,
            deletingIndexs: [],
            isDeleted : false,
        },
        user: false,
    },
    getters: {
        getDeleteModalObj(state){
            return state.deleteModalObj
        },
    },
    mutations: {
        setDeleteModal(state, data){
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl : '',
                data : null,
                deletingIndex: -1,
                isDeleted : data,
                deletingIndexs: [],
            }
            state.deleteModalObj = deleteModalObj
        },
        setUpdateUser(state, data){
            state.user = data
        },
        setDeletingModalObj(state, data){
            state.deleteModalObj = data;
            console.log(state.deleteModalObj);
        },
    },
    actions :{
    }
})
