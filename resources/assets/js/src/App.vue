<template>
  <div id="app">
    <TopMenu />
    <router-view />
  </div>
</template>

<script>
import TopMenu from './components/partials/TopMenu'

export default {
  name: 'app',
  components: {
    TopMenu
  }
}
</script>

<style>
@import 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
</style>
