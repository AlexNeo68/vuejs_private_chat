<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">Friends</div>

          <ul class="list-group">
            <li class="list-group-item">
              Friend 1
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-9">
        <message-component
          @close="open=false"
          v-if="open"
        />
      </div>
    </div>
  </div>
</template>

<script>
import MessageComponent from "./MessageComponent.vue";
export default {
  components: { MessageComponent },
  data() {
    return {
      open: true,
    };
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
