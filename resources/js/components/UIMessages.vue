<template>
  <transition  class="w-full relative" name="fadeAway">
    <div v-if="error">
      <div class="error-block">
        <h3 class="flex justify-center error-status">{{ error.status }}</h3>
        <h3 class="flex justify-center error-status-text">{{ error.statusText }}</h3>
      </div>
    </div>
  </transition>
</template>

<script>
import { mapGetters, mapState, mapMutations } from 'vuex';

export default {
    name: "UIMessages",

    computed: {
      ...mapGetters({error:'error'}),
      ...mapState({error: state => state.posts.error}),

      currentPath() {
        return this.$route.path;
      },
    },
    methods: {
      ...mapMutations(['setErrors'])
    },

    watch: {
      currentPath() {
        this.setErrors('')
      }
    }
}
</script>

<style scoped>

.fadeAway-enter-active {
  transition: all 0.3s ease;
}

.fadeAway-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.fadeAway-leave-to,
.fadeAway-enter {
  opacity: 0;
  transform: translateX(100px);
}

.error-block {
  position: relative;
  width: 100%;
  height: 100%;
  margin-left: auto;
  margin-right: auto;
}
.error-status {
  position: absolute;
  height: 100%;
  left: 50%;
  top:300px;
  transform: translate(-50%, 0 );
  color: rgba(182, 179, 179, 0.172);
  font-size: 8rem;
  font-weight: bold;
}
.error-status-text {
  position: absolute;
  height: 100%;
  left: 50%;
  top: 200px;
  transform: translate(-50%, 0 );
  color: rgba(182, 179, 179, 0.172);
  font-size: 2rem;
  font-weight: bold;
  text-align: center;
}


</style>