<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">Friends</div>

          <ul class="list-group">
            <li
              class="list-group-item d-flex justify-content-between align-items-center"
              v-for="(friend, index) in friends"
              :key="`friend-${index}`"
            >
              <div>
                <a
                  href="#"
                  @click.prevent="openChat(friend)"
                >{{friend.name}}</a>
                <span
                  class="text-danger ml-2"
                  v-if="friend.session&&friend.session.unread_chats_count"
                >({{friend.session.unread_chats_count}})</span>
              </div>

              <i
                class='bx bxs-circle text-success'
                v-if="friend.online"
              ></i>
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-9">
        <div
          v-for="(friend, index) in friends"
          :key="`chat-box-${index}`"
        >
          <message-component
            @close="close(friend)"
            v-if="friend.session&&friend.session.open"
            :friend="friend"
          />
        </div>
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
      friends: [],
    };
  },
  created() {
    this.getFriends();
    Echo.channel("Chat").listen("SessionEvent", (e) => {
      this.friends = this.friends.map((friend) => {
        if (friend.id == e.session_by) {
          friend.session = e.session;
          this.listenForEverySession(friend);
        }
        return friend;
      });
    });
    Echo.join(`Chat`)
      .here((users) => {
        this.friends = this.friends.map((friend) => {
          users.forEach((user) => {
            friend.online = user.id == friend.id;
          });
          return friend;
        });
      })
      .joining((user) => {
        this.friends = this.friends.map((friend) => {
          if (friend.id == user.id) {
            friend.online = true;
          }
          return friend;
        });
      })
      .leaving((user) => {
        this.friends = this.friends.map((friend) => {
          if (friend.id == user.id) {
            friend.online = false;
          }
          return friend;
        });
      })
      .error((error) => {
        console.error(error);
      });
  },
  methods: {
    listenForEverySession(friend) {
      Echo.private(`Session.${friend.session.id}`).listen(
        "PrivateChatEvent",
        (e) => {
          !friend.session.open ? friend.session.unread_chats_count++ : "";
        }
      );
    },
    async getFriends() {
      try {
        const res = await axios.get("/friends");
        this.friends = res.data.data;
        this.friends.forEach((friend) => {
          friend.session ? this.listenForEverySession(friend) : "";
        });
      } catch (error) {
        console.log(error);
      }
    },
    close(friend) {
      friend.session.open = false;
    },
    openChat(friend) {
      this.friends.forEach((f) => {
        if (f.session) {
          f.session.open = false;
        }
      });

      if (friend.session) {
        friend.session.open = true;
        friend.session.unread_chats_count = 0;
      } else {
        this.createSession(friend);
      }
    },
    async createSession(friend) {
      try {
        const res = await axios.post("sessions", { friend_id: friend.id });
        friend.session = res.data.data;
        friend.session.open = true;
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
