<template>
	<router-view></router-view>
</template>
<script>

	export default {
		ready () {
			this.getUserInfo()
		},
		components: {
		},
		data(){
			return {
				user: [],
			}
		},
		methods: {
			getUserInfo(){
				this.$http({url: '/user/me.json', method: 'GET'}).then(function (response) {
					this.$set('user', response.data.account)
				})
			}
		},
		replace: false
	}
</script>