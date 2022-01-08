<template>
    <div>
    <div v-if="$store.state.user">
      <div class="_1side_menu" >
        <div class="_1side_menu_logo">
          <h3 style="text-align:center;">DEMO APP</h3>
        </div>
        <div class="_1side_menu_content">
          <div class="_1side_menu_list">
            <ul class="_1side_menu_list_ul">
                <li><router-link to="/">Products</router-link></li>
                <li><a href="/logout">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="header">
        <div class="_2menu _box_shadow">
          <div class="_2menu_logo">
            <ul class="open_button">
              <li>
                <Icon type="ios-list" />
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    	<router-view/>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data(){
       return {
          isLoggedIn : false,
       }
    },
    created(){
       this.$store.commit('setUpdateUser', this.user)
    }
}
</script>
