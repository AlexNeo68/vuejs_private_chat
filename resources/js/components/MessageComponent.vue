<template>
  <div class="card chat-box">
    <div class="card-header">
      Messages
      <button
        @click="$emit('close')"
        class="btn btn-danger float-end"
      ><i class='bx bxs-message-square-x'></i></button>
    </div>
    <div
      class="card-body"
      v-chat-scroll
    >
      <div
        v-for="(chat, i) in chats"
        :key="`chat-number-${i}`"
      >
        <div>{{chat.message}}</div>
      </div>
    </div>
    <div class="card-footer">
      <form
        action=""
        class="form"
        @submit.prevent="send"
      >
        <div class="form-group">
          <input
            type="text"
            class="form-control"
            placeholder="Write your message"
          >
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  name: "MessageComponent",
  data() {
    return {
      chats: [],
    };
  },
  methods: {
    send() {
      console.log("Yaah");
    },
  },
  created() {
    this.chats.push(
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Message" },
      { message: "Last Message" }
    );
  },
};
</script>
<style scoped>
.chat-box {
  height: 400px;
}
.card-body {
  overflow-y: scroll;
}
</style>

