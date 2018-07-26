<template>
  <div>
    <span class="small-caps">{{ label }}</span>
    <span class="lead text-muted">{{ data }}</span>
  </div>
</template>

<script>
  export default {
    name: 'labeled-data',
    props: [ 'label', 'data' ]
  }
</script>

<style scoped>
  .small-caps {
    font-size: 10px;
    text-transform: uppercase;
    margin-bottom: -5px;
    display: block;
  }
</style>