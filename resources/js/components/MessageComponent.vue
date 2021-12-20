<template>
  <div class="card chat-box">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3
        class="mb-0"
        :class="{'text-danger': blockSession}"
      >{{ friend.name }} <span v-if="blockSession">(blocked)</span></h3>
      <div class="d-flex mr-4">
        <div class="dropdown">
          <a
            id="dropdownMenuButton1"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class='bx bx-dots-vertical-rounded bx-sm'></i>
          </a>
          <ul
            class="dropdown-menu"
            aria-labelledby="dropdownMenuButton1"
          >
            <li><a
                class="dropdown-item"
                href="#"
                @click="clear"
              >Clear Chat</a></li>
            <li>
              <a
                class="dropdown-item"
                href="#"
                v-if="!blockSession"
                @click="block"
              >Block</a>
              <a
                class="dropdown-item"
                href="#"
                @click="unblock"
                v-else
              >UnBlock</a>
            </li>
          </ul>
        </div>
        <a
          @click="$emit('close')"
          class=""
        ><i class='bx bxs-message-square-x bx-sm'></i></a>
      </div>

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
            :disabled="blockSession"
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
  props: ["friend"],
  data() {
    return {
      chats: [],
      blockSession: false,
    };
  },
  methods: {
    send() {
      console.log("Yaah");
    },
    clear() {
      this.chats = [];
    },
    block() {
      this.blockSession = true;
    },
    unblock() {
      this.blockSession = false;
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

