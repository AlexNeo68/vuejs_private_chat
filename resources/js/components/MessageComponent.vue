<template>
  <div class="card chat-box">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3
        class="mb-0"
        :class="{'text-danger': blockSession}"
      >{{ friend.name }}
        <span v-if="blockSession">(blocked)</span>
        <span v-if="isTyping"> is Typing ...</span>
      </h3>
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
                v-else-if="canSessionUnBlock"
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
        <div
          class="mb-2"
          :class="{'text-end': chat.type == 0, 'text-success': chat.type == 0 && chat.read_at}"
        >
          <div class="mb-0">{{chat.message}}</div>
          <small
            class="fw-lighter lh-1"
            v-if="chat.type == 0 && chat.read_at"
          >{{chat.read_at}}</small>
        </div>
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
            v-model="message"
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
      message: "",
      isTyping: false,
    };
  },
  computed: {
    blockSession() {
      return this.friend.session && this.friend.session.block;
    },
    canSessionUnBlock() {
      return authId == this.friend.session.blocked_by;
    },
  },
  methods: {
    async send() {
      try {
        const newChat = await axios.post(`/send/${this.friend.session.id}`, {
          content: this.message,
          user_to: this.friend.id,
        });
        this.chats.push(newChat.data.data);
      } catch (error) {
        console.log(error);
      } finally {
        this.message = "";
      }
    },
    async clear() {
      try {
        await axios.delete(`/sessions/${this.friend.session.id}/clear`);
        this.chats = [];
      } catch (error) {
        console.log(error);
      }
    },
    async block() {
      try {
        await axios.post(`/sessions/${this.friend.session.id}/block`);
        this.friend.session.block = true;
        this.friend.session.blocked_by = authId;
      } catch (error) {
        console.log(error);
      }
    },
    async unblock() {
      try {
        await axios.post(`/sessions/${this.friend.session.id}/unblock`);
        this.friend.session.block = false;
        this.friend.session.blocked_by = null;
      } catch (error) {
        console.log(error);
      }
    },
    async getAllMessages() {
      try {
        const res = await axios.get(
          `/sessions/${this.friend.session.id}/chats`
        );
        this.chats = res.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async read() {
      try {
        await axios.post(`/sessions/${this.friend.session.id}/read`);
      } catch (error) {
        console.log(error);
      }
    },
  },
  watch: {
    message(value) {
      if (value) {
        Echo.private(`Session.${this.friend.session.id}`).whisper("typing", {
          name: "SAnya",
        });
      }
    },
  },
  created() {
    this.read();
    this.getAllMessages();
    Echo.private(`Session.${this.friend.session.id}`).listen(
      "PrivateChatEvent",
      (e) => {
        this.chats.push({
          id: e.chat.id,
          message: e.chat.message,
          type: 1,
          send_at: e.chat.send_at,
          read_at: null,
        });
        this.read();
      }
    );
    Echo.private(`Session.${this.friend.session.id}`).listen(
      "MessageReadEvent",
      (e) => {
        this.chats = this.chats.map((chat) => {
          if (chat.id == e.chat.id) {
            chat.read_at = e.chat.read_at;
          }
          return chat;
        });
      }
    );

    Echo.private(`Session.${this.friend.session.id}`).listen(
      "SessionBlockEvent",
      (e) => {
        this.friend.session.block = e.session.block;
        this.friend.session.blocked_by = e.session.blocked_by;
      }
    );

    Echo.private(`Session.${this.friend.session.id}`).listenForWhisper(
      "typing",
      (e) => {
        this.isTyping = true;
        setTimeout(() => {
          this.isTyping = false;
        }, 2000);
      }
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

