<template>
  <div
    class="container m-3 p-2"
    :class="[dialogData.estate === 'show' ? 'show' : 'hidden']"
  >
    <div class="m-2 p-3">Comformation</div>
    <div>Are you sure you want to accept this request ?</div>
    <b-col>
      <b-row>
        <b-button @click.prevent="onYes">Yes</b-button>
      </b-row>
      <b-row>
        <b-button @click.prevent="onNo">No </b-button>
      </b-row>
    </b-col>
  </div>
</template>
<script>
export default {
  props: ["dialogData"],
  watch:{
      dialogData:function(nV,oL){
          alert(nV.state);
      }
  },
  methods: {
    onYes() {
      // response to this request
    },
    onNo() {
      this.$props.dialogData.estate = "hidden";
    },
  },
};
</script>
<style scoped>
.show{
    display: block !important;
}
.hidden{
    display: none !important;
}
</style>