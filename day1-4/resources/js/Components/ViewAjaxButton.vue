<template>
  <div>
    <!-- Button to trigger modal -->
    <button @click="openModal" class="btn btn-info btn-sm">
      View Details
    </button>

    <!-- Modal -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Post Details</h3>
          <button @click="closeModal" class="close-btn">&times;</button>
        </div>
        <div class="modal-body" v-if="post">
          <div class="mb-3">
            <strong>Title:</strong> {{ post.title }}
          </div>
          <div class="mb-3">
            <strong>Description:</strong> {{ post.description }}
          </div>
          <div class="mb-3">
            <strong>User Name:</strong> {{ post.user.name }}
          </div>
          <div class="mb-3">
            <strong>User Email:</strong> {{ post.user.email }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      showModal: false,
      post: null
    }
  },
  methods: {
    async openModal() {
      try {
        const response = await axios.get(`/api/posts/${this.id}`);
        this.post = response.data.data;
        this.showModal = true;
      } catch (error) {
        console.error('Error fetching post:', error);
      }
    },
    closeModal() {
      this.showModal = false;
    }
  }
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 500px;
  max-width: 90%;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
}
</style>
