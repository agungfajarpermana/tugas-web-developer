<template>
  <div class="container-fluid">
    <h1 class="text-center text-info">
      <strong>Biodata Calon Karyawan</strong>
    </h1>
    
    <br>

    <Viewer/>
  </div>
</template>

<script>
  import Viewer from './Viewer.vue';

  export default {
    name: 'title-header',
    components: {
      Viewer
    }
  }
</script>
